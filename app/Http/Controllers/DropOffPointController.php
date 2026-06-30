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
        $poskos = DropOffPoint::with(['assesor', 'officers.user'])->latest()->paginate(10);
        $assesors = User::where('role', 'assesor')->get();
        $officers = User::where('role', 'officer')->get();
        return view('admin.posko.index', compact('poskos', 'assesors', 'officers'));
    }
    public function store(DropOffPointRequest $request)
    {
       $data = $request->except('officer_ids');
        $dropOffPoint = DropOffPoint::create($data);

        if ($request->has('officer_ids')) {
            foreach ($request->officer_ids as $userId) {
                \App\Models\OfficerDetail::updateOrCreate(
                    ['user_id' => $userId],
                    ['collection_point_id' => $dropOffPoint->id]
                );
            }
        }
        return redirect()->route('admin.posko.index')->with('success', 'Posko berhasil ditambahkan.');
    }
    public function update(DropOffPointRequest $request, DropOffPoint $dropOffPoint)
    {
        $data = $request->except('officer_ids');
        $dropOffPoint->update($data);
        // Reset previous officers assigned to this posko
        \App\Models\OfficerDetail::where('collection_point_id', $dropOffPoint->id)
            ->update(['collection_point_id' => null]);

        if ($request->has('officer_ids')) {
            foreach ($request->officer_ids as $userId) {
                \App\Models\OfficerDetail::updateOrCreate(
                    ['user_id' => $userId],
                    ['collection_point_id' => $dropOffPoint->id]
                );
            }
        }
        return redirect()->route('admin.posko.index')->with('success', 'Posko berhasil diperbarui.');
    }
    public function destroy(DropOffPoint $dropOffPoint)
    {
         // Reset associated officers
        \App\Models\OfficerDetail::where('collection_point_id', $dropOffPoint->id)
            ->update(['collection_point_id' => null]);
        $dropOffPoint->delete();
        return redirect()->route('admin.posko.index')->with('success', 'Posko berhasil dihapus.');
    }
}