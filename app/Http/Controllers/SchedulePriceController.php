<?php

namespace App\Http\Controllers;

use App\Models\PickupSchedule;
use App\Models\WasteCategory;
use App\Models\SchedulePrice;
use Illuminate\Http\Request;

class SchedulePriceController extends Controller
{
    /**
     * Tampilan Utama Manajemen Harga per Sesi
     */
    public function index($id)
    {
        $schedule = PickupSchedule::with('dropOffPoint')->findOrFail($id);
        
        // Ambil semua kategori sampah untuk opsi pilihan di elemen dropdown (<select>)
        $categories = WasteCategory::all();

        // Ambil harga yang telah aktif khusus untuk jadwal ini
        $activePrices = SchedulePrice::with('wasteCategory')
                            ->where('pickup_schedule_id', $id)
                            ->get();

        return view('officer.jadwal.detail-jadwal.harga.index', compact('schedule', 'categories', 'activePrices'));
    }

    /**
     * Menyimpan atau Memperbarui Harga Tunggal dari Form
     */
    public function syncPrices(Request $request, $id)
    {
        $request->validate([
            'waste_category_id' => 'required|exists:waste_categories,id',
            'price'             => 'required|numeric|min:0',
        ]);

        // Menggunakan updateOrCreate agar jika kategori sudah diatur, nilainya otomatis terupdate
        SchedulePrice::updateOrCreate(
            [
                'pickup_schedule_id' => $id,
                'waste_category_id'  => $request->waste_category_id,
            ],
            [
                'price' => $request->price,
            ]
        );

        return redirect()->back()->with('success', 'Nilai tukar kategori sampah berhasil diterapkan!');
    }

    /**
     * Menghapus Komponen Harga Spesifik
     */
    public function destroyPrice($id, $priceId)
    {
        $price = SchedulePrice::where('pickup_schedule_id', $id)->findOrFail($priceId);
        $price->delete();

        return redirect()->back()->with('success', 'Batas harga kategori sampah berhasil dihapus.');
    }
}
