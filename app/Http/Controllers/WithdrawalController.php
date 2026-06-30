<?php

namespace App\Http\Controllers;

use App\Models\CitizenDetail;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    // Menampilkan form penarikan & riwayat transaksi warga
    public function index()
    {
        $userId = auth()->id();
        
        // Ambil detail saldo warga
        $citizenDetail = CitizenDetail::where('user_id', $userId)->firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );
        // Ambil riwayat penarikan milik warga tersebut
        $history = Withdrawal::where('user_id', $userId)
            ->latest()
            ->paginate(5);
        

        return view('user.pencairan.index', compact('citizenDetail', 'history'));
    }

    // Memproses pengajuan penarikan dana
public function store(Request $request)
{
    $userId = auth()->id();
    $citizenDetail = CitizenDetail::where('user_id', $userId)->firstOrFail();

    // 1. Validasi Input
    $request->validate([
        'metode' => 'required|in:bank_transfer,e_wallet',
        'account_name' => 'required|string|max:100',
        'account_number' => 'required|string|max:50',
        'amount' => 'required|integer|min:20000',
    ], [
        'amount.min' => 'Minimal penarikan adalah Rp 20.000,-',
        'account_name.required' => 'Nama Bank atau E-Wallet wajib dipilih/diisi.',
        'account_number.required' => 'Nomor rekening atau HP wajib diisi.'
    ]);

    // 2. Proteksi Saldo Kecukupan
    if ($citizenDetail->balance < $request->amount) {
        return redirect()->back()->withErrors(['amount' => 'Saldo Anda tidak mencukupi untuk melakukan penarikan ini.'])->withInput();
    }

    $randomAssesor = User::where('role', 'assesor') 
                        ->inRandomOrder()
                        ->first();

    // Antisipasi jika belum ada petugas yang didaftarkan di sistem
    if (!$randomAssesor) {
        return redirect()->back()->withErrors(['amount' => 'Sistem gagal menemukan petugas yang bersedia. Silakan coba beberapa saat lagi.'])->withInput();
    }

    // 4. Jalankan Transaction Database
    DB::transaction(function () use ($request, $userId, $citizenDetail, $randomAssesor) {
        // Buat data pengajuan penarikan langsung dengan assesor ter-assign
        Withdrawal::create([
            'user_id' => $userId,
            'asessor_id' => $randomAssesor->id, // Menyimpan ID petugas hasil acak
            'amount' => $request->amount,
            'method' => $request->metode,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'status' => 'pending' // Tetap pending karena butuh aksi verifikasi dari petugas tersebut
        ]);

        // Potong saldo berjalan warga (Hold Saldo)
        $citizenDetail->decrement('balance', $request->amount);
    });

    return redirect()->route('user.withdrawal')->with('success', 'Pengajuan penarikan berhasil dikirim! Petugas ' . $randomAssesor->name . ' telah ditunjuk untuk memeriksa pengajuan Anda.');
}
}