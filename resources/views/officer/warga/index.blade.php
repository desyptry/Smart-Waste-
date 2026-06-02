@extends('officer.layout.app')

@section('title', 'Data Warga')

@section('content')

<div class="bg-white rounded shadow">

    {{-- HEADER --}}
    <div class="bg-(--primary) p-2 font-semibold">
        Kelola Data Warga
    </div>

    <div class="p-4">

        {{-- FORM INPUT --}}
        <div class="grid grid-cols-2 gap-2 mb-3">
            <input type="text" placeholder="Nama Warga" class="border border-gray-400 p-2">
            <input type="text" placeholder="Alamat" class="border border-gray-400 p-2">
        </div>

        <button class="bg-(--primary) hover:bg-green-600 text-(--text-black) px-4 py-2 mb-4">
            Simpan
        </button>

        {{-- GARIS PEMBATAS --}}
        <!-- <hr class="my-4 border-gray-400"> -->

        {{-- TABEL --}}
        <table class="w-full border-collapse text-sm">

            <thead class="bg-(--primary)">
                <tr>
                    <th class=" p-2">Nama</th>
                    <th class=" p-2">Alamat</th>
                    <th class=" p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>

                {{-- DATA DUMMY --}}
                <tr class="hover:bg-gray-100">
                    <td class=" p-2">Budi</td>
                    <td class=" p-2">Buleleng</td>
                    <td class=" p-2">
                        <button class="bg-yellow-500 text-white px-2 py-1 mr-1">
                            Edit
                        </button>
                        <button class="bg-red-500 text-white px-2 py-1">
                            Hapus
                        </button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-100">
                    <td class=" p-2">Sari</td>
                    <td class=" p-2">Denpasar</td>
                    <td class=" p-2">
                        <button class="bg-yellow-500 text-white px-2 py-1 mr-1">
                            Edit
                        </button>
                        <button class="bg-red-500 text-white px-2 py-1">
                            Hapus
                        </button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-100">
                    <td class=" p-2">Andi</td>
                    <td class=" p-2">Singaraja</td>
                    <td class=" p-2">
                        <button class="bg-yellow-500 text-white px-2 py-1 mr-1">
                            Edit
                        </button>
                        <button class="bg-red-500 text-white px-2 py-1">
                            Hapus
                        </button>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection