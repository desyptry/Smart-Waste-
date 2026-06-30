<?php

namespace App\Http\Controllers;
use App\Models\WasteCategory;
class WasteCatalogController extends Controller
{
    public function index()
    {
        $daftarSampah = WasteCategory::all();

        return view('user.katalog-sampah.index', compact('daftarSampah'));
    }
     public function show($id)
    {
        $sampah = WasteCategory::findOrFail($id);
        $averagePrice = \App\Models\SchedulePrice::where('waste_category_id', $id)->avg('price') ?: 1000;
        return view('user.katalog-sampah.show', compact('sampah', 'averagePrice'));
    }
}
