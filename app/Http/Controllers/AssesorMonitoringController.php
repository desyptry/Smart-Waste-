<?php

namespace App\Http\Controllers;

use App\Models\WasteDeposit;
use App\Models\DepositDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssesorMonitoringController extends Controller
{
    public function index(Request $request)
    {
        // 1. STATISTIK SUPERVISI GLOBAL
        $totalMassa = DepositDetail::sum('weight_kg');
        $totalPerputaranKas = DepositDetail::sum('total_price');
        
        // Menghitung berapa banyak tindakan penolakan jadwal/harga yang telah dilakukan assessor
        $totalOfficerAktif = User::where('role', 'officer')->count();

        // 2. QUERY UTAMA JURNAL MONITORING (Melihat Kerja Officer & Setoran Warga)
        $query = WasteDeposit::with(['user', 'dropOffPoint', 'officer'])
            ->withSum('depositDetails as total_weight', 'weight_kg')
            ->withSum('depositDetails as total_price', 'total_price');

        // Filter Tanggal jika diterapkan oleh Assessor
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('deposit_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // Filter spesifik berdasarkan Officer yang bertugas (Fungsi Pengawasan Assessor terhadap Officer)
        if ($request->filled('officer_id')) {
            $query->where('officer_id', $request->officer_id);
        }

        $logs = $query->latest('deposit_date')->paginate(10)->withQueryString();
        $officers = User::where('role', 'officer')->get(); // Untuk dropdown filter

        return view('assesor.laporan.index', compact('logs', 'totalMassa', 'totalPerputaranKas', 'totalOfficerAktif', 'officers'));
    }
}