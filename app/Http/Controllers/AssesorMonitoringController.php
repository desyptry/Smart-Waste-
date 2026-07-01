<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\PickupSchedule;
use Illuminate\Http\Request;

class AssesorMonitoringController extends Controller
{
    public function index(Request $request)
    {
        // 1. STATISTIK SUPERVISI GLOBAL (Selalu murni akumulasi total tanpa terpengaruh filter)
        $totalPendingDana = Withdrawal::where('status', 'pending')->sum('amount');
        $totalDicairkan   = Withdrawal::where('status', 'approved')->sum('amount');
        $totalPenolakan   = Withdrawal::where('status', 'rejected')->count();

        // 2. QUERY LAPORAN 1: PENARIKAN SALDO (WITHDRAWALS)
        $withdrawalQuery = Withdrawal::with(['user', 'asessor']);

        // 3. QUERY LAPORAN 2: JADWAL DROP-OFF (PICKUP SCHEDULES VERIFIED)
        $scheduleQuery = PickupSchedule::with(['dropOffPoint'])
            ->where('status', 'verified');

        // --- CORE FIX: PROSES LOGIKA FILTER REQUEST ---
        
        // Filter Berdasarkan Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $dateRange = [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'];
            
            $withdrawalQuery->whereBetween('created_at', $dateRange);
            $scheduleQuery->whereBetween('start_date', $dateRange); 
        }

        // Filter Berdasarkan Metode Pembayaran (Hanya berdampak pada tabel keuangan/Withdrawal)
        if ($request->filled('method')) {
            $withdrawalQuery->where('method', $request->method);
        }

        // Filter Berdasarkan Nama Bank / Dompet (Mencari teks yang mirip di kolom account_name)
        if ($request->filled('account_name')) {
            $withdrawalQuery->where('account_name', 'LIKE', '%' . $request->account_name . '%');
        }

        // Ambil data dengan penomoran halaman (paginasi) terpisah
        $withdrawalLogs = $withdrawalQuery->latest()->paginate(5, ['*'], 'wd_page')->withQueryString();
        $scheduleLogs   = $scheduleQuery->latest('start_date')->paginate(5, ['*'], 'sch_page')->withQueryString();

        return view('assesor.laporan.index', compact(
            'withdrawalLogs', 
            'scheduleLogs',
            'totalPendingDana', 
            'totalDicairkan', 
            'totalPenolakan'
        ));
    }

    public function exportExcel(Request $request)
    {
        $withdrawalQuery = Withdrawal::with(['user']);
        $scheduleQuery = PickupSchedule::with(['dropOffPoint'])->where('status', 'verified');

        // --- PENYELARASAN FILTER UNTUK EKSPOR EXCEL ---
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $dateRange = [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'];
            $withdrawalQuery->whereBetween('created_at', $dateRange);
            $scheduleQuery->whereBetween('start_date', $dateRange);
        }

        if ($request->filled('method')) {
            $withdrawalQuery->where('method', $request->method);
        }

        if ($request->filled('account_name')) {
            $withdrawalQuery->where('account_name', 'LIKE', '%' . $request->account_name . '%');
        }

        $withdrawals = $withdrawalQuery->latest()->get();
        $schedules = $scheduleQuery->latest('start_date')->get();

        // Setup Header Unduhan Excel
        $fileName = "Laporan_Audit_Assessor_" . date('Y-m-d') . ".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Print Metadata
        echo "<h3>LAPORAN AUDIT GLOBAL ASSESSOR</h3>";
        echo "<p>Tanggal Ekspor: " . date('d-m-Y H:i') . " Wita</p>";
        if($request->filled('start_date')) {
            echo "<p>Periode Tanggal: " . $request->start_date . " s/d " . $request->end_date . "</p>";
        }
        if($request->filled('method')) {
            echo "<p>Filter Metode: " . strtoupper(str_replace('_', ' ', $request->method)) . "</p>";
        }
        if($request->filled('account_name')) {
            echo "<p>Filter Bank/Dompet: " . strtoupper($request->account_name) . "</p>";
        }
        echo "<br>";

        // --- TABEL 1: WITHDRAWALS ---
        echo "<table border='1'>";
        echo "<tr><th colspan='8' style='background-color:#f89406; color:white; font-weight:bold;'>JURNAL PENCAIRAN DANA (WITHDRAWALS)</th></tr>";
        echo "<tr style='background-color:#f2f2f2; font-weight:bold;'>
                <th>ID Transaksi</th>
                <th>Tanggal Pengajuan</th>
                <th>Nama Warga</th>
                <th>Metode Pembayaran</th>
                <th>Nama Bank / E-Wallet</th>
                <th>Nama Pemilik Rekening</th>
                <th>Nomor Rekening / HP</th>
                <th>Nominal Penarikan (Rp)</th>
              </tr>";
              
        foreach ($withdrawals as $w) {
            $methodLabel = strtoupper(str_replace('_', ' ', $w->method));
            echo "<tr>
                    <td>#WD-{$w->id}</td>
                    <td>{$w->created_at}</td>
                    <td>" . ($w->user->name ?? 'N/A') . "</td>
                    <td>{$methodLabel}</td>
                    <td>" . strtoupper($w->account_name ?? '-') . "</td> 
                    <td>" . ($w->user->name ?? '-') . "</td>       
                    <td>'{$w->account_number}</td>                 
                    <td>" . number_format($w->amount, 0, ',', '.') . "</td>
                  </tr>";
        }
        echo "</table>";

        echo "<br><br>";

        // --- TABEL 2: PICKUP SCHEDULES ---
        echo "<table border='1'>";
        echo "<tr><th colspan='4' style='background-color:#149bdf; color:white; font-weight:bold;'>MANIFES JADWAL DROP-OFF SAMPAH (VERIFIED)</th></tr>";
        echo "<tr style='background-color:#f2f2f2; font-weight:bold;'>
                <th>ID Jadwal</th>
                <th>Waktu Mulai Kedatangan</th>
                <th>Titik Drop-Off Point</th>
                <th>Status Validasi</th>
              </tr>";
              
        foreach ($schedules as $s) {
            echo "<tr>
                    <td>#SCH-{$s->id}</td>
                    <td>{$s->start_date}</td>
                    <td>" . ($s->dropOffPoint->name ?? 'Pusat Lapangan') . "</td>
                    <td>" . strtoupper($s->status) . "</td>
                  </tr>";
        }
        echo "</table>";
        
        exit;
    }
}