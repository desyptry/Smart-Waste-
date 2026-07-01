<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,officer,citizen,assesor',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
            'status' => 'nullable|in:active,inactive,banned',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['status'] = $data['status'] ?? 'active';
        $user = User::create($data);

        if ($user->role === 'officer') {
            \App\Models\OfficerDetail::firstOrCreate([
                'user_id' => $user->id
            ]);
        } elseif ($user->role === 'citizen') {
            \App\Models\CitizenDetail::firstOrCreate([
                'user_id' => $user->id
            ], [
                'balance' => 0
            ]);
        }

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,officer,citizen,assesor',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
             'status' => 'nullable|in:active,inactive,banned',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        if ($user->role === 'officer') {
            \App\Models\OfficerDetail::firstOrCreate([
                'user_id' => $user->id
            ]);
        } elseif ($user->role === 'citizen') {
            \App\Models\CitizenDetail::firstOrCreate([
                'user_id' => $user->id
            ], [
                'balance' => 0
            ]);
        }
        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User dihapus.');
    }
}