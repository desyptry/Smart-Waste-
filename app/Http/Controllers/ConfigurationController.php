<?php

namespace App\Http\Controllers;
use App\Models\SystemConfiguration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
  public function index()
    {
        $configurations = SystemConfiguration::all();
        return view('admin.konfigurasi.index', compact('configurations'));
    }
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        foreach ($data as $key => $value) {
            SystemConfiguration::updateOrCreate(
                ['name' => $key],
                ['value' => $value]
            );
        }
        return redirect()->route('admin.konfigurasi.index')->with('success', 'Konfigurasi berhasil diperbarui.');
    }
}