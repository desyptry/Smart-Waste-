<?php

namespace App\Http\Controllers;

use App\Models\WasteDeposit;
use App\Models\DepositDetail;
use App\Models\PickupSchedule;
use App\Models\DropOffPoint;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Menampilkan halaman utama monitoring (Daftar Nota) untuk Officer
    public function index(Request $request)
    {
        $officerId = auth()->id(); // Batasan Transaksi: Hanya mengambil data milik petugas yang login

        $query = WasteDeposit::with(['user', 'dropOffPoint', 'officer'])
            ->where('officer_id', $officerId) // Isolate data
            ->withSum('depositDetails as total_weight', 'weight_kg')
            ->withSum('depositDetails as total_price', 'total_price')
            ->withCount('depositDetails as total_items');

        // Fitur Filter Tambahan
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('deposit_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
        if ($request->filled('drop_off_point_id')) {
            $query->where('drop_off_point_id', $request->drop_off_point_id);
        }
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('id', 'like', '%' . $request->search . '%');
        }

        // Kalkulasi Widget Statistik Berdasarkan Scope Petugas & Filter
        $totalMassa = DepositDetail::whereHas('wasteDeposit', function($q) use ($request, $officerId) {
            $q->where('officer_id', $officerId);
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('deposit_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            }
            if ($request->filled('drop_off_point_id')) {
                $q->where('drop_off_point_id', $request->drop_off_point_id);
            }
        })->sum('weight_kg');

        $totalKas = DepositDetail::whereHas('wasteDeposit', function($q) use ($request, $officerId) {
            $q->where('officer_id', $officerId);
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('deposit_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            }
            if ($request->filled('drop_off_point_id')) {
                $q->where('drop_off_point_id', $request->drop_off_point_id);
            }
        })->sum('total_price');

        $totalTransaksi = $query->count();
        $reports = $query->latest('deposit_date')->paginate(10)->withQueryString();
        
        // Data pendukung komponen filter dropdown
        $dropOffPoints = DropOffPoint::all();
        $schedules = PickupSchedule::with('dropOffPoint')->latest()->take(30)->get();

        return view('officer.laporan.index', compact('reports', 'totalMassa', 'totalKas', 'totalTransaksi', 'dropOffPoints', 'schedules'));
    }

    // Menampilkan Halaman Detail Transaksi Terpisah (Dedicated Page)
    public function showPage($id)
    {
        // Memastikan Officer tidak bisa mengintip nota milik officer lain via perubahan URL ID
        $deposit = WasteDeposit::with(['user', 'dropOffPoint', 'officer', 'depositDetails.wastePrice.wasteCategory'])
            ->where('officer_id', auth()->id())
            ->findOrFail($id);

        return view('officer.laporan.show', compact('deposit'));
    }

    // FITUR BARU: Export Seluruh Transaksi dalam Satu Jadwal Sesi Kerja (Satu Sesi Distribusi)
    public function exportBySchedule(Request $request)
    {
        $request->validate([
            'pickup_schedule_id' => 'required|exists:pickup_schedules,id'
        ]);

        $schedule = PickupSchedule::with('dropOffPoint')->findOrFail($request->pickup_schedule_id);
        
        // Ambil semua transaksi yang bernaung di bawah jadwal ini
        $deposits = WasteDeposit::with(['user', 'officer', 'depositDetails.wastePrice.wasteCategory'])
            ->where('pickup_schedule_id', $request->pickup_schedule_id)
            ->get();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Rekap_Manifes_Jadwal_ID-'.$schedule->id.'.xls"');
        header('Cache-Control: max-age=0');

        echo '
        <table border="1">
            <tr><td colspan="7" style="font-weight:bold; text-align:center; background-color:#1E293B; color:white; height:35px;">LAPORAN MANIFES SETORAN PER JADWAL OPERASIONAL</td></tr>
            <tr><td><strong>ID JADWAL:</strong></td><td colspan="2">#'.$schedule->id.'</td><td><strong>Lokasi Posko:</strong></td><td colspan="3">'.$schedule->dropOffPoint->name.'</td></tr>
            <tr><td><strong>Tanggal Operasional:</strong></td><td colspan="6">'.\Carbon\Carbon::parse($schedule->date)->format('d-m-Y').' (Sesi: '.$schedule->start_time.' - '.$schedule->end_time.')</td></tr>
            <tr></tr>
            <tr style="background-color: #0F766E; color: white; font-weight: bold; text-align:center;">
                <th>No Nota</th>
                <th>Waktu Transaksi</th>
                <th>Nama Nasabah</th>
                <th>Petugas Lapangan</th>
                <th>Jumlah Variasi</th>
                <th>Total Muatan (Kg)</th>
                <th>Total Kas Keluar</th>
            </tr>';

        $grandWeight = 0;
        $grandCash = 0;

        foreach($deposits as $deposit) {
            $totalWeight = $deposit->depositDetails->sum('weight_kg');
            $totalPrice = $deposit->depositDetails->sum('total_price');
            $grandWeight += $totalWeight;
            $grandCash += $totalPrice;

            echo '<tr>
                <td style="text-align:center;">#TRX-'.$deposit->id.'</td>
                <td>'.\Carbon\Carbon::parse($deposit->deposit_date)->format('H:i').' Wita</td>
                <td>'.($deposit->user->name ?? 'Masyarakat Umum').'</td>
                <td>'.($deposit->officer->name ?? '-').'</td>
                <td style="text-align:center;">'.$deposit->depositDetails->count().' Jenis</td>
                <td style="text-align:right;">'.number_format($totalWeight, 2, ',', '.').' Kg</td>
                <td style="text-align:right;">Rp '.number_format($totalPrice, 0, ',', '.').'</td>
            </tr>';
        }

        echo '<tr style="font-weight:bold; background-color:#F1F5F9;">
            <td colspan="5" style="text-align:right;">TOTAL REKAPITULASI JADWAL:</td>
            <td style="text-align:right; color:#0D9488;">'.number_format($grandWeight, 2, ',', '.').' Kg</td>
            <td style="text-align:right; color:#16A34A;">Rp '.number_format($grandCash, 0, ',', '.').'</td>
        </tr>';
        echo '</table>';
        exit;
    }

    // Export Satu Nota (Sama seperti sebelumnya namun diproteksi)
    public function exportSingleExcel($id)
    {
        $deposit = WasteDeposit::with(['user', 'dropOffPoint', 'officer', 'depositDetails.wastePrice.wasteCategory'])
            ->where('officer_id', auth()->id())
            ->findOrFail($id);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Nota_Transaksi_TRX-'.$deposit->id.'.xls"');
        header('Cache-Control: max-age=0');

        echo '
        <table border="1">
            <tr><td colspan="4" style="font-weight:bold; text-align:center; background-color:#2D333D; color:white; height:30px;">STRUK NOTA SETORAN SAMPAH (#TRX-'.$deposit->id.')</td></tr>
            <tr><td><strong>ID Transaksi:</strong></td><td>#TRX-'.$deposit->id.'</td><td><strong>Tanggal Setor:</strong></td><td>'.\Carbon\Carbon::parse($deposit->deposit_date)->format('d-m-Y H:i').'</td></tr>
            <tr><td><strong>Nasabah:</strong></td><td>'.($deposit->user->name ?? 'Masyarakat Umum').'</td><td><strong>Posko Lapangan:</strong></td><td>'.($deposit->dropOffPoint->name ?? '-').'</td></tr>
            <tr><td><strong>Petugas Lapangan:</strong></td><td colspan="3">'.($deposit->officer->name ?? '-').'</td></tr>
            <tr></tr>
            <tr style="background-color: #69C3C1; color: white; font-weight: bold;">
                <th>ID Kategori</th>
                <th>Nama Komoditas Sampah</th>
                <th>Berat Massa (Kg)</th>
                <th>Subtotal Rupiah</th>
            </tr>';

            $totalWeight = 0;
            $totalPrice = 0;

            foreach($deposit->depositDetails as $detail) {
                $totalWeight += $detail->weight_kg;
                $totalPrice += $detail->total_price;
                echo '<tr>
                    <td>#CAT-'.$detail->waste_price_id.'</td>
                    <td>'.($detail->wastePrice->wasteCategory->name ?? '-').'</td>
                    <td>'.number_format($detail->weight_kg, 2, ',', '.').' Kg</td>
                    <td>Rp '.number_format($detail->total_price, 0, ',', '.').'</td>
                </tr>';
            }
            
            echo '<tr style="font-weight:bold; background-color:#F4F9FC;">
                <td colspan="2" style="text-align:right;">TOTAL AKUMULASI NOTA:</td>
                <td>'.number_format($totalWeight, 2, ',', '.').' Kg</td>
                <td style="color:#059669;">Rp '.number_format($totalPrice, 0, ',', '.').'</td>
            </tr>';
        echo '</table>';
        exit;
    }

    public function adminIndex(Request $request)
    {
        $query = WasteDeposit::with(['user', 'dropOffPoint', 'officer', 'depositDetails.wastePrice.wasteCategory'])
            ->withSum('depositDetails as total_weight', 'weight_kg')
            ->withSum('depositDetails as total_price', 'total_price');
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('deposit_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
        $reports = $query->latest('deposit_date')->paginate(15)->withQueryString();
        return view('admin.laporan.index', compact('reports'));
    }
}