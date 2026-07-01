<?php
namespace App\Http\Controllers;
use App\Models\PickupSchedule;
use App\Models\SchedulePrice;
use App\Models\WasteDeposit;
use App\Models\DepositDetail;
use App\Models\Withdrawal;
use App\Models\WasteCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;
class CitizenController extends Controller
{
    
    public function dashboard()
    {
        $user = auth()->user();
        // Greeting
        $hour = date('H');
        if ($hour < 12) {
            $greeting = "Pagi";
        } elseif ($hour < 17) {
            $greeting = "Siang";
        } else {
            $greeting = "Malam";
        }
        // 1. Get user balance
        $balance = $user->citizenDetail->balance ?? 0;
        // 2. Get upcoming verified schedules
        $schedules = PickupSchedule::with('dropOffPoint')
            ->where('status', 'verified')
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();
        // 3. Get latest prices for each category
        $categories = WasteCategory::all();
        $wastePrices = [];
        foreach ($categories as $category) {
            $latestPrice = SchedulePrice::where('waste_category_id', $category->id)
                ->latest('id')
                ->first();
            $wastePrices[] = [
                'name' => $category->name,
                'price' => $latestPrice ? $latestPrice->price : 1000,
            ];
        }
        // 4. Get latest 4 deposit history items
        $riwayat = DepositDetail::whereHas('wasteDeposit', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['wasteDeposit', 'wastePrice.wasteCategory'])
            ->join('waste_deposits', 'deposit_details.waste_deposit_id', '=', 'waste_deposits.id')
            ->orderBy('waste_deposits.deposit_date', 'desc')
            ->select('deposit_details.*')
            ->take(4)
            ->get();
        // 5. Total Pendapatan month-to-date
        $totalPendapatan = DepositDetail::whereHas('wasteDeposit', function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->whereMonth('deposit_date', now()->month)
              ->whereYear('deposit_date', now()->year);
        })->sum('total_price');
        return view('user.dashboard.index', compact(
            'greeting',
            'balance',
            'schedules',
            'wastePrices',
            'riwayat',
            'totalPendapatan'
        ));
    }
    public function riwayat()
    {
        $user = auth()->user();
        // Fetch deposits (dana masuk)
        $deposits = DepositDetail::whereHas('wasteDeposit', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['wasteDeposit.dropOffPoint', 'wastePrice.wasteCategory'])
            ->get()
            ->map(function ($item) {
                return [
                    'tipe' => 'masuk',
                    'judul' => ($item->wastePrice->wasteCategory->name ?? 'Sampah') . ' - ' . $item->weight_kg . 'Kg',
                    'sub' => $item->wasteDeposit->dropOffPoint->name ?? 'Drop Off',
                    'tgl_raw' => $item->wasteDeposit->deposit_date,
                    'tgl' => $item->wasteDeposit->deposit_date ? $item->wasteDeposit->deposit_date->translatedFormat('d F Y') : '-',
                    'status' => 'Berhasil',
                    'nominal' => '+' . number_format($item->total_price, 0, ',', '.')
                ];
            });
        // Fetch withdrawals (dana keluar)
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($item) {
                $statusText = 'Proses';
                if ($item->status == 'approved') {
                    $statusText = 'Berhasil';
                } elseif ($item->status == 'rejected') {
                    $statusText = 'Ditolak';
                }
                return [
                    'tipe' => 'keluar',
                    'judul' => 'Pencairan Saldo',
                    'sub' => strtoupper($item->method) . ' - ' . $item->account_number,
                    'tgl_raw' => $item->created_at,
                    'tgl' => $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-',
                    'status' => $statusText,
                    'nominal' => '-' . number_format($item->amount, 0, ',', '.')
                ];
            });
        // Combine and sort by date descending
        $transaksi = $deposits->concat($withdrawals)->sortByDesc('tgl_raw')->values();
        return view('user.riwayat.index', compact('transaksi'));
    }
    public function jadwal()
    {
        $jadwal = PickupSchedule::with('dropOffPoint')
            ->where('status', 'verified')
            ->orderBy('start_date', 'asc')
            ->get();
        // dd($jadwal);
        return view('user.jadwal.index', compact('jadwal'));
    }
    public function jadwalShow($id)
    {
        $schedule = PickupSchedule::with(['dropOffPoint', 'schedulePrices.wasteCategory'])->findOrFail($id);
        return view('user.jadwal.show', compact('schedule'));
    }
}