@extends('admin.layout.app')

@section('title', 'Kelola User')

@section('content')

<div class="bg-white rounded shadow">

    {{-- Header Card --}}
    <div class="bg-green-500 text-white px-4 py-2 font-semibold">
        Kelola Data User
    </div>

    <div class="p-4">

        {{-- Form --}}
        <div class="grid grid-cols-3 gap-2 mb-3">
            <input type="text" placeholder="Nama User" class="border p-2">
            <input type="text" placeholder="Username" class="border p-2">
            <select class="border p-2">
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
                <option value="user">User</option>
            </select>
        </div>

        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 mb-4">
            Simpan
        </button>

        {{-- Table --}}
        <table class="w-full text-sm border">
            <thead class="bg-green-500 text-white">
                <tr>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Username</th>
                    <th class="p-2">Role</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t hover:bg-gray-100">
                    <td class="p-2">Admin</td>
                    <td class="p-2">admin01</td>
                    <td class="p-2">Admin</td>
                    <td class="p-2">
                        <button class="bg-green-500 text-white px-2 py-1">
                            Hapus
                        </button>
                    </td>
                </tr>
                <tr class="border-t hover:bg-gray-100">
                    <td class="p-2">Petugas</td>
                    <td class="p-2">petugas01</td>
                    <td class="p-2">Petugas</td>
                    <td class="p-2">
                        <button class="bg-green-500 text-white px-2 py-1">
                            Hapus
                        </button>
                    </td>
            </tbody>
        </table>

    </div>

</div>

@endsection