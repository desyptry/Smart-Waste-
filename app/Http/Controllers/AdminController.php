<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\DropOffPoint;
use App\Models\DepositDetail;
use App\Models\WasteDeposit;
use App\Models\Withdrawal;
use App\Models\PickupSchedule;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUser = User::where('role', 'citizen')->count();
        $totalPetugas = User::where('role', 'officer')->count();
        $totalPosko = DropOffPoint::count();
        
        $totalWeightKg = DepositDetail::sum('weight_kg');
        if ($totalWeightKg >= 1000) {
            $totalSampah = number_format($totalWeightKg / 1000, 1, '.', '') . ' Ton';
        } else {
            $totalSampah = number_format($totalWeightKg, 0, '.', '') . ' Kg';
        }
        $totalKas = DepositDetail::sum('total_price');
        $totalKasHariIni = DepositDetail::whereHas('wasteDeposit', function($query) {
            $query->whereDate('deposit_date', today());
        })->sum('total_price');
        $userAktifCount = User::where('status', 'active')->count();
        $petugasAktifCount = User::where('role', 'officer')->where('status', 'active')->count();
        $transaksiHariIni = WasteDeposit::whereDate('deposit_date', today())->count();
        
        $pendingVerifikasi = Withdrawal::where('status', 'pending')->count() + PickupSchedule::where('status', 'pending')->count();
        $activities = [];
        
        $latestUsers = User::latest()->take(3)->get();
        foreach ($latestUsers as $u) {
            $activities[] = [
                'desc' => "User baru mendaftar: {$u->name}",
                'time' => $u->created_at,
            ];
        }
        $latestDeposits = WasteDeposit::with(['user', 'depositDetails'])->latest()->take(3)->get();
        foreach ($latestDeposits as $d) {
            $weight = $d->depositDetails->sum('weight_kg');
            $userName = $d->user->name ?? 'Nasabah';
            $activities[] = [
                'desc' => "Setoran sampah masuk dari {$userName} ({$weight} Kg)",
                'time' => $d->created_at ?? $d->deposit_date,
            ];
        }
        usort($activities, function($a, $b) {
            return $b['time'] <=> $a['time'];
        });
        
        $activities = array_slice($activities, 0, 5);
        return view('admin.dashboard', compact(
            'totalUser',
            'totalPetugas',
            'totalPosko',
            'totalSampah',
            'totalKas',
            'totalKasHariIni',
            'userAktifCount',
            'petugasAktifCount',
            'transaksiHariIni',
            'pendingVerifikasi',
            'activities'
        ));
    }
}
    