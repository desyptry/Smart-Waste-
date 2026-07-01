<?php

namespace App\Http\Controllers;

use App\Models\WasteCategory;
use App\Http\Requests\WasteCategoryRequest;
use Illuminate\Support\Facades\Storage;

class WasteCategoryController extends Controller
{
    public function index()
    {
        $categories = WasteCategory::latest()->paginate(10);
        return view('admin.kategori.index', compact('categories'));
    }

    public function store(WasteCategoryRequest $request)
    {
        $data = $request->validated();
        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('waste-categories', 'public');
        }
        
        WasteCategory::create($data);
        
        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(WasteCategoryRequest $request, WasteCategory $wasteCategory)
    {
        $data = $request->validated();
        
        if ($request->hasFile('photo')) {
            if ($wasteCategory->photo) {
                Storage::disk('public')->delete($wasteCategory->photo);
            }
            $data['photo'] = $request->file('photo')->store('waste-categories', 'public');
        }
        
        $wasteCategory->update($data);
        
        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori diperbarui.');
    }

    public function destroy(WasteCategory $wasteCategory)
    {
        if ($wasteCategory->photo) {
            Storage::disk('public')->delete($wasteCategory->photo);
        }
        
        $wasteCategory->delete();
        
        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori dihapus.');
    }
}