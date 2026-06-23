<?php

namespace App\Http\Controllers;

use App\Models\WasteDeposit;
use App\Models\DepositDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Menampilkan halaman utama monitoring (Daftar Nota)
    public function index(Request $request)
    {
        $query = WasteDeposit::with(['user', 'dropOffPoint', 'officer'])
            ->withSum('depositDetails as total_weight', 'weight_kg')
            ->withSum('depositDetails as total_price', 'total_price')
            ->withCount('depositDetails as total_items');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('deposit_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $totalMassa = DepositDetail::whereHas('wasteDeposit', function($q) use ($request) {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('deposit_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            }
        })->sum('weight_kg');

        $totalKas = DepositDetail::whereHas('wasteDeposit', function($q) use ($request) {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('deposit_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            }
        })->sum('total_price');

        $totalTransaksi = $query->count();
        $reports = $query->latest('deposit_date')->paginate(10)->withQueryString();

        return view('officer.laporan.index', compact('reports', 'totalMassa', 'totalKas', 'totalTransaksi'));
    }

    // Menampilkan Halaman Detail Transaksi Terpisah (Dedicated Page)
    public function showPage($id)
    {
        $deposit = WasteDeposit::with(['user', 'dropOffPoint', 'officer', 'depositDetails.wastePrice.wasteCategory'])->findOrFail($id);
        return view('officer.laporan.show', compact('deposit'));
    }

    // Export Satu Nota Tertentu ke Excel (Manifest Struk Tunggal)
    public function exportSingleExcel($id)
    {
        $deposit = WasteDeposit::with(['user', 'dropOffPoint', 'officer', 'depositDetails.wastePrice.wasteCategory'])->findOrFail($id);

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
}