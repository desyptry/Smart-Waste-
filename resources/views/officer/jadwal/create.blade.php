@extends('officer.layout.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
    
    <div class="bg-[#2D333D] px-8 py-6 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-black text-white tracking-wide uppercase">Tambah Jadwal Pengumpulan</h1>
            <p class="text-gray-400 text-xs font-medium mt-1">Buat slot jadwal operasional baru untuk petugas lapangan</p>
        </div>
        <a href="{{ route('officer.jadwal') }}" class="text-xs font-bold text-[#69C3C1] hover:underline uppercase tracking-wider flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="p-8 md:p-10">
        <form id="create-schedule-form" action="{{ route('officer.jadwal.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Titik Kumpul / Drop-Off Point</label>
        
                <select name="collection_point_id" required class="w-full px-6 py-4 bg-[#F8FAFC] border-2 @error('collection_point_id') border-red-400 @else border-transparent @enderror rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 focus:bg-white focus:border-[#69C3C1] focus:ring-4 focus:ring-[#69C3C1]/10">
                    <option value="" disabled {{ old('collection_point_id') ? '' : 'selected' }}>Pilih Titik Kumpul Penugasan...</option>
                    @forelse($dropOffPoints as $point)
                        <option value="{{ $point->dropOffPoint->id }}" {{ old('collection_point_id') == $point->dropOffPoint->id ? 'selected' : '' }}>
                            {{ $point->dropOffPoint->name }} {{ $point->dropOffPoint->location  }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada lokasi titik kumpul yang tersedia</option>
                    @endforelse
                </select>

                @error('collection_point_id')
                    <p class="text-red-500 text-xs font-semibold ml-1 mt-1">{{ $message }}</p>
                @enderror
            </div>



            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Waktu Mulai --}}
                <div class="space-y-2">
                    <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Waktu Mulai Operasional</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required 
                           class="w-full px-6 py-4 bg-[#F8FAFC] border-2 @error('start_date') border-red-400 @else border-transparent @enderror rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 focus:bg-white focus:border-[#69C3C1] focus:ring-4 focus:ring-[#69C3C1]/10">
                    @error('start_date')
                        <p class="text-red-500 text-xs font-semibold ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Waktu Selesai --}}
                <div class="space-y-2">
                    <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Waktu Selesai Operasional</label>
                    <input type="datetime-local" name="finish_date" value="{{ old('finish_date') }}" required 
                           class="w-full px-6 py-4 bg-[#F8FAFC] border-2 @error('finish_date') border-red-400 @else border-transparent @enderror rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 focus:bg-white focus:border-[#69C3C1] focus:ring-4 focus:ring-[#69C3C1]/10">
                    @error('finish_date')
                        <p class="text-red-500 text-xs font-semibold ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>


            <div class="pt-4 flex justify-end gap-4">
                <a href="{{ route('officer.jadwal') }}" class="px-6 py-4 bg-gray-100 hover:bg-gray-200 text-slate-600 font-black text-sm rounded-2xl transition-all flex items-center justify-center">
                    Batalkan
                </a>
                <button type="submit" 
                        class="px-8 py-4 bg-[#69C3C1] hover:bg-[#58A8A6] text-white font-black text-sm rounded-2xl shadow-xl shadow-cyan-100 transform hover:-translate-y-0.5 transition-all duration-300 active:scale-95">
                    Simpan Jadwal Baru
                </button>
            </div>
        </form>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('select, input').on('focus', function() {
            $(this).closest('.space-y-2').find('label').addClass('text-[#69C3C1]');
        }).on('blur', function() {
            $(this).closest('.space-y-2').find('label').removeClass('text-[#69C3C1]');
        });

        $('#create-schedule-form').on('submit', function() {
            // Hanya jalankan animasi loading jika HTML5 validation terpenuhi
            if(this.checkValidity()) {
                const $btn = $(this).find('button[type="submit"]');
                $btn.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');
                $btn.html('<svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>');
            }
        });
    });
</script>
@endsection
