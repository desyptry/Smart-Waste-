@extends('user.layout.app')
@section('page-title', 'Daftar Sampah')
@section('title', 'Katalog Sampah')

@section('content')
<div class="container mx-auto p-4 max-w-7xl">
    <div class="wrapper flex flex-col w-full gap-8">
        
        <!-- Bagian Header & Pencarian -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Katalog Sampah</h2>
                <p class="text-sm text-gray-500">Pilih kategori sampah untuk melihat detail harga dan cara penanganan.</p>
            </div>
            
            <!-- Bar Pencarian -->
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-mdi-magnify class="w-5 text-gray-400"/>
                </div>
                <input type="text" 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-(--primary) focus:border-transparent sm:text-sm transition-all shadow-sm" 
                    placeholder="Cari jenis sampah (contoh: Plastik, Kertas...)">
            </div>
        </div>

        <!-- Grid Daftar Sampah -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @foreach ($daftarSampah as $sampah)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-shadow group">
                <!-- Foto Sampah -->
                <div class="h-48 w-full overflow-hidden relative">
                    <img src="{{ asset('storage/' . $sampah['photo']) }}" alt="{{ $sampah['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-3 left-3">
                        {{-- <span class="bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-(--secondary) shadow-sm">
                            {{ $sampah['category'] }}
                        </span> --}}
                    </div>
                </div>

                <!-- Konten Teks -->
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-lg text-gray-800 leading-tight mb-2">{{ $sampah['name'] }}</h3>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-6">
                        {{ $sampah['description'] }}
                    </p>

                    <!-- Tombol Detail -->
                    <div class="mt-auto pt-4 border-t border-gray-50">
                        <a href="{{ url('/user/sampah/'.$sampah['id']) }}" 
                           class="flex items-center justify-center gap-2 w-full bg-[#f0f9f4] hover:bg-(--primary) text-(--primary) hover:text-white font-bold py-2.5 rounded-xl transition-all text-sm">
                            Lihat Detail
                            <x-mdi-arrow-right class="w-4"/>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection