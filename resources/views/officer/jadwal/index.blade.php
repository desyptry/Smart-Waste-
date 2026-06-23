@extends('officer.layout.app')

@section('content')
<div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">

    <div class="bg-[#2D333D] px-8 py-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-xl font-black text-white tracking-wide uppercase">Jadwal Pengumpulan Sampah</h1>
            <p class="text-gray-400 text-xs font-medium mt-1">Kelola waktu operasional dan titik kumpul drop-off petugas</p>
        </div>
        
        <a href="{{ route('officer.jadwal.create') }}" class="flex items-center gap-2 px-6 py-3 bg-[#69C3C1] hover:bg-[#58A8A6] text-white font-black text-sm rounded-xl shadow-lg shadow-cyan-900/20 transition-all transform hover:-translate-y-0.5 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jadwal
        </a>
    </div>

    <div class="p-6 md:p-8">
        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl font-semibold text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Tambahan: Notifikasi Gagal / Error --}}
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl font-semibold text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

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
                    @forelse($pickup_schedules as $schedule)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 font-bold text-slate-500 pl-6">{{ $loop->iteration }}</td>
                            
                            <td class="p-4 font-black text-slate-800">
                                {{ $schedule->dropOffPoint->name ?? $schedule->dropOffPoint->nama_titik ?? 'Titik Tidak Diketahui' }}
                            </td>
                            
                            <td class="p-4 font-semibold text-gray-600">
                                {{ \Carbon\Carbon::parse($schedule->start_date)->translatedFormat('d F Y, H:i') }}
                            </td>
                            <td class="p-4 font-semibold text-gray-600">
                                {{ \Carbon\Carbon::parse($schedule->finish_date)->translatedFormat('d F Y, H:i') }}
                            </td>
                            
                            <td class="p-4 text-center pr-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('officer.jadwal.detail', $schedule->id) }}" class="bg-[#F4F9FC] hover:bg-[#69C3C1] text-[#69C3C1] hover:text-white px-4 py-2 rounded-xl font-black text-xs transition-all border border-transparent hover:border-[#69C3C1] shadow-sm flex items-center gap-1.5">
                                        Kelola
                                    </a>
                                    
                                    <a href="{{ route('officer.jadwal.edit', $schedule->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-xl font-bold text-xs transition-all block">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('officer.jadwal.delete', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl font-bold text-xs transition-all">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 font-medium">
                                Belum ada jadwal pengumpulan sampah saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection