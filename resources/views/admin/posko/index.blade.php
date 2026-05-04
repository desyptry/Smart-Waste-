@extends('admin.layout.app')

@section('title', 'Data Posko')

@section('content')

<div class="bg-white rounded shadow">

    {{-- Header --}}
    <div class="bg-green-500 text-white px-4 py-2 font-semibold">
        Kelola Data Posko
    </div>

    <div class="p-4">

        {{-- FORM INPUT --}}
        <div class="grid grid-cols-2 gap-2 mb-3">
            <input type="text" placeholder="Nama Posko" class="border p-2">
            <input type="text" placeholder="Alamat" class="border p-2">
        </div>

        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 mb-4">
            Simpan
        </button>

        {{-- TABEL --}}
        <table class="w-full text-sm border border-gray-400 border-collapse">
            <thead class="bg-green-500 text-white">
                <tr>
                    <th class="p-2">Nama Posko</th>
                    <th class="p-2">Alamat</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead class="bg-green-500 text-white">
            <tbody class="hover:bg-gray-100">
                <tr class="border-t hover:bg-gray-100">
                    <td class="p-2">Posko A</td>
                    <td class="p-2">Buleleng</td>
                    <td class="p-2">
                        <button class="bg-yellow-500 text-white px-2 py-1 mr-1">
                            Edit
                        </button>
                        <button class="bg-red-500 text-white px-2 py-1">
                            Hapus
                        </button>
                    </td>
                    </thead>
                </tr>
            </tbody>
        </table>

    </div>

</div>

@endsection