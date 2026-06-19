<?php

namespace App\Http\Controllers;

use App\Models\OfficerDetail;
use App\Models\PickupSchedule;
use App\Models\User;
use App\Models\SchedulePrice;
use App\Models\WasteDeposit;
use App\Models\DepositDetail;

use App\Http\Requests\PickupScheduleRequest; // Perbaikan namespace request
use App\Http\Requests\WasteDepositRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PickupScheduleController extends Controller
{
    public function index()
    {
        $userId = 2; // Nanti diganti jadi auth()->id()
        
        // 1. Cari dulu detail record petugas berdasarkan user_id yang login
        $officerDetail = OfficerDetail::where('user_id', $userId)->firstOrFail();

        // 2. Cari jadwal berdasarkan officer_id (ID dari tabel officer_details)
        // Gunakan eager loading 'dropOffPoint' (tanpa 's' sesuai nama relasi belongsTo di model)
        $pickup_schedules = PickupSchedule::with('dropOffPoint')
                            ->where("officer_id", $officerDetail->id) 
                            ->get();

        return view("officer.jadwal.index", compact("pickup_schedules"));
    }

    public function create()
    {
        $userId = 2; // Nanti diganti jadi auth()->id()

        $officerDetail = OfficerDetail::with('dropOffPoint')
                            ->where('user_id', $userId)
                            ->firstOrFail();

        $dropOffPoint = $officerDetail->dropOffPoint;

        return view('officer.jadwal.create', compact('dropOffPoint'));
    }

    public function store(PickupScheduleRequest $request)
    {
        $userId = 2; // Nanti diganti jadi auth()->id()
        
        $officerDetail = OfficerDetail::where('user_id', $userId)->firstOrFail();

        $validated = $request->validated();
        
        // Inject ID detail petugas dan ID titik kumpulnya langsung dari server
        $validated['officer_id'] = $officerDetail->id; 
        $validated['collection_point_id'] = $officerDetail->collection_point_id;

        PickupSchedule::create($validated);

        return redirect()->route('officer.jadwal')->with('success', 'Jadwal pengumpulan berhasil ditambahkan!');
    }

  public function show($id)
{
    // Ambil data jadwal beserta relasi detail petugas dan user-nya
    $schedule = PickupSchedule::with(['dropOffPoint', 'officer.user'])->findOrFail($id);

    // Contoh pengambilan data agregasi riil dari relasi transaksi setoran (jika sudah ada nanti)
    // Silakan sesuaikan nama model transaksi/setoran Anda jika sudah dibuat
    $totalMassa = 0.00;   // e.g., $schedule->wasteDeposits()->sum('weight');
    $totalKas = 0;        // e.g., $schedule->wasteDeposits()->sum('total_price');
    $totalNasabah = 0;    // e.g., $schedule->wasteDeposits()->distinct('customer_id')->count();
    $recentTransactions = []; // e.g., $schedule->wasteDeposits()->latest()->take(3)->get();

    return view('officer.jadwal.detail-jadwal.index', compact(
        'schedule', 
        'totalMassa', 
        'totalKas', 
        'totalNasabah',
        'recentTransactions'
    ));
}

    /**
     * Menampilkan Halaman Kelola Setoran dari Jadwal Terkait
     */
    public function setoran($id)
    {
        // 1. Ambil data jadwal beserta titik kumpulnya
        $schedule = PickupSchedule::with('dropOffPoint')->findOrFail($id);

        // 2. Ambil semua user dengan peran/role Nasabah (Masyarakat)
        // Sesuaikan query pencarian role ini dengan sistem autentikasi aplikasi Anda
        $nasabahList = User::where('role', 'citizen')
                            ->orWhere('id', '!=', auth()->id()) // Contoh fallback jika tidak pakai role
                            ->get();

        // 3. Ambil daftar komoditas harga sampah yang berlaku KHUSUS untuk jadwal operasional ini
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
            // 1. Simpan baris induk transaksi (waste_deposits)
$deposit = WasteDeposit::create([
    'user_id'            => $validated['user_id'],
    // Menggunakan operator ?? (Null Coalescing) sebagai cadangan jika properti utama kosong
    'drop_off_point_id'  => $schedule->drop_off_point_id ?? $schedule->dropOffPoint->id ?? null,
    'pickup_schedule_id' => $schedule->id,
    'officer_id'         => auth()->id(),
    'deposit_date'       => now(),
]);


            // 2. Loop & Simpan ke tabel Anak (deposit_details)
            foreach ($validated['items'] as $item) {
                DepositDetail::create([
                    'waste_deposit_id' => $deposit->id,
                    'waste_price_id'   => $item['waste_price_id'],
                    'weight_kg'        => $item['weight_kg'],
                    'total_price'      => $item['total_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('officer.jadwal.detail', $id)
                             ->with('success', 'Transaksi setoran nasabah berhasil disimpan dan masuk log timbangan!');

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
        // Load relasi wastePriceSchedules untuk memunculkan daftar komponen harga operasional
        $schedule = PickupSchedule::with(['dropOffPoint', 'wastePriceSchedules'])->findOrFail($id);

        return view('officer.jadwal.detail-jadwal.harga.index', compact('schedule'));
    }

    /**
     * Menghapus Jadwal Terpilih
     */
    public function destroy($id)
    {
        $schedule = PickupSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('officer.jadwal')->with('success', 'Jadwal operasional pengumpulan sukses dihapus!');
    }
}
