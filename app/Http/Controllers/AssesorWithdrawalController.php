<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AssesorWithdrawalController extends Controller
{
    // Menampilkan daftar withdrawal yang didelegasikan khusus ke Assessor yang sedang login
    public function index()
    {
        $withdrawals = Withdrawal::with('user')
            ->where('asessor_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('assesor.withdrawal.index', compact('withdrawals'));
    }

    // Memproses Keputusan Withdrawal (Disetujui setelah transfer / Ditolak)
    public function verify(Request $request, $id)
    {
        $withdrawal = Withdrawal::where('asessor_id', auth()->id())->findOrFail($id);

        if ($request->action === 'approve') {
            // Status berubah karena dana riil sudah berhasil ditransfer oleh Assessor
            $withdrawal->update([
                'status' => 'approved',
                'approved_at' => Carbon::now()
            ]);

            // [Opsional] Kurangi saldo digital nasabah di sini jika belum dikunci saat pengajuan

            return redirect()->route('assesor.withdrawal')->with('success', 'Status pencairan dana berhasil diperbarui menjadi APPROVED.');
        }

        // if ($request->action === 'reject') {
        //     $request->validate([
        //         'rejection_reason' => 'required|string|max:255'
        //     ]);

        //     $withdrawal->update([
        //         'status' => 'rejected',
        //         'rejection_reason' => $request->rejection_reason
        //     ]);

        //     return redirect()->route('assesor.withdrawal.index')->with('error', 'Pencairan dana ditolak.');
        // }
    }
}