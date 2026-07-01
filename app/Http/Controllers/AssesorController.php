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
        $assesorId = auth()->id();
        // 1. Hitung Penarikan Belum Diapprove (Status: pending)
        $pendingWithdrawalsCount = Withdrawal::where('status', 'pending')
            ->where('asessor_id', $assesorId)
            ->count();

        // 2. Hitung Withdrawal Selesai Hari Ini (Status: approved, tanggal hari ini)
        $todayApprovedWithdrawalsCount = Withdrawal::where('status', 'approved')
            ->where('asessor_id', $assesorId)
            ->whereDate('updated_at', Carbon::today())
            ->count();

         // 3. Hitung Jadwal Belum Diapprove (Status: not-verified)
        $pendingSchedulesCount = PickupSchedule::where('status', 'not-verified')
            ->whereHas('dropOffPoint', function ($query) use ($assesorId) {
                $query->where('assesor_id', $assesorId);
            })
            ->count();

        // 4. Ambil Daftar Antrean Jadwal Terkini (Maksimal 5 data terlama/terkini yang not-verified)
        $recentSchedules = PickupSchedule::with('dropOffPoint')
            ->where('status', 'not-verified')
            ->whereHas('dropOffPoint', function ($query) use ($assesorId) {
                $query->where('assesor_id', $assesorId);
            })
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