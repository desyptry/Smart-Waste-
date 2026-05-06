@extends('user.layout.app')
@section('title', 'Detail Lokasi Pengumpulan')

@section('content')
<div class="container mx-auto p-4 max-w-7xl">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- KOLOM KIRI: MAPS & INFO LOKASI -->
        <div class="lg:w-2/3 space-y-6">
            <!-- Embed Maps -->
            <div class="bg-white p-3 rounded-3xl shadow-sm border border-gray-100">
                <div class="w-full h-80 rounded-2xl overflow-hidden grayscale-[0.3]">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.345678!2d115.212345!3d-8.678901!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwNDAnNDQuMCJTIDExNcKwMTInNDQuNCJF!5e0!3m2!1sid!2sid!4v1234567890" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
                <div class="p-5 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-(--primary) text-white rounded-2xl ">
                            <x-mdi-map-marker-radius class="w-6 h-6"/>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Balai Br. Ambengan</h2>
                            <p class="text-sm text-gray-500">Jl. Ambengan No.12, Denpasar Timur, Bali</p>
                        </div>
                    </div>
                    <button class="w-full md:w-auto px-6 py-3 bg-white border-2 border-gray-100 rounded-xl text-sm font-bold flex items-center justify-center gap-2 hover:bg-gray-50">
                        <x-mdi-navigation class="w-4"/> Buka di Google Maps
                    </button>
                </div>
            </div>

            <!-- List Sampah yang Diterima -->
            <!-- <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-lg mb-4">Jenis Sampah yang Diterima</h3>
                <div class="flex flex-wrap gap-2">
                    <span class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium">#PlastikPET</span>
                    <span class="px-4 py-2 bg-orange-50 text-orange-600 rounded-xl text-sm font-medium">#Kardus</span>
                    <span class="px-4 py-2 bg-gray-50 text-gray-600 rounded-xl text-sm font-medium">#Logam</span>
                    <span class="px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-medium">#MinyakJelantah</span>
                </div>
            </div> -->
        </div>

        <div class="lg:w-1/3">
            <div class="bg-(--text-black) text-white p-6 rounded-3xl sticky top-4 shadow-xl">
                <div class="mb-6">
                    <h3 class="font-bold text-xl mb-1">Daftar Harga Khusus</h3>
                    <p class="text-xs text-gray-400">Harga berlaku hanya untuk lokasi & jadwal ini.</p>
                </div>

                <div class="space-y-4">
                    @php
                        $hargaLokasi = [
                            ['nama' => 'Botol PET 3', 'harga' => '1.200'],
                            ['nama' => 'Kardus Bersih', 'harga' => '2.500'],
                            ['nama' => 'Kaleng Softdrink', 'harga' => '8.000'],
                            ['nama' => 'Kertas Koran', 'harga' => '1.500'],
                            ['nama' => 'Minyak Jelantah', 'harga' => '5.000'],
                        ];
                    @endphp

                    @foreach($hargaLokasi as $h)
                    <div class="flex justify-between items-center py-3 border-b border-white/10 last:border-0">
                        <span class="text-sm font-medium text-gray-300">{{ $h['nama'] }}</span>
                        <div class="text-right">
                            <span class="text-sm font-bold text-(--primary)">Rp {{ $h['harga'] }}</span>
                            <span class="text-[10px] text-gray-500">/Kg</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 p-4 bg-white/5 rounded-2xl border border-white/10">
                    <div class="flex items-center gap-3 mb-2">
                        <x-mdi-information-outline class="w-5 text-(--primary)"/>
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Penting</span>
                    </div>
                    <p class="text-[11px] text-gray-300 leading-relaxed">
                        Harga dapat berubah sewaktu-waktu tergantung kebijakan bank sampah pusat. Pastikan sampah sudah dipilah sesuai jenisnya.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection