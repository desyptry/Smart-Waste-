@extends('officer.layout.app')

@section('content')
<div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">

    <div class="bg-[#2D333D] px-8 py-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-xl font-black text-white tracking-wide uppercase">Jadwal Pengumpulan Sampah</h1>
            <p class="text-gray-400 text-xs font-medium mt-1">Kelola waktu operasional dan titik kumpul drop-off petugas</p>
        </div>
        
        <a href="{{route('officer.jadwal.create')}}" class="flex items-center gap-2 px-6 py-3 bg-[#69C3C1] hover:bg-[#58A8A6] text-white font-black text-sm rounded-xl shadow-lg shadow-cyan-900/20 transition-all transform hover:-translate-y-0.5 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jadwal
        </a>
    </div>

    <div class="p-6 md:p-8">
        {{-- TABEL DATA (Disesuaikan dengan field Migration: pickup_schedules) --}}
        <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm">
            <table class="w-full text-sm border-collapse text-left bg-white">
                <thead>
                    <tr class="bg-[#F4F9FC] text-slate-800 border-b border-gray-100">
                        <th class="p-4 font-black uppercase text-[10px] tracking-wider pl-6">No</th>
                        <th class="p-4 font-black uppercase text-[10px] tracking-wider">Titik Kumpul</th>
                        <th class="p-4 font-black uppercase text-[10px] tracking-wider">Waktu Mulai</th>
                        <th class="p-4 font-black uppercase text-[10px] tracking-wider">Waktu Selesai</th>
                        <th class="p-4 font-black uppercase text-[10px] tracking-wider text-center pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    {{-- Contoh Baris Data 1 --}}
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-bold text-slate-500 pl-6">1</td>
                        <td class="p-4 font-black text-slate-800">Drop-Off Point Utama</td>
                        <td class="p-4 font-semibold text-gray-600">12 Juni 2026, 08:00</td>
                        <td class="p-4 font-semibold text-gray-600">12 Juni 2026, 12:00</td>
                        <td class="p-4 text-center pr-6">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="bg-[#F4F9FC] hover:bg-[#69C3C1] text-[#69C3C1] hover:text-white px-4 py-2 rounded-xl font-black text-xs transition-all border border-transparent hover:border-[#69C3C1] shadow-sm flex items-center gap-1.5">
                                    Kelola
                                </a>
                                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-xl font-bold text-xs transition-all">
                                    Edit
                                </button>
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl font-bold text-xs transition-all">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Contoh Baris Data 2 --}}
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-bold text-slate-500 pl-6">2</td>
                        <td class="p-4 font-black text-slate-800">Gudang Logistik Sektor B</td>
                        <td class="p-4 font-semibold text-gray-600">13 Juni 2026, 09:00</td>
                        <td class="p-4 font-semibold text-gray-600">13 Juni 2026, 15:00</td>
                        <td class="p-4 text-center pr-6">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="bg-[#F4F9FC] hover:bg-[#69C3C1] text-[#69C3C1] hover:text-white px-4 py-2 rounded-xl font-black text-xs transition-all border border-transparent hover:border-[#69C3C1] shadow-sm flex items-center gap-1.5">
                                    Kelola
                                </a>
                                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-xl font-bold text-xs transition-all">
                                    Edit
                                </button>
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl font-bold text-xs transition-all">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
