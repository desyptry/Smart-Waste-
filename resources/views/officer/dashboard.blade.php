@extends('officer.layout.app')

@section('content')

@php
$hour = date('H');
if($hour < 12) $greeting = "Pagi";
elseif($hour < 17) $greeting = "Siang";
else $greeting = "Malam";
@endphp

<div class="grid grid-cols-1 gap-6 mb-6">

    <div class="bg-[#2D333D] text-white p-6 rounded-2xl shadow flex justify-between items-center">
        <div>
            <h1 class="text-xl font-semibold">
                Selamat {{ $greeting }}, 
                <span class="font-bold">{{ auth()->user()->name ?? 'Officer' }}</span>
            </h1>

            <p class="text-gray-300 text-sm mt-1">
                Petugas Lapangan • Sistem Monitoring Sampah
            </p>

            <div class="mt-5">
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Kas Keluar Setoran Hari Ini</p>
                <h2 class="text-3xl font-black text-[#69C3C1]">Rp {{ number_format($todayCashOut, 0, ',', '.') }}</h2>
            </div>
        </div>

        <div class="flex flex-col items-end gap-4">
            <x-mdi-bell-outline class="w-6 h-6 text-gray-300"/>
            <img src="https://i.pravatar.cc/40" class="rounded-full shadow" alt="Avatar">
        </div>
    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

    <div class="bg-white p-5 rounded-xl shadow text-center hover:scale-105 transition border-b-4 border-slate-300">
        <p class="text-gray-400 text-xs font-bold uppercase">Warga Aktif</p>
        <h2 class="text-2xl font-black text-[#2D333D] mt-1">{{ $totalWargaAktif }}</h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow text-center hover:scale-105 transition border-b-4 border-[#69C3C1]">
        <p class="text-gray-400 text-xs font-bold uppercase">Total Sampah Terkumpul</p>
        <h2 class="text-2xl font-black text-[#2D333D] mt-1">{{ number_format($totalSampahMassa, 1, ',', '.') }} Kg</h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow text-center hover:scale-105 transition border-b-4 border-emerald-500">
        <p class="text-gray-400 text-xs font-bold uppercase">Setoran Sukses Hari Ini</p>
        <h2 class="text-2xl font-black text-emerald-600 mt-1">{{ $todayDepositsCount }}</h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow text-center hover:scale-105 transition border-b-4 border-red-500">
        <p class="text-gray-400 text-xs font-bold uppercase">Jadwal Perlu Verifikasi</p>
        <h2 class="text-2xl font-black text-red-500 mt-1">{{ $pendingVerificationSchedules }}</h2>
    </div>

</div>

<div class="bg-white p-6 rounded-2xl shadow mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-[#2D333D]"> Jendela Kontrol Jadwal & Validasi Harga </h2>
        <span class="text-xs text-gray-400 font-medium">*Gerbang transaksi terkunci sebelum di-approve Assessor</span>
    </div>

    <div class="space-y-4 text-sm">
        @forelse($schedules as $schedule)
            <div class="border-b border-gray-50 pb-4 last:border-b-0 last:pb-0">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    
                    <div class="flex flex-wrap items-center gap-y-2 text-gray-600">
                        <x-mdi-calendar class="w-5 h-5 text-[#69C3C1]"/>
                        <span class="ml-1 font-semibold">{{ \Carbon\Carbon::parse($schedule->pickup_date)->translatedFormat('l, d M Y') }}</span>

                        <x-mdi-clock-outline class="w-5 h-5 text-[#69C3C1] ml-4"/>
                        <span class="ml-1">{{ \Carbon\Carbon::parse($schedule->pickup_date)->format('H.i') }} Wita</span>

                        <x-mdi-map-marker class="w-5 h-5 text-[#69C3C1] ml-4"/>
                        <span class="ml-1 font-medium text-slate-800">{{ $schedule->dropOffPoint->name ?? '-' }}</span>
                    </div>

                    {{-- Badges Dinamis Status Verifikasi dari Assessor --}}
                    <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
                        @if($schedule->status === 'verified')
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-black uppercase tracking-wider rounded-lg border border-emerald-200">
                                ✓ Verified (Siap Setor)
                            </span>
                        @elseif($schedule->status === 'declined')
                            <span class="px-3 py-1 bg-red-50 text-red-600 text-xs font-black uppercase tracking-wider rounded-lg border border-red-200">
                                ❌ Ditolak Assessor
                            </span>
                        @else
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-xs font-black uppercase tracking-wider rounded-lg border border-amber-200 animate-pulse">
                                ⏳ Menunggu Review Harga
                            </span>
                        @endif

                        <a href="#" class="text-[#69C3C1] font-bold text-xs uppercase hover:underline">Detail</a>
                    </div>
                </div>

                {{-- Alert Khusus jika Jadwal/Harga Ditolak oleh Assessor --}}
                @if($schedule->status === 'declined' && $schedule->declined_reason)
                    <div class="mt-3 p-3 bg-red-50 rounded-xl border border-dashed border-red-200 text-xs text-red-700 flex items-start gap-1.5">
                        <x-mdi-comment-alert-outline class="w-4 h-4 text-red-500 shrink-0 mt-0.5"/>
                        <div>
                            <strong>Alasan Penolakan Assessor:</strong> "{{ $schedule->declined_reason }}" 
                            <br><span class="text-[10px] text-gray-400 font-bold mt-1 block">* Silakan lakukan penyesuaian ulang harga komoditas pada menu manajemen jadwal.</span>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-6 text-gray-400 text-xs font-medium">Belum ada rekaman log jadwal terbit.</div>
        @endforelse
    </div>
</div>

<div class="bg-[#A8C5B5] p-6 rounded-2xl shadow flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h2 class="font-bold text-[#2D333D] text-lg">
            Riwayat Pengumpulan Sampah
        </h2>
        <p class="text-sm text-gray-700 font-medium">Kinerja Otoritas Input Anda Periode: Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
    </div>

    <div class="text-right">
        <p class="text-xs text-gray-600 font-bold uppercase tracking-wider">Total Kas Keluar Terdistribusi</p>
        <h2 class="text-xl font-black text-[#2D333D]">Rp {{ number_format($monthCashOut, 0, ',', '.') }}</h2>
    </div>
</div>

@endsection