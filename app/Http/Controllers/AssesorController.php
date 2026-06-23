<?php

namespace App\Http\Controllers;

use App\Models\PickupSchedule;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AssesorController extends Controller
{
    public function index()
    {
        // 1. Hitung Penarikan Belum Diapprove (Status: pending)
        $pendingWithdrawalsCount = Withdrawal::where('status', 'pending')->count();

        // 2. Hitung Withdrawal Selesai Hari Ini (Status: approved, tanggal hari ini)
        $todayApprovedWithdrawalsCount = Withdrawal::where('status', 'approved')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        // 3. Hitung Jadwal Belum Diapprove (Status: pending)
        $pendingSchedulesCount = PickupSchedule::where('status', 'pending')->count();

        // 4. Ambil Daftar Antrean Jadwal Terkini (Maksimal 5 data terlama/terkini yang pending)
        $recentSchedules = PickupSchedule::with('dropOffPoint')
            ->where('status', 'not-verified')
            ->orderBy('updated_at', 'asc')
            ->take(5)
            ->get();

        return view('assesor.dashboard', compact(
            'pendingWithdrawalsCount',
            'todayApprovedWithdrawalsCount',
            'pendingSchedulesCount',
            'recentSchedules'
        ));
    }
}