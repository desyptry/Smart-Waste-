<?php

namespace App\Http\Controllers;
use App\Models\DropOffPoint;
use App\Models\User;
use App\Http\Requests\DropOffPointRequest;
use Illuminate\Http\Request;

class DropOffPointController extends Controller
{
    public function index()
    {
        $poskos = DropOffPoint::with('assesor')->latest()->paginate(10);
        $assesors = User::where('role', 'assesor')->get();
        
        return view('admin.posko.index', compact('poskos', 'assesors'));
    }
    public function store(DropOffPointRequest $request)
    {
        $data = $request->validated();
        DropOffPoint::create($data);
        return redirect()->route('admin.posko.index')->with('success', 'Posko berhasil ditambahkan.');
    }
    public function update(DropOffPointRequest $request, DropOffPoint $dropOffPoint)
    {
        $data = $request->validated();
        $dropOffPoint->update($data);
        return redirect()->route('admin.posko.index')->with('success', 'Posko berhasil diperbarui.');
    }
    public function destroy(DropOffPoint $dropOffPoint)
    {
        $dropOffPoint->delete();
        return redirect()->route('admin.posko.index')->with('success', 'Posko berhasil dihapus.');
    }
}