<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\PickupSchedule; // Sesuaikan dengan nama model jadwal penjemputan Anda
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssesorController extends Controller
{
    public function index()
    {
        // 1. Jumlah penarikan (withdrawal) yang belum diapprove (status pending)
        $pendingWithdrawalsCount = Withdrawal::where('status', 'pending')->count();

        // 2. Jumlah transaksi withdrawal yang sukses/approved dalam hari ini
        $todayApprovedWithdrawalsCount = Withdrawal::where('status', 'approved')
            ->whereDate('approved_at', Carbon::today())
            ->count();

        // 3. Jumlah jadwal yang belum diapproved (status pending)
        // Sesuaikan 'status' dengan nama kolom verifikasi pada model jadwal Anda
        $pendingSchedulesCount = PickupSchedule::where('status', 'pending')->count();

        return view('assesor.dashboard', compact(
            'pendingWithdrawalsCount',
            'todayApprovedWithdrawalsCount',
            'pendingSchedulesCount'
        ));
    }
}
