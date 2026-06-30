<?php
namespace App\Http\Controllers;
use App\Models\Withdrawal;
use App\Models\User;
use App\Models\CitizenDetail;
use Illuminate\Http\Request;
class WithdrawalController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        $balance = $user->citizenDetail->balance ?? 0;
        
        // Fetch user's withdrawal history
        $withdrawals = Withdrawal::where('user_id', $user->id)->latest()->get();
        
        return view('user.pencairan.index', compact('balance', 'withdrawals'));
    }
    public function store(Request $request)
    {
        $user = auth()->user();
        $citizenDetail = $user->citizenDetail;
        $balance = $citizenDetail->balance ?? 0;
        $request->validate([
            'metode' => 'required|in:bank,ewallet',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'amount' => 'required|integer|min:20000',
        ]);
        $amount = $request->amount;
        if ($amount > $balance) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi untuk melakukan penarikan sebesar Rp ' . number_format($amount, 0, ',', '.')]);
        }
        // Deduct the balance
        $citizenDetail->balance -= $amount;
        $citizenDetail->save();
        // Assign to a random or first assessor
        $assessor = User::where('role', 'assesor')->first();
        Withdrawal::create([
            'user_id' => $user->id,
            'asessor_id' => $assessor ? $assessor->id : null,
            'amount' => $amount,
            'method' => $request->metode,
            'account_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'status' => 'pending',
        ]);
        return redirect()->route('user.pencairan')->with('success', 'Pengajuan pencairan saldo berhasil dikirim dan sedang menunggu verifikasi.');
    }
}