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
            <input type="text" placeholder="Nama Posko" class="border p-2 rounded">
            <input type="text" placeholder="Alamat" class="border p-2 rounded">
        </div>

        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 mb-4 rounded">
            Simpan
        </button>

        {{-- DATA DUMMY --}}
        @php
        $poskos = [
            ['id'=>1,'nama'=>'Posko seririt','alamat'=>'seririt','petugas'=>3],
            ['id'=>2,'nama'=>'Posko kubutambahan','alamat'=>'kubutambahan','petugas'=>2],
        ];
        @endphp

        {{-- TABEL --}}
        <table class="w-full text-sm border border-gray-400 border-collapse">

            <thead class="bg-green-500 text-white">
                <tr>
                    <th class="p-2">Nama Posko</th>
                    <th class="p-2">Alamat</th>
                    <th class="p-2">Petugas</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($poskos as $p)
                <tr class="border-t hover:bg-gray-100">

                    <td class="p-2">{{ $p['nama'] }}</td>

                    <td class="p-2">{{ $p['alamat'] }}</td>

                    <td class="p-2">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                            {{ $p['petugas'] }} Petugas
                        </span>
                    </td>

                    <td class="p-2">
                        <a href="/admin/posko/{{ $p['id'] }}/edit"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 mr-1 rounded">
                            Edit
                        </a>

                        <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
                            Hapus
                        </button>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

@endsection