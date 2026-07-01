<div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 md:p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
    <div class="flex items-center gap-4">
        <div class="p-4 bg-[#F4F9FC] text-[#69C3C1] rounded-2xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Detail Operasional Jadwal</h1>
            </div>
            <p class="text-gray-500 font-semibold text-sm mt-1">Titik Kumpul: <span class="text-slate-800 font-black">{{ $schedule->dropOffPoint->name ?? 'Drop-Off' }}</span></p>
        </div>
    </div>
    
    <a href="{{ route('officer.jadwal') }}" class="text-xs font-black text-gray-400 hover:text-slate-800 uppercase tracking-wider flex items-center gap-1 bg-gray-50 hover:bg-gray-100 px-4 py-2 rounded-xl transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Daftar Jadwal
    </a>
</div>

<div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200 pb-px">
    {{-- 1. Ringkasan / Dashboard Utama Jadwal --}}
    <a href="{{ route('officer.jadwal.detail', $schedule->id) }}" class="px-6 py-3 font-black text-sm tracking-wider uppercase rounded-t-2xl transition-all border-b-4 {{ Request::routeIs('officer.jadwal.detail') ? 'border-[#69C3C1] text-[#69C3C1]' : 'border-transparent text-gray-400 hover:text-slate-700' }}">
        Ringkasan
    </a>

    {{-- 2. Kelola Harga Sampah (Sudah Diperbaiki) --}}
    <a href="{{ route('officer.jadwal.detail.harga', $schedule->id) }}" class="px-6 py-3 font-black text-sm tracking-wider uppercase rounded-t-2xl transition-all border-b-4 {{ Request::routeIs('officer.jadwal.detail.harga') ? 'border-[#69C3C1] text-[#69C3C1]' : 'border-transparent text-gray-400 hover:text-slate-700' }}">
        Kelola Harga Sampah
    </a>

    {{-- 3. Input Setoran Sampah --}}
    <a href="{{ route('officer.jadwal.detail.setoran', $schedule->id) }}" class="px-6 py-3 font-black text-sm tracking-wider uppercase rounded-t-2xl transition-all border-b-4 {{ Request::routeIs('officer.jadwal.detail.setoran') ? 'border-[#69C3C1] text-[#69C3C1]' : 'border-transparent text-gray-400 hover:text-slate-700' }}">
        Input Setoran Sampah
    </a>

    {{-- 4. Riwayat Timbangan --}}
    <a href="{{route('officer.jadwal.detail.riwayat',$schedule->id)}}" class="px-6 py-3 font-black text-sm tracking-wider uppercase rounded-t-2xl transition-all border-b-4 {{ Request::routeIs('officer.jadwal.detail.riwayat') ? 'border-[#69C3C1] text-[#69C3C1]' : 'border-transparent text-gray-400 hover:text-slate-700' }}">
        Riwayat Timbangan
    </a>
</div>
