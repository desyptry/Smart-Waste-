<?php

namespace App\Http\Controllers;

use App\Models\PickupSchedule;
use App\Models\WasteCategory;
use App\Models\SchedulePrice;
use Illuminate\Http\Request;

class SchedulePriceController extends Controller
{
    public function index($id)
    {
        $schedule = PickupSchedule::with('dropOffPoint')->findOrFail($id);
        $categories = WasteCategory::all();
        $activePrices = SchedulePrice::with('wasteCategory')->where('pickup_schedule_id', $id)->get();

        return view('officer.jadwal.detail-jadwal.harga.index', compact('schedule', 'categories', 'activePrices'));
    }

    public function syncPrices(Request $request, $id)
    {
        $schedule = PickupSchedule::findOrFail($id);

        if ($schedule->status === 'verified') {
            abort(403, 'Harga sudah diverifikasi oleh Assessor dan tidak dapat diubah lagi.');
        }

        $request->validate([
            'waste_category_id' => 'required|exists:waste_categories,id',
            'price'             => 'required|numeric|min:0',
        ]);

        SchedulePrice::updateOrCreate(
            ['pickup_schedule_id' => $id, 'waste_category_id' => $request->waste_category_id],
            ['price' => $request->price]
        );

        // Ubah status ke mode draft/revisi (opsional, agar sistem tahu sedang diubah)
        // Jika sebelumnya rejected atau not-verified, biarkan dalam mode pengeditan officer
        if ($schedule->status === 'rejected') {
            $schedule->update(['status' => 'rejected']); // Tetap rejected sampai tombol selesai ditekan
        }

        return redirect()->back()->with('success', 'Harga komoditas berhasil diperbarui di daftar sementara.');
    }

    public function destroyPrice($id, $priceId)
    {
        $schedule = PickupSchedule::findOrFail($id);

        if ($schedule->status === 'verified') {
            abort(403, 'Harga sudah diverifikasi oleh Assessor.');
        }

        $price = SchedulePrice::where('pickup_schedule_id', $id)->findOrFail($priceId);
        $price->delete();

        return redirect()->back()->with('success', 'Harga komponen berhasil dihapus dari daftar sementara.');
    }

    /**
     * FUNGSI BARU: Mengirimkan seluruh perubahan harga ke Assessor sekaligus
     */
    public function submitRevision($id)
    {
        $schedule = PickupSchedule::findOrFail($id);

        if ($schedule->status === 'verified') {
            abort(403, 'Jadwal ini sudah diverifikasi.');
        }

        // Cek apakah sudah mengisi harga atau belum sebelum dikirim
        $priceCount = SchedulePrice::where('pickup_schedule_id', $id)->count();
        if ($priceCount === 0) {
            return redirect()->back()->with('error', 'Gagal mengirim. Anda belum mengatur harga untuk komoditas apa pun!');
        }

        // Ubah status menjadi not-verified secara massal & hapus alasan penolakan lama
        $schedule->update([
            'status' => 'not-verified',
            'rejection_reason' => null
        ]);

        return redirect()->back()->with('success', '🚀 Seluruh revisi harga berhasil dikunci dan dikirim ke Assessor untuk ditinjau ulang!');
    }
}