<?php

namespace App\Http\Controllers;

use App\Models\OfficerDetail;
use App\Models\PickupSchedule;
use App\Models\User;
use App\Models\SchedulePrice;
use App\Models\WasteDeposit;
use App\Models\DepositDetail;

use App\Http\Requests\PickupScheduleRequest; 
use App\Http\Requests\WasteDepositRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PickupScheduleController extends Controller
{
    public function index()
    {
        // 1. Ambil detail record petugas berdasarkan ID user yang sedang login
        $officerDetail = OfficerDetail::where('user_id', auth()->id())->firstOrFail();

        // 2. Ambil jadwal berdasarkan officer_id (ID dari tabel officer_details)
        $pickup_schedules = PickupSchedule::with('dropOffPoint')
                            ->where("officer_id", $officerDetail->id) 
                            ->get();

        return view("officer.jadwal.index", compact("pickup_schedules"));
    }

    public function create()
    {
        // Ambil data detail petugas beserta titik kumpulnya berdasarkan user yang login
        $dropOffPoints = OfficerDetail::with('dropOffPoint')
                            ->where('user_id', auth()->id())
                            ->get();

        // $dropOffPoint = $officerDetail->dropOffPoint;

        return view('officer.jadwal.create', compact('dropOffPoints'));
    }

public function store(PickupScheduleRequest $request)
    {
        $officerDetail = OfficerDetail::where('user_id', auth()->id())->firstOrFail();

        $validated = $request->validated();
        
        // ID Petugas tetap di-inject dari server demi keamanan
        $validated['officer_id'] = $officerDetail->id; 

        // BARIS INI DIHAPUS karena sudah dinamis dari form select:
        // $validated['collection_point_id'] = $officerDetail->collection_point_id;

        PickupSchedule::create($validated);

        return redirect()->route('officer.jadwal')->with('success', 'Jadwal pengumpulan berhasil ditambahkan!');
    }

    public function show($id)
    {
        // 1. Ambil data jadwal beserta relasi detail petugas dan user-nya
        $schedule = PickupSchedule::with(['dropOffPoint', 'officer.user'])->findOrFail($id);

        // 2. Ambil seluruh transaksi setoran (waste_deposits) yang terkait dengan jadwal ini
        $depositsQuery = WasteDeposit::where('pickup_schedule_id', $id);

        // 3. Hitung Agregasi Riil dari Relasi Detail Transaksi menggunakan Query Builder / Eloquent
        // Menghitung total massa berat sampah (Kg)
        $totalMassa = DepositDetail::whereHas('wasteDeposit', function ($query) use ($id) {
                            $query->where('pickup_schedule_id', $id);
                        })->sum('weight_kg') ?? 0.00;

        // Menghitung total perputaran kas saldo rupiah (Rp)
        $totalKas = DepositDetail::whereHas('wasteDeposit', function ($query) use ($id) {
                        $query->where('pickup_schedule_id', $id);
                    })->sum('total_price') ?? 0;

        // Menghitung jumlah nasabah unik yang ikut menyetor pada sesi jadwal ini
        $totalNasabah = $depositsQuery->distinct('user_id')->count('user_id');

        // 4. Ambil 3 Transaksi Terbaru (Master Detail Gabungan) untuk ditampilkan di widget riwayat ringkas
        $recentTransactions = DepositDetail::with(['wasteDeposit.user', 'wastePrice.wasteCategory'])
                                ->whereHas('wasteDeposit', function ($query) use ($id) {
                                    $query->where('pickup_schedule_id', $id);
                                })
                                ->latest()
                                ->take(3)
                                ->get();

        return view('officer.jadwal.detail-jadwal.index', compact(
            'schedule', 
            'totalMassa', 
            'totalKas', 
            'totalNasabah',
            'recentTransactions'
        ));
    }
    
 /**
     * Menampilkan Form Edit Jadwal Pengumpulan
     */
    public function edit($id)
    {
        // 1. Ambil data jadwal yang ingin diubah, pastikan milik petugas yang login (opsional untuk keamanan)
        $schedule = PickupSchedule::findOrFail($id);

        // 2. Ambil list drop-off point yang terikat dengan petugas yang login seperti pada halaman create
        $dropOffPoints = OfficerDetail::with('dropOffPoint')
                            ->where('user_id', auth()->id())
                            ->get();

        return view('officer.jadwal.edit', compact('schedule', 'dropOffPoints'));
    }

    /**
     * Memperbarui Data Jadwal ke Database
     */
    public function update(PickupScheduleRequest $request, $id)
    {
        // 1. Ambil data jadwal target
        $schedule = PickupSchedule::findOrFail($id);

        // 2. Validasi data input (Gunakan Request yang sama dengan store atau sesuaikan)
        $validated = $request->validated();

        // 3. Update data ke database
        $schedule->update($validated);

        return redirect()->route('officer.jadwal')
                         ->with('success', 'Jadwal pengumpulan berhasil diperbarui!');
    }
    /**
     * Menampilkan Halaman Kelola Setoran dari Jadwal Terkait
     */
    public function setoran($id)
    {
        $schedule = PickupSchedule::with('dropOffPoint')->findOrFail($id);

        // Ambil semua user dengan peran/role Nasabah (Masyarakat)
        $nasabahList = User::where('role', 'citizen')
                            ->get();

        // Ambil daftar komoditas harga sampah yang berlaku KHUSUS untuk jadwal operasional ini
        $availablePrices = SchedulePrice::with('wasteCategory')
                            ->where('pickup_schedule_id', $id)
                            ->get();

        return view('officer.jadwal.detail-jadwal.setoran.index', compact('schedule', 'nasabahList', 'availablePrices'));
    }

    /**
     * Menyimpan Transaksi Timbangan Multi-Item (Master Detail)
     */
    public function storeSetoran(WasteDepositRequest $request, $id)
    {
        $schedule = PickupSchedule::findOrFail($id);
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // 1. Simpan baris induk transaksi (waste_deposits) menggunakan ID Petugas yang sedang login
            $deposit = WasteDeposit::create([
                'user_id'            => $validated['user_id'],
                'drop_off_point_id'  => $schedule->drop_off_point_id ?? $schedule->dropOffPoint->id ?? null,
                'pickup_schedule_id' => $schedule->id,
                'officer_id'         => auth()->id(), 
                'deposit_date'       => now(),
            ]);

            // 2. Loop & Simpan ke tabel Anak (deposit_details)
            $totalDepositValue = 0;
            foreach ($validated['items'] as $item) {
                DepositDetail::create([
                    'waste_deposit_id' => $deposit->id,
                    'waste_price_id'   => $item['waste_price_id'],
                    'weight_kg'        => $item['weight_kg'],
                    'total_price'      => $item['total_price'],
                ]);
                $totalDepositValue += $item['total_price'];
            }
             // 3. Update saldo digital nasabah (CitizenDetail)
            $citizenDetail = \App\Models\CitizenDetail::firstOrCreate(
                ['user_id' => $validated['user_id']],
                ['balance' => 0]
            );
            $citizenDetail->balance += $totalDepositValue;
            $citizenDetail->save();
            DB::commit();
            return redirect()->route('officer.jadwal.detail', $id)
                              ->with('success', 'Transaksi setoran nasabah berhasil disimpan, masuk log timbangan, dan saldo nasabah bertambah!');


        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan Halaman Kelola Harga Sampah dari Jadwal Terkait
     */
    public function harga($id)
    {
        $schedule = PickupSchedule::with(['dropOffPoint', 'wastePriceSchedules'])->findOrFail($id);

        return view('officer.jadwal.detail-jadwal.harga.index', compact('schedule'));
    }

    /**
     * Menghapus Jadwal Terpilih
     */
public function destroy($id)
{
    $schedule = PickupSchedule::findOrFail($id);

    // Cek apakah sudah ada transaksi yang terikat dengan jadwal ini
    $hasTransactions = \App\Models\WasteDeposit::where('pickup_schedule_id', $id)->exists();

    if ($hasTransactions) {
        return redirect()->route('officer.jadwal')
                         ->with('error', 'Jadwal tidak dapat dihapus karena sudah memiliki rekapan log transaksi timbangan nasabah!');
    }

    // Jika bersih dari transaksi, baru jalankan fungsi hapus
    $schedule->delete();

    return redirect()->route('officer.jadwal')->with('success', 'Jadwal operasional sukses dihapus!');
}
}