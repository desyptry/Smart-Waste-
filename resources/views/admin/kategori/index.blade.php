@extends('admin.layout.app')

@section('title', 'Kategori Sampah')

@section('content')

<div class="bg-white rounded shadow">

    <div class="bg-green-500 text-white px-4 py-2 font-semibold">
        Kelola Kategori Sampah
    </div>

    <div class="p-4">

        {{-- FORM --}}
        <div class="grid grid-cols-3 gap-2 mb-3">
            <input type="text" placeholder="Nama Kategori" class="border p-2 rounded">
            <input type="number" placeholder="Harga / Kg" class="border p-2 rounded">
            <input type="text" placeholder="Keterangan" class="border p-2 rounded">
        </div>

        <button class="bg-green-500 text-white px-4 py-2 mb-4 rounded">
            Simpan
        </button>

        {{-- DATA DUMMY --}}
        @php
        $kategori = [
            ['nama'=>'Plastik','harga'=>2000,'ket'=>'Botol, kantong'],
            ['nama'=>'Kertas','harga'=>1500,'ket'=>'Koran, kardus'],
        ];
        @endphp

        {{-- TABEL --}}
        <table class="w-full text-sm border border-gray-400 border-collapse">

            <thead class="bg-green-500 text-white">
                <tr>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Harga</th>
                    <th class="p-2">Keterangan</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($kategori as $k)
                <tr class="border-t hover:bg-gray-100">
                    <td class="p-2">{{ $k['nama'] }}</td>
                    <td class="p-2">Rp {{ number_format($k['harga']) }}</td>
                    <td class="p-2">{{ $k['ket'] }}</td>
                    <td class="p-2">
                        <button class="bg-yellow-500 text-white px-2 py-1 mr-1 rounded">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

@endsection