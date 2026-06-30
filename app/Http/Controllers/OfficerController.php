<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PickupSchedule;
use App\Models\WasteDeposit;
use App\Models\DepositDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OfficerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $officerDetail = $user->officerDetail;
        $officerDetailId = $officerDetail->id ?? null;

        // Greeting
        $hour = date('H');
        if ($hour < 12) {
            $greeting = "Pagi";
        } elseif ($hour < 17) {
            $greeting = "Siang";
        } else {
            $greeting = "Malam";
        }

        // 1. Total Pendapatan Hari Ini (Total price collected by this officer today)
        $totalPendapatanHariIni = DepositDetail::whereHas('wasteDeposit', function ($q) use ($user) {
            $q->where('officer_id', $user->id)
              ->whereDate('deposit_date', today());
        })->sum('total_price');

        // 2. Warga Aktif (Active Citizen)
        $wargaAktif = User::where('role', 'citizen')->count();

        // 3. Total Sampah (Total weight of waste collected by this officer)
        $totalSampah = DepositDetail::whereHas('wasteDeposit', function ($q) use ($user) {
            $q->where('officer_id', $user->id);
        })->sum('weight_kg');

        // 4. Setoran Hari Ini (Deposit count collected by this officer today)
        $setoranHariIni = WasteDeposit::where('officer_id', $user->id)
            ->whereDate('deposit_date', today())
            ->count();

        // 5. Perlu Verifikasi (Pickup schedules assigned to this officer that are not-verified)
        $perluVerifikasi = PickupSchedule::where('officer_id', $officerDetailId)
            ->where('status', 'not-verified')
            ->count();

        // 6. Jadwal & Lokasi Pengumpulan (Upcoming schedules for this officer)
        $schedules = PickupSchedule::with('dropOffPoint')
            ->where('officer_id', $officerDetailId)
            ->where('status', 'verified')
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        // 7. Riwayat Pengumpulan Sampah (All-time total price collected by this officer)
        $totalPendapatanAllTime = DepositDetail::whereHas('wasteDeposit', function ($q) use ($user) {
            $q->where('officer_id', $user->id);
        })->sum('total_price');

        return view('officer.dashboard', compact(
            'greeting',
            'totalPendapatanHariIni',
            'wargaAktif',
            'totalSampah',
            'setoranHariIni',
            'perluVerifikasi',
            'schedules',
            'totalPendapatanAllTime'
        ));
    }
}
