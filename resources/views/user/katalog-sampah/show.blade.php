@extends('user.layout.app')
@section('page-title', 'Detail Sampah')

@section('content')
<div class="container mx-auto p-4 max-w-5xl">
    <!-- Breadcrumb -->
    <nav class="flex mb-5 text-sm text-gray-500 gap-2 items-center">
        <a href="{{ route('user.dashboard') }}" class="hover:text-(--primary)">Dashboard</a>
        <x-mdi-chevron-right class="w-4"/>
        <a href="{{ route('user.katalog-sampah') }}" class="hover:text-(--primary)">Katalog Sampah</a>
        <x-mdi-chevron-right class="w-4"/>
        <span class="text-gray-800 font-medium">Detail</span>
    </nav>

    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row">
            
            <!-- Bagian Foto (Kiri/Atas) -->
            <div class="md:w-1/2 h-72 md:h-auto relative">
                <img src="{{asset('images/kresek.jpg') }}" 
                     alt="Detail Sampah" 
                     class="w-full h-full object-cover">
                <div class="absolute top-4 left-4">
                    <span class="bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest text-(--secondary) shadow-sm">
                        Kategori: Plastik
                    </span>
                </div>
            </div>

            <!-- Bagian Info (Kanan/Bawah) -->
            <div class="md:w-1/2 p-8 md:p-12 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <h1 class="text-3xl font-bold text-gray-800">Botol Plastik PET</h1>
                </div>

                <div class=" mb-6">
                    <span class="text-2xl font-bold text-(--primary)">Rp 1.000</span>
                    <span class="text-gray-400 text-sm">/ Kilogram (rata-rata)*</span>
                    <p class='text-red-400 text-xs'>*Harga dapat berbeda sesuai lokasi pengumpulan</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-2">Deskripsi </h3>
                        <p class="text-gray-600 ">
                            Botol plastik jenis Polyethylene Terephthalate (PET) biasanya ditemukan pada kemasan air mineral, jus, dan minuman ringan lainnya. Sampah ini sangat mudah didaur ulang kembali menjadi serat kain atau botol baru.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold uppercase text-gray-400 mb-2">Instruksi Penanganan</h3>
                        <ul class="space-y-2 list-disc list-inside">
                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                Lepaskan label plastik jika memungkinkan.
                            </li>
                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                Bilas sisa minuman di dalam botol.
                            </li>
                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                Remas botol untuk menghemat ruang penyimpanan.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- <div class="mt-10">
                    <button class="w-full bg-(--text-black) hover:bg-gray-800 text-white font-bold py-4 rounded-2xl transition-all shadow-lg flex items-center justify-center gap-3">
                        <x-mdi-calendar-check class="w-5"/>
                        Jadwalkan Penjemputan
                    </button>
                </div> -->
            </div>

        </div>
    </div>
</div>
@endsection