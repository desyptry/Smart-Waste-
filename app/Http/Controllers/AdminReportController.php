<?php

namespace App\Http\Controllers;

use App\Models\WasteDeposit;
use App\Models\DepositDetail;
use App\Models\Withdrawal;
use App\Models\PickupSchedule;
use App\Models\DropOffPoint;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        // --- 1. PROSES FILTER UTAMA ---
        $startDate = $request->filled('start_date') ? $request->start_date . ' 00:00:00' : null;
        $endDate = $request->filled('end_date') ? $request->end_date . ' 23:59:59' : null;
        $doPointId = $request->drop_off_point_id;

        // --- 2. QUERY WIDGET STATISTIK GLOBAL ---
        // A. Total Sampah Terkumpul (Massa Kg)
        $massaQuery = DepositDetail::whereHas('wasteDeposit');
        if ($startDate && $endDate) {
            $massaQuery->whereHas('wasteDeposit', function($q) use ($startDate, $endDate) {
                $q->whereBetween('deposit_date', [$startDate, $endDate]);
            });
        }
        if ($doPointId) {
            $massaQuery->whereHas('wasteDeposit', function($q) use ($doPointId) {
                $q->where('drop_off_point_id', $doPointId);
            });
        }
        $grandTotalMassa = $massaQuery->sum('weight_kg');

        // B. Total Dana Setoran (Kas yang disalurkan ke saldo warga)
        $kasQuery = DepositDetail::whereHas('wasteDeposit');
        if ($startDate && $endDate) {
            $kasQuery->whereHas('wasteDeposit', function($q) use ($startDate, $endDate) {
                $q->whereBetween('deposit_date', [$startDate, $endDate]);
            });
        }
        if ($doPointId) {
            $kasQuery->whereHas('wasteDeposit', function($q) use ($doPointId) {
                $q->where('drop_off_point_id', $doPointId);
            });
        }
        $grandTotalKasKeluar = $kasQuery->sum('total_price');

        // C. Audit Finansial Penarikan (Withdrawal)
        $wdPending = Withdrawal::where('status', 'pending');
        $wdSuccess = Withdrawal::where('status', 'approved');
        if ($startDate && $endDate) {
            $wdPending->whereBetween('created_at', [$startDate, $endDate]);
            $wdSuccess->whereBetween('created_at', [$startDate, $endDate]);
        }
        $totalWdPending = $wdPending->sum('amount');
        $totalWdSuccess = $wdSuccess->sum('amount');


        // --- 3. AMBIL DATA TABEL UTAMA (DENGAN PAGINASI TERPISAH) ---
        
        // Tabel A: Log Master Setoran Sampah (Semua Petugas)
        $depositQuery = WasteDeposit::with(['user', 'dropOffPoint', 'officer'])
            ->withSum('depositDetails as total_weight', 'weight_kg')
            ->withSum('depositDetails as total_price', 'total_price');
        
        if ($startDate && $endDate) {
            $depositQuery->whereBetween('deposit_date', [$startDate, $endDate]);
        }
        if ($doPointId) {
            $depositQuery->where('drop_off_point_id', $doPointId);
        }
        if ($request->filled('search')) {
            $depositQuery->where(function($sub) use ($request) {
                $sub->whereHas('user', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })->orWhere('id', 'like', '%' . $request->search . '%');
            });
        }
        $depositReports = $depositQuery->latest('deposit_date')->paginate(10, ['*'], 'deposit_page')->withQueryString();

        // Tabel B: Arus Finansial Jurnal Penarikan Dana (Withdrawals)
        $withdrawalQuery = Withdrawal::with(['user']);
        if ($startDate && $endDate) {
            $withdrawalQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        if ($request->filled('wd_status')) {
            $withdrawalQuery->where('status', $request->wd_status);
        }
        $withdrawalLogs = $withdrawalQuery->latest()->paginate(5, ['*'], 'wd_page')->withQueryString();

        // Tabel C: Kalender Manifes Jadwal Operasional
        $scheduleQuery = PickupSchedule::with(['dropOffPoint'])->withCount('wasteDeposits as total_trx');
        if ($startDate && $endDate) {
            $scheduleQuery->whereBetween('start_date', [$startDate, $endDate]);
        }
        $schedules = $scheduleQuery->latest('start_date')->paginate(5, ['*'], 'sch_page')->withQueryString();


        // --- 4. DATA COMPONENT DROPDOWN ---
        $dropOffPoints = DropOffPoint::all();

        return view('admin.laporan.index', compact(
            'grandTotalMassa', 'grandTotalKasKeluar', 'totalWdPending', 'totalWdSuccess',
            'depositReports', 'withdrawalLogs', 'schedules', 'dropOffPoints'
        ));
    }

    // Ekspor Excel untuk seluruh data transaksi (Akses Admin)
    public function exportGlobalExcel(Request $request)
    {
        $deposits = WasteDeposit::with(['user', 'officer', 'dropOffPoint'])
            ->withSum('depositDetails as total_weight', 'weight_kg')
            ->withSum('depositDetails as total_price', 'total_price')
            ->latest('deposit_date')->get();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Jurnal_Audit_Global_Sistem_'.date('Y-m-d').'.xls"');

        echo '<table border="1">
            <tr><th colspan="7" style="background-color:#1E293B; color:white; font-weight:bold; height:30px;">KONSOLIDASI DATA JURNAL GLOBAL</th></tr>
            <tr style="background-color:#F1F5F9; font-weight:bold;">
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Nasabah</th>
                <th>Petugas Lapangan</th>
                <th>Lokasi Posko</th>
                <th>Massa (Kg)</th>
                <th>Kas Keluar (Rp)</th>
            </tr>';
        foreach($deposits as $d) {
            echo '<tr>
                <td>#TRX-'.$d->id.'</td>
                <td>'.$d->deposit_date.'</td>
                <td>'.($d->user->name ?? 'Masyarakat Umum').'</td>
                <td>'.($d->officer->name ?? '-').'</td>
                <td>'.($d->dropOffPoint->name ?? '-').'</td>
                <td>'.number_format($d->total_weight, 2).'</td>
                <td>'.number_format($d->total_price, 0).'</td>
            </tr>';
        }
        echo '</table>';
        exit;
    }
}