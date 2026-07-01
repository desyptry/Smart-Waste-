@extends('user.layout.app')
@section('title', 'Detail Lokasi Pengumpulan')

@section('content')
<div class="container mx-auto p-4 max-w-7xl">
     <!-- Breadcrumb -->
    <nav class="flex mb-5 text-sm text-gray-500 gap-2 items-center">
        <a href="{{ route('user.dashboard') }}" class="hover:text-(--primary)">Dashboard</a>
        <x-mdi-chevron-right class="w-4"/>
        <a href="{{ route('user.jadwal') }}" class="hover:text-(--primary)">Jadwal</a>
        <x-mdi-chevron-right class="w-4"/>
        <span class="text-gray-800 font-medium">Detail</span>
    </nav>
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- KOLOM KIRI: MAPS & INFO LOKASI -->
        <div class="lg:w-2/3 space-y-6">
            <!-- Embed Maps -->
            <div class="bg-white p-3 rounded-3xl shadow-sm border border-gray-100">
                <div class="w-full h-80 rounded-2xl overflow-hidden grayscale-[0.3]">
                    @if($schedule->dropOffPoint->latitude && $schedule->dropOffPoint->longitude) 
                    <iframe 
                        src="https://maps.google.com/maps?q={{ $schedule->dropOffPoint->latitude }},{{ $schedule->dropOffPoint->longitude }}&hl=id;z=14&output=embed" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                     @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                        Peta tidak tersedia
                    </div>
                    @endif
                </div>
                <div class="p-5 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-(--primary) text-white rounded-2xl ">
                            <x-mdi-map-marker-radius class="w-6 h-6"/>
                        </div>
                        <div>
                             <h2 class="text-xl font-bold text-gray-800">{{ $schedule->dropOffPoint->name ?? 'Posko SmartWaste' }}</h2>
                            <p class="text-sm text-gray-500">{{ $schedule->dropOffPoint->location ?? 'Lokasi tidak spesifik' }}</p>
                        </div>
                    </div>
                    @if($schedule->dropOffPoint->latitude && $schedule->dropOffPoint->longitude)
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $schedule->dropOffPoint->latitude }},{{ $schedule->dropOffPoint->longitude }}" target="_blank"
                       class="w-full md:w-auto px-6 py-3 bg-white border-2 border-gray-100 rounded-xl text-sm font-bold flex items-center justify-center gap-2 hover:bg-gray-50 transition">
                        <x-mdi-navigation class="w-4"/> Buka di Google Maps
                    </a>
                    @endif
                </div>
            </div>

        </div>

        <div class="lg:w-1/3">
            <div class="bg-(--text-black) text-white p-6 rounded-3xl sticky top-4 shadow-xl">
                <div class="mb-6">
                    <h3 class="font-bold text-xl mb-1">Daftar Harga Khusus</h3>
                    <p class="text-xs text-gray-400">Harga berlaku hanya untuk lokasi & jadwal ini.</p>
                </div>

                <div class="space-y-4">
                     @forelse($schedule->schedulePrices as $hp)
                    <div class="flex justify-between items-center py-3 border-b border-white/10 last:border-0">
                         <span class="text-sm font-medium text-gray-300">{{ $hp->wasteCategory->name ?? 'Sampah' }}</span>
                        <div class="text-right">
                            <span class="text-sm font-bold text-(--primary)">Rp {{ number_format($hp->price, 0, ',', '.') }}</span>
                            <span class="text-[10px] text-gray-500">/Kg</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-400 text-center text-xs py-4">Belum ada daftar harga khusus untuk jadwal ini.</p>
                    @endforelse
                </div>

                <!-- <div class="mt-8 p-4 bg-white/5 rounded-2xl border border-white/10">
                    <div class="flex items-center gap-3 mb-2">
                        <x-mdi-information-outline class="w-5 text-(--primary)"/>
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Penting</span>
                    </div>
                    <p class="text-[11px] text-gray-300 leading-relaxed">
                        Harga dapat berubah sewaktu-waktu tergantung kebijakan bank sampah pusat. Pastikan sampah sudah dipilah sesuai jenisnya sebelum disetorkan.
                    </p>
                </div> -->
            </div>
        </div>

    </div>
</div>
@endsection