@extends('admin.layout.app') {{-- Sesuaikan nama layout dashboard admin Anda --}}

@section('content')
<div class="space-y-6 text-slate-700">
    {{-- 1. HEADER BANNER --}}
    <div class="bg-[#1E293B] px-8 py-6 rounded-[2rem] shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-xl font-black text-white tracking-wide uppercase">Konsol Laporan Global & Jurnal Audit</h1>
            <p class="text-gray-400 text-xs font-medium mt-1">
                Hak Akses: <span class="text-[#69C3C1] font-bold">Super Admin</span> (Memantau seluruh aktivitas transaksi, pencairan, dan jadwal posko)
            </p>
        </div>
        <a href="{{ route('admin.laporan.exportExcel') }}" class="flex items-center gap-1.5 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md transition-all">
            📥 Export Master Database (.XLS)
        </a>
    </div>

    {{-- 2. GRID 4 WIDGET STATISTIK UTAMA EKOSISTEM --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 border-l-4 border-cyan-500">
            <div class="p-3 bg-cyan-50 text-cyan-500 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Massa Terkumpul</p>
                <h3 class="text-lg font-black text-slate-800 mt-0.5">{{ number_format($grandTotalMassa, 2, ',', '.') }} Kg</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 border-l-4 border-emerald-500">
            <div class="p-3 bg-emerald-50 text-emerald-500 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Omset Konversi Kas</p>
                <h3 class="text-lg font-black text-slate-800 mt-0.5">Rp {{ number_format($grandTotalKasKeluar, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 border-l-4 border-amber-500">
            <div class="p-3 bg-amber-50 text-amber-500 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">WD Tertahan (Pending)</p>
                <h3 class="text-lg font-black text-amber-600 mt-0.5">Rp {{ number_format($totalWdPending, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 border-l-4 border-indigo-500">
            <div class="p-3 bg-indigo-50 text-indigo-500 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">WD Berhasil Cair</p>
                <h3 class="text-lg font-black text-indigo-600 mt-0.5">Rp {{ number_format($totalWdSuccess, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- 3. INTERFACES FILTER KONSOLIDASI --}}
    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
        <form method="GET" action="{{ route('admin.laporan.global') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-700 uppercase tracking-wider ml-1">Posko Wilayah</label>
                <select name="drop_off_point_id" class="w-full px-4 py-2.5 bg-slate-50 border border-gray-200 rounded-xl font-semibold text-xs text-slate-700 outline-none focus:border-cyan-500 focus:bg-white transition-all">
                    <option value="">-- Semua Lokasi Posko --</option>
                    @foreach($dropOffPoints as $posko)
                        <option value="{{ $posko->id }}" {{ request('drop_off_point_id') == $posko->id ? 'selected' : '' }}>{{ $posko->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-700 uppercase tracking-wider ml-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-gray-200 rounded-xl font-semibold text-xs text-slate-700 outline-none focus:border-cyan-500 focus:bg-white transition-all">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-700 uppercase tracking-wider ml-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-gray-200 rounded-xl font-semibold text-xs text-slate-700 outline-none focus:border-cyan-500 focus:bg-white transition-all">
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.global') }}" class="flex-1 text-center py-2.5 bg-gray-100 text-gray-500 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all">Reset</a>
                <button type="submit" class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all">Filter Jurnal</button>
            </div>
        </form>
    </div>

    {{-- TABEL 1: LOG MASTER SETORAN SAMPAH NASABAH (ALL OFFICERS) --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-black text-slate-800 text-xs uppercase tracking-wide">1. Log Jurnal Master Penimbangan Sampah</h3>
            <span class="px-3 py-1 bg-cyan-100 text-cyan-800 text-[10px] font-black rounded-full uppercase">Sektor Operasional</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-white text-[10px] font-black uppercase tracking-wider text-slate-400 border-b border-gray-100">
                    <tr>
                        <th class="p-4 pl-6">ID Transaksi</th>
                        <th class="p-4">Tanggal / Jam</th>
                        <th class="p-4">Nama Nasabah</th>
                        <th class="p-4">Petugas Lapangan</th>
                        <th class="p-4">Lokasi Drop-Off</th>
                        <th class="p-4">Massa Terhitung</th>
                        <th class="p-4 text-emerald-600">Alokasi Kas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600 text-xs">
                    @forelse($depositReports as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 font-black text-slate-800 pl-6">#TRX-{{ $item->id }}</td>
                            <td class="p-4 text-gray-400">{{ \Carbon\Carbon::parse($item->deposit_date)->format('d M Y, H:i') }}</td>
                            <td class="p-4 text-slate-700 font-bold">{{ $item->user->name ?? 'Masyarakat Umum' }}</td>
                            <td class="p-4 text-slate-500"><span class="px-2 py-0.5 bg-slate-100 rounded text-[11px] font-bold">{{ $item->officer->name ?? 'System' }}</span></td>
                            <td class="p-4 text-slate-400">{{ $item->dropOffPoint->name ?? '-' }}</td>
                            <td class="p-4 font-black text-slate-800">{{ number_format($item->total_weight ?? 0, 2, ',', '.') }} Kg</td>
                            <td class="p-4 text-emerald-600 font-black">Rp {{ number_format($item->total_price ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="p-8 text-center text-gray-400">Tidak ada penimbangan terekam.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($depositReports->hasPages()) <div class="p-3 border-t border-gray-50 bg-gray-50/30">{{ $depositReports->links() }}</div> @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- TABEL 2: ARUS FINANSIAL JURNAL PENARIKAN (WITHDRAWALS) --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-xs uppercase tracking-wide">2. Arus Audit Pencairan Dana (Withdrawal)</h3>
                <span class="px-3 py-1 bg-amber-100 text-amber-800 text-[10px] font-black rounded-full uppercase">Sektor Keuangan</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-white text-[10px] font-black uppercase tracking-wider text-slate-400 border-b border-gray-100">
                        <tr>
                            <th class="p-4 pl-6">ID WD</th>
                            <th class="p-4">Warga</th>
                            <th class="p-4">Detail Bank / Dompet</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right pr-6">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 font-semibold text-slate-600 text-xs">
                        @forelse($withdrawalLogs as $log)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 font-black text-slate-800 pl-6">#WD-{{ $log->id }}</td>
                                <td class="p-4 font-bold text-slate-700">{{ $log->user->name ?? 'N/A' }}</td>
                                <td class="p-4 text-[11px] text-slate-500">
                                    <span class="font-bold uppercase text-slate-700">{{ str_replace('_', ' ', $log->method) }}</span>
                                    <div>{{ $log->account_name }} ({{ $log->account_number }})</div>
                                </td>
                                <td class="p-4 text-center">
                                    @if($log->status == 'pending')
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded-full font-bold text-[10px]">Review</span>
                                    @elseif($log->status == 'approved')
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-full font-bold text-[10px]">Cair</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-rose-50 text-rose-600 rounded-full font-bold text-[10px]">Tolak</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right font-black text-slate-800 pr-6">Rp {{ number_format($log->amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-6 text-center text-gray-400">Belum ada mutasi penarikan dana.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($withdrawalLogs->hasPages()) <div class="p-3 border-t border-gray-50 bg-gray-50/30">{{ $withdrawalLogs->links() }}</div> @endif
        </div>

        {{-- TABEL 3: ANTRIAN SESI MANIFES JADWAL OPERASIONAL --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-xs uppercase tracking-wide">3. Kalender Sesi Operasional & Distribusi</h3>
                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-[10px] font-black rounded-full uppercase">Sektor Logistik</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-white text-[10px] font-black uppercase tracking-wider text-slate-400 border-b border-gray-100">
                        <tr>
                            <th class="p-4 pl-6">ID Jadwal</th>
                            <th class="p-4">Tanggal Sesi</th>
                            <th class="p-4">Lokasi Drop-Off Point</th>
                            <th class="p-4 text-center">Beban Trx</th>
                            <th class="p-4 text-center pr-6">Status Sesi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 font-semibold text-slate-600 text-xs">
                        @forelse($schedules as $sch)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 font-black text-slate-800 pl-6">#SCH-{{ $sch->id }}</td>
                                <td class="p-4 text-slate-700 font-bold">📅 {{ \Carbon\Carbon::parse($sch->start_date)->format('d M Y') }}</td>
                                <td class="p-4 text-slate-500">{{ $sch->dropOffPoint->name ?? 'Pusat Lapangan' }}</td>
                                <td class="p-4 text-center">
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded font-bold text-[11px]">{{ $sch->total_trx }} Nota</span>
                                </td>
                                <td class="p-4 text-center pr-6">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-full font-bold text-[10px] uppercase">{{ $sch->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-6 text-center text-gray-400">Belum ada rancangan jadwal dibuat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($schedules->hasPages()) <div class="p-3 border-t border-gray-50 bg-gray-50/30">{{ $schedules->links() }}</div> @endif
        </div>
    </div>
</div>
@endsection