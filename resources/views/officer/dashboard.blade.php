@extends('officer.layout.app')

@section('content')

@php
$hour = date('H');
if($hour < 12) $greeting = "Pagi";
elseif($hour < 17) $greeting = "Siang";
else $greeting = "Malam";
@endphp

<!-- ================= HEADER FULL ================= -->
<div class="grid grid-cols-1 gap-6 mb-6">

    <!-- CARD UTAMA FULL -->
    <div class="bg-[#2D333D] text-white p-6 rounded-2xl shadow flex justify-between">

        <div>
            <h1 class="text-xl font-semibold">
                Selamat {{ $greeting }}, 
                <span class="font-bold">{{ auth()->user()->name ?? 'Officer' }}</span>
            </h1>

            <p class="text-gray-300 text-sm mt-1">
                Petugas Lapangan • Sistem Monitoring Sampah
            </p>

            <div class="mt-5">
                <p class="text-gray-400 text-sm">Total Pendapatan Hari Ini</p>
                <h2 class="text-3xl font-bold">Rp 200.000,-</h2>
            </div>
        </div>

        <div class="flex flex-col items-end gap-4">
            <x-mdi-bell-outline class="w-6 h-6 text-gray-300"/>
            <img src="https://i.pravatar.cc/40" class="rounded-full">
        </div>

    </div>

</div>
<!-- ================= STATISTIK ================= -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

    <div class="bg-white p-4 rounded-xl shadow text-center hover:scale-105 transition">
        <p class="text-gray-500 text-sm">Warga Aktif</p>
        <h2 class="text-xl font-bold text-[#2D333D] mt-1">120</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-center hover:scale-105 transition">
        <p class="text-gray-500 text-sm">Total Sampah</p>
        <h2 class="text-xl font-bold text-[#2D333D] mt-1">250 Kg</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-center hover:scale-105 transition">
        <p class="text-gray-500 text-sm">Setoran Hari Ini</p>
        <h2 class="text-xl font-bold text-[#2D333D] mt-1">35</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-center hover:scale-105 transition">
        <p class="text-gray-500 text-sm">Perlu Verifikasi</p>
        <h2 class="text-xl font-bold text-red-500 mt-1">8</h2>
    </div>

</div>

<!-- ================= JADWAL ================= -->
<div class="bg-white p-6 rounded-2xl shadow mb-6">
    <h2 class="font-bold text-[#2D333D] mb-4">
        Jadwal & Lokasi Pengumpulan
    </h2>

    <div class="space-y-4 text-sm">

        @for($i = 0; $i < 1; $i++)
        <div class="flex justify-between items-center border-b pb-3">

            <div class="flex items-center gap-4 text-gray-600">
                <x-mdi-calendar class="w-5 h-5 text-[#69C3C1]"/>
                <span>Senin, 27 Maret 2026</span>

                <x-mdi-clock-outline class="w-5 h-5 text-[#69C3C1] ml-4"/>
                <span>08.00 - 09.00</span>

                <x-mdi-map-marker class="w-5 h-5 text-[#69C3C1] ml-4"/>
                <span>Balai Br. Ambengan</span>
            </div>

            <a href="#" class="text-[#69C3C1] font-semibold">Detail</a>

        </div>
        @endfor

    </div>
</div>

<!-- ================= FOOTER ================= -->
<div class="bg-[#A8C5B5] p-6 rounded-2xl shadow flex justify-between items-center">

    <div>
        <h2 class="font-bold text-[#2D333D] text-lg">
            Riwayat Pengumpulan Sampah
        </h2>
        <p class="text-sm text-gray-700">Periode: Maret 2026</p>
    </div>

    <div class="text-right">
        <p class="text-sm text-gray-700">Total Pendapatan</p>
        <h2 class="text-xl font-bold text-[#2D333D]">Rp10.000.000,00</h2>
    </div>

</div>



@endsection