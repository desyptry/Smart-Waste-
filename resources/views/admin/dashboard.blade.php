@extends('admin.layout.app')

@section('content')

@php
$hour = date('H');
if($hour < 12) $greeting = "Pagi";
elseif($hour < 17) $greeting = "Siang";
else $greeting = "Malam";
@endphp

<!-- ================= HEADER ================= -->
<div class="mb-6">

    <div class="bg-[#2D333D] text-white p-6 rounded-2xl shadow flex justify-between">

        <div>
            <h1 class="text-xl font-semibold">
                Selamat {{ $greeting }}, 
                <span class="font-bold">{{ auth()->user()->name ?? 'Admin' }}</span>
            </h1>

            <p class="text-gray-300 text-sm mt-1">
                Dashboard Administrator • Smart Waste System
            </p>

            <div class="mt-5">
                <p class="text-gray-400 text-sm">Total Sistem Hari Ini</p>
                <h2 class="text-3xl font-bold">Rp {{ number_format($totalKasHariIni, 0, ',', '.') }},-</h2>
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
        <p class="text-gray-500 text-sm">Total User</p>
        <h2 class="text-xl font-bold text-[#2D333D] mt-1">{{ $totalUser }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-center hover:scale-105 transition">
        <p class="text-gray-500 text-sm">Total Petugas</p>
         <h2 class="text-xl font-bold text-[#2D333D] mt-1">{{ $totalPetugas }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-center hover:scale-105 transition">
        <p class="text-gray-500 text-sm">Total Posko</p>
        <h2 class="text-xl font-bold text-[#2D333D] mt-1">{{ $totalPosko }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-center hover:scale-105 transition">
        <p class="text-gray-500 text-sm">Total Sampah</p>
        <h2 class="text-xl font-bold text-[#2D333D] mt-1">{{ $totalSampah }}</h2>
    </div>

</div>

<!-- ================= AKTIVITAS ================= -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    <!-- Aktivitas Terbaru -->
    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="font-bold text-[#2D333D] mb-4">Aktivitas Terbaru</h2>

        <div class="space-y-3 text-sm">

            {{-- <div class="flex justify-between  pb-2">
                <span>User baru mendaftar</span>
                <span class="text-gray-400">1 jam lalu</span> --}}
            @forelse($activities as $act)
            <div class="flex justify-between pb-2 border-b border-gray-100 last:border-0">
                <span>{{ $act['desc'] }}</span>
                <span class="text-gray-400">{{ is_string($act['time']) ? $act['time'] : $act['time']->diffForHumans() }}</span>
            </div>

            {{-- <div class="flex justify-between  pb-2">
                <span>Setoran sampah masuk</span>
                <span class="text-gray-400">2 jam lalu</span>
            </div>

            <div class="flex justify-between  pb-2">
                <span>Verifikasi berhasil</span>
                <span class="text-gray-400">3 jam lalu</span>
            </div> --}}
            @empty
            <div class="text-gray-500 text-center py-4">Belum ada aktivitas terbaru.</div>
            @endforelse
        </div>
    </div>

    <!-- Ringkasan Sistem -->
    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="font-bold text-[#2D333D] mb-4">Ringkasan Sistem</h2>

        <div class="space-y-4 text-sm">

            <div class="flex justify-between">
                <span>User Aktif</span>
                <span class="font-bold">{{ $userAktifCount }}</span>
            </div>

            <div class="flex justify-between">
                <span>Petugas Aktif</span>
                <span class="font-bold">{{ $petugasAktifCount }}</span>
            </div>

            <div class="flex justify-between">
                <span>Transaksi Hari Ini</span>
                <span class="font-bold">{{ $transaksiHariIni }}</span>
            </div>

            <div class="flex justify-between">
                <span>Pending Verifikasi</span>
                <span class="font-bold text-red-500">{{ $pendingVerifikasi }}</span>
            </div>

        </div>
    </div>

</div>

<!-- ================= FOOTER ================= -->
<div class="bg-[#A8C5B5] p-6 rounded-2xl shadow flex justify-between items-center">

    <div>
        <h2 class="font-bold text-[#2D333D] text-lg">
            Laporan Akumulasi
        </h2>
        <p class="text-sm text-gray-700">Periode: {{ date('F Y') }}</p>
    </div>

    <div class="text-right">
        <p class="text-sm text-gray-700">Total Kas Terkumpul</p>
        <h2 class="text-xl font-bold text-[#2D333D]">Rp {{ number_format($totalKas, 0, ',', '.') }},-</h2>
    </div>

</div>

@endsection