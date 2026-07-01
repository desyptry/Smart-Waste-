<?php

namespace App\Http\Controllers;

use App\Models\PickupSchedule;
use Illuminate\Http\Request;

class AssesorScheduleController extends Controller
{
    // Tampilan Daftar Jadwal yang Butuh Verifikasi
    public function index()
    {
        $assesorId = auth()->id();

        // Mengambil jadwal berstatus 'not-verified' yang drop_off_point-nya di-assign ke assesor ini
        $schedules = PickupSchedule::with(['dropOffPoint'])
            ->where('status', 'not-verified')
            ->whereHas('dropOffPoint', function ($query) use ($assesorId) {
                $query->where('assesor_id', $assesorId); // Sesuaikan ke 'user_id' jika nama kolom di migrasi Anda adalah user_id
            })
            ->orderBy('updated_at', 'asc')
            ->get();

        return view('assesor.jadwal.index', compact('schedules'));
    }


    // Tinjau Harga Sampah yang Diajukan di Dalam Jadwal
    public function review($id)
    {
        $schedule = PickupSchedule::with([
            'dropOffPoint', 
            'schedulePrices'
        ])->findOrFail($id);

        return view('assesor.jadwal.review', compact('schedule'));
    }

    // Eksekusi Persetujuan / Verifikasi Jadwal
public function verify(Request $request, $id)
    {
        $schedule = PickupSchedule::findOrFail($id);
        
        if ($request->action === 'approve') {
            $schedule->update([
                'status' => 'verified',
                'declined_reason' => null // Bersihkan alasan jika sebelumnya pernah ditolak lalu diajukan lagi
            ]);
            
            return redirect()->route('assesor.jadwal')->with('success', 'Jadwal dan pengajuan harga berhasil Diverifikasi! Setoran sekarang dapat dilakukan.');
        } 
        
        if ($request->action === 'reject') {
            // Validasi wajib mengisi alasan penolakan
            $request->validate([
                'declined_reason' => 'required|string|max:500'
            ], [
                'declined_reason.required' => 'Anda wajib memberikan alasan kenapa pengajuan jadwal/harga ini ditolak.'
            ]);

            $schedule->update([
                'status' => 'declined',
                'declined_reason' => $request->declined_reason
            ]);

            return redirect()->route('assesor.jadwal')->with('error', 'Jadwal dan pengajuan harga telah ditolak dengan alasan: ' . $request->rejection_reason);
        }
    }
}