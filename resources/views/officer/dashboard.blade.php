@extends('officer.layout.app')

@section('title', 'Dashboard')

@section('content')

{{-- CARD STATISTIK --}}
<div class="grid grid-cols-4 gap-4 mb-6">

    <div class="bg-green-200 p-4 rounded text-center">
        <p class="text-xl font-bold">120</p>
        <p>Total Warga</p>
    </div>

    <div class="bg-green-200 p-4 rounded text-center">
        <p class="text-xl font-bold">50</p>
        <p>Total Setoran</p>
    </div>

    <div class="bg-green-200 p-4 rounded text-center">
        <p class="text-xl font-bold">10</p>
        <p>Menunggu Verifikasi</p>
    </div>

    <div class="bg-green-200 p-4 rounded text-center">
        <p class="text-xl font-bold">Rp 200.000</p>
        <p>Total Saldo</p>
    </div>

</div>

{{-- GRID BAWAH --}}
<div class="grid grid-cols-2 gap-4">

    {{-- AKTIVITAS TERBARU --}}
    <div class="bg-white rounded shadow">

        <div class="bg-green-300 p-2 font-semibold">
            Aktivitas Terbaru
        </div>

        <table class="w-full text-sm border border-gray-400 border-collapse">
            <thead class="bg-green-200">
                <tr>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Sampah</th>
                    <th class="border p-2">Berat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2">Budi</td>
                    <td class="border p-2">Plastik</td>
                    <td class="border p-2">2 Kg</td>
                </tr>
            </tbody>
        </table>

    </div>

    {{-- JADWAL --}}
    <div class="bg-white rounded shadow">

        <div class="bg-green-300 p-2 font-semibold">
            Jadwal Pengambilan
        </div>

        <ul class="p-4 text-sm space-y-2">
            <li class="border-b pb-1">📅 10 Jan 2025 - Posko A</li>
            <li class="border-b pb-1">📅 12 Jan 2025 - Posko B</li>
            <li>📅 15 Jan 2025 - Posko C</li>
        </ul>

    </div>

</div>

@endsection