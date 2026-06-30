@extends('assesor.layout.app')

@section('content')
<div class="space-y-6">

    {{-- 1. HEADER BANNER --}}
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-[#2D333D] text-white p-6 rounded-2xl shadow flex justify-between items-center">
            <div>
                <h1 class="text-xl font-semibold uppercase tracking-wide">Panel Rekapitulasi & Jurnal Audit</h1>
                <p class="text-gray-300 text-sm mt-1">
                    Pemantauan terpadu arus pencairan dana (*Withdrawal*) serta manifes antrean jadwal *Drop-off* warga yang telah disetujui (*Approved*).
                </p>
            </div>
            <div class="p-3 bg-slate-700/50 rounded-xl text-[#69C3C1]">
                <x-mdi-file-chart-outline class="w-7 h-7"/>
            </div>
        </div>
    </div>

    {{-- 2. KARTU STATISTIK VERIFIKASI FINANSIAL --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between border-l-4 border-amber-500">
            <div>
                <p class="text-gray-500 text-sm font-medium">Dana Tertahan (Pending)</p>
                <h2 class="text-2xl font-black text-amber-600 mt-1">Rp {{ number_format($totalPendingDana, 0, ',', '.') }}</h2>
                <p class="text-xs text-gray-400 mt-1">Menunggu peninjauan persetujuan Anda</p>
            </div>
            <div class="p-3 bg-amber-50 rounded-lg text-amber-500">
                <x-mdi-clock-outline class="w-8 h-8"/>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between border-l-4 border-emerald-500">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Dana Cair (Approved)</p>
                <h2 class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($totalDicairkan, 0, ',', '.') }}</h2>
                <p class="text-xs text-gray-400 mt-1">Berhasil lolos verifikasi rekening warga</p>
            </div>
            <div class="p-3 bg-emerald-50 rounded-lg text-emerald-500">
                <x-mdi-cash-check class="w-8 h-8"/>
            </div>
        </div>


    </div>

{{-- 3. PANEL FILTER AUDIT CONTROLS --}}
    <div class="bg-white p-6 rounded-2xl shadow">
        <form method="GET" action="{{ route('assesor.laporan') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm font-semibold text-slate-700 outline-none focus:border-[#69C3C1] focus:bg-white transition-all">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm font-semibold text-slate-700 outline-none focus:border-[#69C3C1] focus:bg-white transition-all">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Metode Pembayaran</label>
                <select name="method" class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm font-semibold text-slate-700 outline-none focus:border-[#69C3C1] focus:bg-white transition-all">
                    <option value="">-- Semua Metode --</option>
                    <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="e_wallet" {{ request('method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                </select>
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Nama Bank / Dompet</label>
                <input type="text" name="account_name" value="{{ request('account_name') }}" placeholder="Contoh: BCA, OVO, Mandiri" class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm font-semibold text-slate-700 outline-none focus:border-[#69C3C1] focus:bg-white transition-all">
            </div>
            <div class="grid grid-cols-3 gap-2">
                <button type="submit" class="p-2.5 bg-[#2D333D] hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all text-center">Filter</button>
                <a href="{{ route('assesor.laporan.export', request()->query()) }}" class="p-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all text-center flex items-center justify-center gap-1">
                    💾 Excel
                </a>
                <a href="{{ route('assesor.laporan') }}" class="p-2.5 bg-gray-100 text-gray-500 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all text-center flex items-center justify-center">Reset</a>
            </div>
        </form>
    </div>

    {{-- TABEL 1: LOG PENARIKAN SALDO (WITHDRAWALS) --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden border border-gray-100">
        <div class="px-6 py-4 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-[#2D333D] text-sm">Jurnal Arus Pencairan Dana Masuk & Status Verifikasi</h3>
            <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-black rounded-full">Keuangan Warga</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-white text-[10px] font-black uppercase tracking-wider text-slate-400 border-b border-gray-100">
                    <tr>
                        <th class="p-4 pl-6">ID Transaksi</th>
                        <th class="p-4">Tanggal Pengajuan</th>
                        <th class="p-4">Nama Warga</th>
                        <th class="p-4">Metode & Detail Tujuan</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right pr-6">Nominal Penarikan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    @forelse($withdrawalLogs as $log)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="p-4 font-black text-slate-800 pl-6">#WD-{{ $log->id }}</td>
                            <td class="p-4 text-xs text-gray-400">{{ $log->created_at->translatedFormat('d M Y, H:i') }} Wita</td>
                            <td class="p-4 text-slate-700 font-bold">{{ $log->user->name ?? 'Warga Tidak Dikenal' }}</td>
                            <td class="p-4 text-xs">
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-[10px] font-bold uppercase">{{ str_replace('_', ' ', $log->method) }}</span>
                                <div class="mt-1 text-slate-500 font-medium">{{ $log->account_name }} ({{ $log->account_number }})</div>
                            </td>
                            <td class="p-4 text-center">
                                @if($log->status == 'pending')
                                    <span class="inline-block px-2.5 py-1 bg-amber-50 text-amber-600 rounded-full text-[11px] font-bold">Menunggu Review</span>
                                @elseif($log->status == 'approved')
                                    <span class="inline-block px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[11px] font-bold">Approved</span>
                                @else
                                    <span class="inline-block px-2.5 py-1 bg-rose-50 text-rose-600 rounded-full text-[11px] font-bold">Ditolak</span>
                                @endif
                            </td>
                            <td class="p-4 text-right font-black text-slate-800 pr-6">Rp {{ number_format($log->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 text-xs font-medium">Belum ada rekaman pencairan dana.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($withdrawalLogs->hasPages())
            <div class="p-3 border-t border-gray-100 bg-gray-50/50">{{ $withdrawalLogs->links() }}</div>
        @endif
    </div>

    {{-- FIX PERBAIKAN TOTAL: TABEL 2 - LAPORAN DROP-OFF SCHEDULE (APPROVED) --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden border border-gray-100">
        <div class="px-6 py-4 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-[#2D333D] text-sm">Manifes Jadwal Drop-Off Sampah Warga Berstatus Valid</h3>
            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-black rounded-full">Drop-Off Schedule</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-white text-[10px] font-black uppercase tracking-wider text-slate-400 border-b border-gray-100">
                    <tr>
                        <th class="p-4 pl-6">ID Jadwal</th>
                        <th class="p-4">Waktu Mulai</th>
                        <th class="p-4">Titik Drop-Off Point</th>
                        <th class="p-4 text-center">Status Validasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    @forelse($scheduleLogs as $sLog)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="p-4 font-black text-slate-800 pl-6">#SCH-{{ $sLog->id }}</td>
                            <td class="p-4 text-xs text-slate-700 font-bold">
                                📅 {{ \Carbon\Carbon::parse($sLog->schedule_date)->translatedFormat('d F Y') }}
                            </td>
                            <td class="p-4 text-xs text-slate-500">{{ $sLog->dropOffPoint->name ?? 'Pusat Lapangan' }}</td>
                            <td class="p-4 text-center">
                                <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-black uppercase tracking-wide">
                                    Approved
                                </span>
                            </td>
  
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 text-xs font-medium">
                                🔎 Tidak ditemukan data Drop-Off Schedule dengan status approved.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($scheduleLogs->hasPages())
            <div class="p-3 border-t border-gray-100 bg-gray-50/50">{{ $scheduleLogs->links() }}</div>
        @endif
    </div>

</div>
@endsection