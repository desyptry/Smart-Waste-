@extends('officer.layout.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
    
    <div class="bg-[#2D333D] px-8 py-6 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-black text-white tracking-wide uppercase">Tambah Jadwal Pengumpulan</h1>
            <p class="text-gray-400 text-xs font-medium mt-1">Buat slot jadwal operasional baru untuk petugas lapangan</p>
        </div>
        <a href="#" class="text-xs font-bold text-[#69C3C1] hover:underline uppercase tracking-wider flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="p-8 md:p-10">
        <form id="create-schedule-form" action="#" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Titik Kumpul / Drop-Off Point</label>
                <select name="collection_point_id" required 
                        class="w-full px-6 py-4 bg-[#F8FAFC] border-2 border-transparent rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 focus:bg-white focus:border-[#69C3C1] focus:ring-4 focus:ring-[#69C3C1]/10">
                    <option value="" disabled selected class="text-gray-400">Pilih titik kumpul lokasi...</option>
                    {{-- Loop data drop-off points dari controller nantinya --}}
                    <option value="1">Drop-Off Point Utama (Sektor A)</option>
                    <option value="2">Gudang Logistik Sektor B</option>
                    <option value="3">Pos Pengumpulan Wilayah C</option>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Waktu Mulai Operasional</label>
                    <input type="datetime-local" name="start_date" required 
                           class="w-full px-6 py-4 bg-[#F8FAFC] border-2 border-transparent rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 focus:bg-white focus:border-[#69C3C1] focus:ring-4 focus:ring-[#69C3C1]/10">
                </div>

                <div class="space-y-2">
                    <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Waktu Selesai Operasional</label>
                    <input type="datetime-local" name="finish_date" required 
                           class="w-full px-6 py-4 bg-[#F8FAFC] border-2 border-transparent rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 focus:bg-white focus:border-[#69C3C1] focus:ring-4 focus:ring-[#69C3C1]/10">
                </div>
            </div>

            <div class="bg-[#F4F9FC] p-4 rounded-2xl flex items-start gap-3 border border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#69C3C1] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs font-semibold text-slate-600 leading-relaxed">
                    Kategori harga sampah untuk jadwal ini dapat diatur secara spesifik setelah jadwal berhasil disimpan dengan menekan tombol <strong class="text-slate-800">"Kelola Harga"</strong> pada tabel utama.
                </p>
            </div>

            <div class="pt-4 flex justify-end gap-4">
                <button type="button" class="px-6 py-4 bg-gray-100 hover:bg-gray-200 text-slate-600 font-black text-sm rounded-2xl transition-all">
                    Batalkan
                </button>
                <button type="submit" 
                        class="px-8 py-4 bg-[#69C3C1] hover:bg-[#58A8A6] text-white font-black text-sm rounded-2xl shadow-xl shadow-cyan-100 transform hover:-translate-y-0.5 transition-all duration-300 active:scale-95">
                    Simpan Jadwal Baru
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Integrasi Interaksi jQuery --}}
<script type="module">
    $(document).ready(function() {
        // Efek transisi warna label saat elemen di dalam form mendapatkan fokus
        $('select, input').on('focus', function() {
            $(this).closest('.space-y-2').find('label').addClass('text-[#69C3C1]');
        }).on('blur', function() {
            $(this).closest('.space-y-2').find('label').removeClass('text-[#69C3C1]');
        });

        // Efek animasi loading saat menekan tombol simpan jadwal
        $('#create-schedule-form').on('submit', function() {
            const $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');
            $btn.html('<svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>');
        });
    });
</script>
@endsection
