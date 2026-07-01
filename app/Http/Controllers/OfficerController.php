<?php

namespace App\Http\Controllers;

use App\Models\WasteDeposit;
use App\Models\DepositDetail;
use App\Models\PickupSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OfficerController extends Controller
{
    public function index()
    {
        $officerId = auth()->id();

        // 1. Total Kas Keluar / Transaksi Hari Ini oleh Officer Ini
        $todayCashOut = WasteDeposit::where('officer_id', $officerId)
            ->whereDate('deposit_date', Carbon::today())
            ->withSum('depositDetails as total_price', 'total_price')
            ->get()
            ->sum('total_price');

        // 2. Statistik Grid Kartu
        $totalWargaAktif = User::where('role', 'citizen')->count();
        
        $totalSampahMassa = DepositDetail::whereHas('wasteDeposit', function($q) use ($officerId) {
            $q->where('officer_id', $officerId);
        })->sum('weight_kg');

        $todayDepositsCount = WasteDeposit::where('officer_id', $officerId)
            ->whereDate('deposit_date', Carbon::today())
            ->count();

        // Jadwal milik Officer ini yang ditolak atau belum diverifikasi oleh Assessor
        $pendingVerificationSchedules = PickupSchedule::where('status', 'not-verified')
            ->count();

        // 3. Ambil Daftar Jadwal Kerja Officer Terkini
        $schedules = PickupSchedule::with(['dropOffPoint'])
            ->orderBy('start_date', 'desc')
            ->take(5)
            ->get();

        // 4. Total Akumulasi Kas Keluar Periode Bulan Ini (Untuk Footer)
        $monthCashOut = WasteDeposit::where('officer_id', $officerId)
            ->whereMonth('deposit_date', Carbon::now()->month)
            ->whereYear('deposit_date', Carbon::now()->year)
            ->withSum('depositDetails as total_price', 'total_price')
            ->get()
            ->sum('total_price');

        return view('officer.dashboard', compact(
            'todayCashOut',
            'totalWargaAktif',
            'totalSampahMassa',
            'todayDepositsCount',
            'pendingVerificationSchedules',
            'schedules',
            'monthCashOut'
        ));
    }
}