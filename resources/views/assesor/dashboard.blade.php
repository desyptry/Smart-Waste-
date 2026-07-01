@extends('assesor.layout.app')

@section('content')

@php
$hour = date('H');
if($hour < 12) $greeting = "Pagi";
elseif($hour < 17) $greeting = "Siang";
else $greeting = "Malam";
@endphp

{{-- 1. HEADER BANNER --}}
<div class="grid grid-cols-1 gap-6 mb-6">
    <div class="bg-[#2D333D] text-white p-6 rounded-2xl shadow flex justify-between items-center">
        <div>
            <h1 class="text-xl font-semibold">
                Selamat {{ $greeting }}, 
                <span class="font-bold">{{ auth()->user()->name ?? 'Assesor' }}</span>
            </h1>
            <p class="text-gray-300 text-sm mt-1">
                Petugas Penilai (Assesor) • Panel Verifikasi Transaksi & Jadwal
            </p>
        </div>

        <div class="flex flex-col items-end gap-4">
            <x-mdi-bell-outline class="w-6 h-6 text-gray-300"/>
            <img src="https://i.pravatar.cc/40" class="rounded-full shadow" alt="Avatar">
        </div>
    </div>
</div>

{{-- 2. KARTU STATISTIK METRIK CONTROLS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

    {{-- Penarikan Belum Diapprove --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between hover:scale-105 transition ">
        <div>
            <p class="text-gray-500 text-sm font-medium">Penarikan Belum Diapprove</p>
            <h2 class="text-3xl font-black text-amber-600 mt-1">{{ $pendingWithdrawalsCount }}</h2>
            <p class="text-xs text-gray-400 mt-1">Perlu tindakan verifikasi dana</p>
        </div>
        <div class="p-3 bg-amber-50 rounded-lg text-amber-500">
            <x-mdi-cash-clock class="w-8 h-8"/>
        </div>
    </div>

    {{-- Withdrawal Selesai Hari Ini --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between hover:scale-105 transition ">
        <div>
            <p class="text-gray-500 text-sm font-medium">Withdrawal Selesai (Hari Ini)</p>
            <h2 class="text-3xl font-black text-emerald-600 mt-1">{{ $todayApprovedWithdrawalsCount }}</h2>
            <p class="text-xs text-gray-400 mt-1">Total pencairan sukses hari ini</p>
        </div>
        <div class="p-3 bg-emerald-50 rounded-lg text-emerald-500">
            <x-mdi-cash-check class="w-8 h-8"/>
        </div>
    </div>

    {{-- Jadwal Belum Diapprove --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between hover:scale-105 transition">
        <div>
            <p class="text-gray-500 text-sm font-medium">Jadwal Belum Diapprove</p>
            <h2 class="text-3xl font-black text-red-600 mt-1">{{ $pendingSchedulesCount }}</h2>
            <p class="text-xs text-gray-400 mt-1">Pemuatan atau penjemputan sampah</p>
        </div>
        <div class="p-3 bg-red-50 rounded-lg text-red-500">
            <x-mdi-calendar-alert class="w-8 h-8"/>
        </div>
    </div>

</div>

{{-- 3. ANTREAN PERSETUJUAN JADWAL DINAMIS --}}
<div class="bg-white p-6 rounded-2xl shadow mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-[#2D333D]">
            Antrean Persetujuan Jadwal & Lokasi Pengumpulan
        </h2>
        <span class="px-3 py-1 {{ $pendingSchedulesCount > 0 ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-500' }} text-xs font-bold rounded-full">
            {{ $pendingSchedulesCount }} Menunggu
        </span>
    </div>

    <div class="space-y-4 text-sm">
        @forelse($recentSchedules as $schedule)
            <div class="flex justify-between items-center border-b pb-3 last:border-b-0 last:pb-0">
                <div class="flex flex-wrap items-center gap-4 text-gray-600">
                    {{-- Hari & Tanggal --}}
                    <div class="flex items-center gap-1">
                        <x-mdi-calendar class="w-5 h-5 text-[#69C3C1]"/>
                        <span>{{ $schedule->start_date->translatedFormat('l, d F Y') }}</span>
                    </div>

                    {{-- Jam Operasional Penjemputan --}}
                    <div class="flex items-center gap-1 ml-2">
                        <x-mdi-clock-outline class="w-5 h-5 text-[#69C3C1]"/>
                        <span>
                           {{ $schedule->start_date->format('H.i') }} - {{ $schedule->finish_date->format('H.i') }} Wita
                        </span>
                    </div>

                    {{-- Lokasi Drop-Off Point --}}
                    <div class="flex items-center gap-1 ml-2">
                        <x-mdi-map-marker class="w-5 h-5 text-[#69C3C1]"/>
                        <span>{{ $schedule->dropOffPoint->name ?? 'Drop-Off Point Belum Ditentukan' }}</span>
                    </div>
                </div>
                <a href="{{ route('assesor.jadwal') }}" class="text-[#69C3C1] font-semibold hover:underline">Periksa</a>
            </div>
        @empty
            <div class="text-center py-6 text-gray-400 font-medium text-xs">
                ✨ Semua pengajuan jadwal operasional telah divalidasi.
            </div>
        @endforelse
    </div>
</div>

{{-- 4. FOOTER RUNNING CALL TO ACTION --}}
<div class="bg-[#A8C5B5] p-6 rounded-2xl shadow flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h2 class="font-bold text-[#2D333D] text-lg">
            Sistem Manajemen Validasi Sampah & Keuangan
        </h2>
        <p class="text-sm text-gray-700">Pastikan nominal saldo dan data fisik timbangan sampah warga sesuai sebelum melakukan enkripsi/persetujuan.</p>
    </div>
    <div>
        <a href="{{ route('assesor.withdrawal') }}" class="inline-block px-5 py-2.5 bg-[#2D333D] text-white font-bold rounded-xl shadow hover:bg-slate-800 transition text-sm whitespace-nowrap">
            Proses Withdrawal
        </a>
    </div>
</div>

@endsection