@extends('user.layout.app')
@section('title', 'Jadwal Pengumpulan')

@section('content')
<div class="container mx-auto p-4 max-w-7xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Jadwal Pengumpulan Sampah</h2>
        <p class="text-sm text-gray-500">Temukan lokasi penjemputan terdekat dari tempat tinggalmu.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jadwal as $item)
            @php
                $isFinished = $item->finish_date->isPast();
                $statusText = $isFinished ? 'Selesai' : 'Akan Datang';
            @endphp

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition">
                <h3 class="font-bold text-lg text-gray-800 mb-1">
                    {{ $item->dropOffPoint->name ?? 'Posko SmartWaste' }}
                </h3>
                
                <div class="space-y-2 mb-6">
                    <p class="text-sm text-gray-500 flex items-center gap-2">
                        <x-mdi-calendar-month-outline class="w-4 text-cyan-500"/> 
                        {{ $item->start_date->translatedFormat('d M Y') }}
                    </p>
                    <p class="text-sm text-gray-500 flex items-center gap-2">
                        <x-mdi-clock-outline class="w-4 text-cyan-500"/> 
                        {{ $item->start_date->format('H.i') }} - {{ $item->finish_date->format('H.i') }}
                    </p>
                    
                    <div class="pt-2">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ !$isFinished ? 'bg-(--text-black) text-(--primary)' : 'bg-gray-100 text-gray-400' }}">
                            {{ $statusText }}
                        </span>
                    </div>
                </div>
                
                <a href="{{ route('user.jadwal.show', $item->id) }}" 
                   class="mt-auto w-full py-3 rounded-xl border-2 border-gray-50 text-center font-bold text-sm text-gray-600 hover:bg-(--primary) hover:text-white hover:border-(--primary) transition">
                    Cek Harga & Lokasi
                </a>
            </div>
        @empty
            <div class="col-span-full text-center text-sm text-gray-500 py-12">
                Tidak ada jadwal pengumpulan terdaftar.
            </div>
        @endforelse
    </div>
</div>
@endsection