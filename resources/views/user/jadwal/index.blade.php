@extends('user.layout.app')
@section('title', 'Jadwal Pengumpulan')

@section('content')
<div class="container mx-auto p-4 max-w-7xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Jadwal Pengumpulan Sampah</h2>
        <p class="text-sm text-gray-500">Temukan lokasi penjemputan terdekat dari tempat tinggalmu.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $jadwal = [
                ['id' => 1, 'tempat' => 'Balai Br. Ambengan', 'tgl' => '27 Mar 2026', 'jam' => '08.00 - 10.00', 'status' => 'Akan Datang'],
                ['id' => 2, 'tempat' => 'Lapangan Renon', 'tgl' => '28 Mar 2026', 'jam' => '09.00 - 12.00', 'status' => 'Akan Datang'],
                ['id' => 3, 'tempat' => 'Wantilan Desa', 'tgl' => '25 Mar 2026', 'jam' => '08.00 - 11.00', 'status' => 'Selesai'],
            ];
        @endphp

        @foreach($jadwal as $item)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col">

            
            <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $item['tempat'] }}</h3>
            <div class="space-y-2 mb-6">
                <p class="text-sm text-gray-500 flex items-center gap-2">
                    <x-mdi-calendar-month-outline class="w-4"/> {{ $item['tgl'] }}
                </p>
                <p class="text-sm text-gray-500 flex items-center gap-2">
                    <x-mdi-clock-outline class="w-4"/> {{ $item['jam'] }}
                </p>
                            <div class="flex justify-between items-start mb-4">

                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $item['status'] == 'Akan Datang' ? 'bg-(--text-black) text-(--primary)' : 'bg-gray-100 text-gray-400' }}">
                    {{ $item['status'] }}
                </span>
            </div>
            </div>

            <a href="{{ url('/user/jadwal/'.$item['id']) }}" 
               class="mt-auto w-full py-3 rounded-xl border-2 border-gray-50 text-center font-bold text-sm text-gray-600 hover:bg-(--primary) hover:text-white hover:border-(--primary)">
                Cek Harga & Lokasi
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection