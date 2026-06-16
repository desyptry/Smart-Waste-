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
}
