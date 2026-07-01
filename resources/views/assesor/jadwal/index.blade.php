@extends('assesor.layout.app')

@section('content')

{{-- Alert Notifikasi Sukses/Gagal Otorisasi --}}
@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl font-semibold text-sm flex items-center gap-2 shadow-sm">
        <x-mdi-check-circle class="w-5 h-5 text-emerald-500"/>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl font-semibold text-sm flex items-center gap-2 shadow-sm">
        <x-mdi-alert-circle class="w-5 h-5 text-red-500"/>
        {{ session('error') }}
    </div>
@endif

{{-- Header Menu --}}
<div class="grid grid-cols-1 gap-6 mb-6">
    <div class="bg-[#2D333D] text-white p-6 rounded-2xl shadow flex justify-between items-center">
        <div>
            <h1 class="text-xl font-semibold uppercase tracking-wide">
                Verifikasi Jadwal Drop-Off
            </h1>
            <p class="text-gray-300 text-sm mt-1">
                Daftar pengajuan jadwal dan harga komoditas pada wilayah penugasan Anda.
            </p>
        </div>
        <div class="p-3 bg-slate-700/50 rounded-xl text-[#69C3C1]">
            <x-mdi-calendar class="w-7 h-7"/>
        </div>
    </div>
</div>

{{-- Panel Daftar Antrean Utama --}}
<div class="bg-white p-6 rounded-2xl shadow mb-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="font-bold text-[#2D333D] text-base">
                Antrean Persetujuan Jadwal & Lokasi Pengumpulan
            </h2>
            <p class="text-xs text-gray-400 mt-0.5">Sistem memfilter otomatis berdasarkan hak akses posko penugasan Anda.</p>
        </div>
        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-black rounded-full shadow-sm">
            {{ $schedules->count() }} Menunggu Verifikasi
        </span>
    </div>

    <div class="space-y-4 text-sm">
        @forelse($schedules as $schedule)
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-100 pb-4 last:border-b-0 last:pb-0 gap-4">
                
                {{-- Detail Manifest Jadwal --}}
                <div class="flex flex-wrap items-center gap-y-2 gap-x-6 text-gray-600">
                    {{-- Hari & Tanggal --}}
                    <div class="flex items-center gap-2">
                        <x-mdi-calendar class="w-5 h-5 text-[#69C3C1] shrink-0"/>
                        <span class="font-semibold text-slate-700">
                            {{ $schedule->start_date->translatedFormat('l, d F Y') }}
                        </span>
                    </div>

                    {{-- Jam Operasional --}}
                    <div class="flex items-center gap-2">
                        <x-mdi-clock-outline class="w-5 h-5 text-[#69C3C1] shrink-0"/>
                        <span class="font-medium">
                            {{ $schedule->start_date->format('H.i') }} - {{ $schedule->finish_date->format('H.i') }} Wita
                        </span>
                    </div>

                    {{-- Nama Drop-Off Point (Lokasi) --}}
                    <div class="flex items-center gap-2">
                        <x-mdi-map-marker class="w-5 h-5 text-[#69C3C1] shrink-0"/>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-800 text-xs font-bold rounded-lg">
                            {{ $schedule->dropOffPoint->name ?? 'Drop-Off Point Terikat' }}
                        </span>
                    </div>
                </div>

                {{-- Tombol Aksi Menuju Halaman Komparasi Harga --}}
                <div class="w-full sm:w-auto text-right">
                    <a href="{{ route('assesor.jadwal.review', $schedule->id) }}" class="inline-block text-center w-full sm:w-auto px-4 py-2 bg-[#69C3C1] hover:bg-[#57A3A1] text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow transition-all transform hover:-translate-y-0.5">
                        Review Harga ➔
                    </a>
                </div>

            </div>
        @empty
            {{-- Kondisi jika antrean bersih --}}
            <div class="text-center py-12 bg-slate-50/50 rounded-xl border border-dashed border-gray-200">
                <x-mdi-calendar-check class="w-12 h-12 text-gray-300 mx-auto mb-2"/>
                <p class="text-slate-700 font-bold text-sm">Kerja Bagus!</p>
                <p class="text-xs text-gray-400 mt-0.5">Tidak ada pengajuan jadwal baru yang perlu ditinjau saat ini.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Info Banner Penutup --}}
<div class="bg-[#A8C5B5] p-6 rounded-2xl shadow flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h2 class="font-bold text-[#2D333D] text-lg">
            Sistem Manajemen Validasi Sampah & Keuangan
        </h2>
        <p class="text-sm text-gray-700">Warga tidak dapat melakukan transaksi setoran pada pos lapangan sebelum Anda menyetujui validitas fluktuasi harga yang diajukan.</p>
    </div>
</div>

@endsection