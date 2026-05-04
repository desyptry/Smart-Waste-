@extends('officer.layout.app')

@section('content')

<div class="bg-white rounded shadow">

    <div class="bg-green-300 p-2 font-semibold">
        Jenis & Harga Sampah
    </div>

    <div class="p-4">

        {{-- FORM --}}
        <input type="text" placeholder="Jenis Sampah" class="border border-gray-400 p-2 w-full mb-2">
        <input type="text" placeholder="Harga" class="border border-gray-400 p-2 w-full mb-3">

        <button class="bg-green-500 text-white px-4 py-2 mb-4">
            Simpan
        </button>

        {{-- TABEL --}}
        <table class="w-full border text-sm border-collapse">
            <thead class="bg-green-300">
                <tr>
                    <th class="border p-2">Jenis</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="border p-2">Plastik</td>
                    <td class="border p-2">Rp 2.000/kg</td>
                    <td class="border p-2">
                        <button class="bg-yellow-500 text-white px-2 py-1 mr-1">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

</div>

@endsection