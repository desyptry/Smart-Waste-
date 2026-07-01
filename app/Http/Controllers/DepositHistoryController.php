<?php

namespace App\Http\Controllers;

use App\Models\PickupSchedule;
use App\Models\DepositDetail;
use Illuminate\Http\Request;

class DepositHistoryController extends Controller
{
    /**
     * Menampilkan riwayat timbangan berdasarkan ID Jadwal
     */
    public function index($id)
    {
        // 1. Pastikan jadwal operasional ada
        $schedule = PickupSchedule::findOrFail($id);

        // 2. Ambil semua log detail timbangan yang terikat dengan jadwal ini melalui tabel waste_deposits
        $depositDetails = DepositDetail::with([
            'wasteDeposit.user', 
            'wastePrice.wasteCategory'
        ])
        ->whereHas('wasteDeposit', function ($query) use ($id) {
            $query->where('pickup_schedule_id', $id);
        })
        ->latest('created_at') // Urutkan dari inputan terbaru
        ->get();

        return view('officer.jadwal.detail-jadwal.riwayat.index', compact('schedule', 'depositDetails'));
    }
}
