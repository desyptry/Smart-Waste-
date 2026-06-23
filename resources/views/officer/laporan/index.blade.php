@extends('officer.layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-[#2D333D] px-8 py-6 rounded-[2rem] shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-xl font-black text-white tracking-wide uppercase">Monitoring Transaksi Nasabah</h1>
            <p class="text-gray-400 text-xs font-medium mt-1">Pantau rangkuman seluruh nota timbangan masuk dan kelola rincian manifes komoditas</p>
        </div>
    </div>

    {{-- Widget Statistik Akumulasi --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="p-4 bg-cyan-50 text-[#69C3C1] rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Berat</p>
                <h3 class="text-xl font-black text-slate-800 mt-0.5">{{ number_format($totalMassa, 2, ',', '.') }} Kg</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="p-4 bg-emerald-50 text-emerald-500 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Kas Keluar</p>
                <h3 class="text-xl font-black text-slate-800 mt-0.5">Rp {{ number_format($totalKas, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="p-4 bg-purple-50 text-purple-500 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Nota Transaksi</p>
                <h3 class="text-xl font-black text-slate-800 mt-0.5">{{ $totalTransaksi }} Nota</h3>
            </div>
        </div>
    </div>

    {{-- Panel Filter & Ekspor Massal --}}
    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm space-y-4">
        <form method="GET" action="{{ route('officer.laporan.index') }}" class="flex flex-col lg:flex-row items-end justify-between gap-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full lg:w-2/3">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-wider ml-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-3 bg-slate-50 border border-gray-100 rounded-xl font-semibold text-sm text-slate-700 outline-none focus:border-[#69C3C1] focus:bg-white transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-wider ml-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-3 bg-slate-50 border border-gray-100 rounded-xl font-semibold text-sm text-slate-700 outline-none focus:border-[#69C3C1] focus:bg-white transition-all">
                </div>
            </div>
            
            <div class="flex w-full lg:w-auto gap-2">
                <button type="submit" class="flex-1 lg:flex-none px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all">Filter</button>
                <a href="{{ route('officer.laporan.index') }}" class="px-4 py-3 bg-gray-100 text-gray-500 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all flex items-center justify-center">Reset</a>
            </div>
        </form>

        <hr class="border-gray-100">

        {{-- Opsi Global Export (Mengekspor seluruh rekap baris master berdasarkan filter tanggal) --}}
        <div class="flex items-center gap-2 pt-2">
            <span class="text-xs font-bold text-gray-400 mr-2">Opsi Ekspor Data Kontrol:</span>
            <a href="{{ route('officer.laporan.excel', request()->all()) }}" class="flex items-center gap-1.5 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md transition-all">
                📥 Export Rangkuman Jurnal Nota (.XLS)
            </a>
        </div>
    </div>

    {{-- Tabel Utama Monitoring Log Master --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#F4F9FC] text-[10px] font-black uppercase tracking-wider text-slate-800 border-b border-gray-100">
                    <tr>
                        <th class="p-4 pl-6">ID Transaksi</th>
                        <th class="p-4">Tanggal Setor</th>
                        <th class="p-4">Nama Nasabah</th>
                        <th class="p-4">Lokasi Drop-Off</th>
                        <th class="p-4 text-center">Variasi Sampah</th>
                        <th class="p-4">Total Muatan</th>
                        <th class="p-4">Total Kas Keluar</th>
                        <th class="p-4 text-center pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    @forelse($reports as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 font-black text-slate-800 pl-6">#TRX-{{ $item->id }}</td>
                            <td class="p-4 text-xs text-gray-400">{{ \Carbon\Carbon::parse($item->deposit_date)->translatedFormat('d M Y, H:i') }} Wita</td>
                            <td class="p-4 text-slate-700 font-bold">{{ $item->user->name ?? 'Masyarakat Umum' }}</td>
                            <td class="p-4 text-slate-500 text-xs">{{ $item->dropOffPoint->name ?? '-' }}</td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 bg-purple-50 text-purple-600 rounded-lg text-xs font-black">
                                    {{ $item->total_items }} Jenis
                                </span>
                            </td>
                            <td class="p-4 font-black text-slate-700">{{ number_format($item->total_weight ?? 0, 2, ',', '.') }} Kg</td>
                            <td class="p-4 text-emerald-600 font-black">Rp {{ number_format($item->total_price ?? 0, 0, ',', '.') }}</td>
                            <td class="p-4 text-center pr-6">
                                {{-- Tombol Menuju Halaman Detail Dedicated Transaksi --}}
                                <a href="{{ route('officer.laporan.showPage', $item->id) }}" class="inline-block bg-[#F4F9FC] hover:bg-[#69C3C1] text-[#69C3C1] hover:text-white px-4 py-2 rounded-xl font-black text-xs transition-all border border-transparent shadow-sm">
                                    Lihat Rincian & Cetak ➔
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-gray-400 font-medium">Tidak ada rekaman transaksi setoran dalam database atau filter tanggal salah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Navigasi Paginasi Halaman --}}
        @if($reports->hasPages())
            <div class="p-4 border-t border-gray-50 bg-gray-50/50">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection