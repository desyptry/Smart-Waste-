@extends('admin.layout.app')

@section('title', 'Laporan')

@section('content')

<div class="bg-white rounded shadow">

    {{-- Header --}}
    <div class="bg-(--primary) text-(--text-black) px-4 py-2 font-semibold">
        Laporan
    </div>

    <div class="p-4">

        {{-- Filter tanggal --}}
        <div class="grid grid-cols-2 gap-2 mb-3">
            <input type="date" class=" p-2">
            <input type="date" class=" p-2">
        </div>

        <button class="bg-(--primary) hover:bg(--text-black)--primary) text-(--text-black) px-4 py-2 mb-4 rounded">
            Tampilkan
        </button>

        {{-- TABEL --}}
        <table class="w-full text-sm ">
            <thead class="bg-(--primary) text-(--text-black)">
                <tr>
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Jenis Sampah</th>
                    <th class="p-2">Berat</th>
                    <th class="p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class=" hover:bg-gray-100">
                    <td class="p-2">01-01-2025</td>
                    <td class="p-2">Budi</td>
                    <td class="p-2">Plastik</td>
                    <td class="p-2">2 Kg</td>
                    <td class="p-2">Rp 4.000</td>
                </tr>
            </tbody>
        </table>

        {{-- BUTTON EXPORT --}}
        <div class="mt-4">
            <button class="bg-(--primary) hover:bg(--text-black)--primary) text-(--text-black) px-4 py-2">
                Export / Cetak
            </button>
        </div>

    </div>

</div>

@endsection