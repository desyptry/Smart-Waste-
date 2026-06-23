@extends('assesor.layout.app')

@section('content')
<div class="space-y-6">

    {{-- 1. HEADER BANNER --}}
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-[#2D333D] text-white p-6 rounded-2xl shadow flex justify-between items-center">
            <div>
                <h1 class="text-xl font-semibold uppercase tracking-wide">Audit & Jurnal Monitoring Global</h1>
                <p class="text-gray-300 text-sm mt-1">
                    Panel Rekapitulasi Neraca Massa Sampah, Arus Kas Keluar, dan Evaluasi Transaksi Lapangan (Officer).
                </p>
            </div>
            <div class="p-3 bg-slate-700/50 rounded-xl text-[#69C3C1]">
                <x-mdi-file-chart-outline class="w-7 h-7"/>
            </div>
        </div>
    </div>

    {{-- 2. KARTU STATISTIK SUPERVISI ASSESSOR --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- Total Massa Sampah Masuk Sistem --}}
        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between border-l-4 border-[#69C3C1]">
            <div>
                <p class="text-gray-500 text-sm font-medium">Massa Terakumulasi (Sistem)</p>
                <h2 class="text-2xl font-black text-slate-800 mt-1">{{ number_format($totalMassa, 2, ',', '.') }} Kg</h2>
                <p class="text-xs text-gray-400 mt-1">Total fisik timbangan masuk keseluruhan</p>
            </div>
            <div class="p-3 bg-cyan-50 rounded-lg text-[#69C3C1]">
                <x-mdi-scale-balance class="w-8 h-8"/>
            </div>
        </div>

        {{-- Total Kas Keluar Finansial --}}
        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between border-l-4 border-emerald-500">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Dana Terdistribusi</p>
                <h2 class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($totalPerputaranKas, 0, ',', '.') }}</h2>
                <p class="text-xs text-gray-400 mt-1">Konversi nilai sampah menjadi saldo warga</p>
            </div>
            <div class="p-3 bg-emerald-50 rounded-lg text-emerald-500">
                <x-mdi-cash-multiple class="w-8 h-8"/>
            </div>
        </div>

        {{-- Pengawasan Jumlah Officer di Lapangan --}}
        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between border-l-4 border-purple-500">
            <div>
                <p class="text-gray-500 text-sm font-medium">Officer Lapangan Aktif</p>
                <h2 class="text-2xl font-black text-purple-600 mt-1">{{ $totalOfficerAktif }} Petugas</h2>
                <p class="text-xs text-gray-400 mt-1">SDA penginput data timbangan terdaftar</p>
            </div>
            <div class="p-3 bg-purple-50 rounded-lg text-purple-500">
                <x-mdi-account-hard-hat class="w-8 h-8"/>
            </div>
        </div>
    </div>

    {{-- 3. PANEL FILTER AUDIT CONTROLS --}}
    <div class="bg-white p-6 rounded-2xl shadow">
        <form method="GET" action="{{ route('assesor.laporan') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl font-medium text-sm text-slate-700 outline-none focus:border-[#69C3C1] focus:bg-white transition-all">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl font-medium text-sm text-slate-700 outline-none focus:border-[#69C3C1] focus:bg-white transition-all">
            </div>
            {{-- Tambahan Spesifik Pengawasan Assessor: Filter Berdasarkan Kinerja Officer --}}
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Filter Kerja Officer</label>
                <select name="officer_id" class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl font-medium text-sm text-slate-700 outline-none focus:border-[#69C3C1] focus:bg-white transition-all">
                    <option value="">-- Semua Officer --</option>
                    @foreach($officers as $off)
                        <option value="{{ $off->id }}" {{ request('officer_id') == $off->id ? 'selected' : '' }}>{{ $off->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 p-2.5 bg-[#2D333D] hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all">Filter Jurnal</button>
                <a href="{{ route('assesor.laporan') }}" class="p-2.5 bg-gray-100 text-gray-500 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all text-center flex items-center justify-center">Reset</a>
            </div>
        </form>
    </div>

    {{-- 4. TABEL JURNAL TRANSAKSI GLOBAL --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden border border-gray-100">
        <div class="px-6 py-4 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-[#2D333D] text-sm">Log Aliran Masuk Setoran & Personel Penanggung Jawab</h3>
            <span class="px-3 py-1 bg-[#69C3C1]/10 text-[#69C3C1] text-xs font-black rounded-full">Mode Monitoring Read-Only</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-white text-[10px] font-black uppercase tracking-wider text-slate-400 border-b border-gray-100">
                    <tr>
                        <th class="p-4 pl-6">ID Transaksi</th>
                        <th class="p-4">Waktu Input</th>
                        <th class="p-4">Nasabah (Warga)</th>
                        <th class="p-4">Lokasi Pos Lapangan</th>
                        <th class="p-4 bg-amber-50/40 text-amber-900 font-bold">Officer Penginput</th>
                        <th class="p-4 text-center">Total Muatan</th>
                        <th class="p-4 text-right pr-6">Nilai Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="p-4 font-black text-slate-800 pl-6">#TRX-{{ $log->id }}</td>
                            <td class="p-4 text-xs text-gray-400">{{ \Carbon\Carbon::parse($log->deposit_date)->translatedFormat('d M Y, H:i') }} Wita</td>
                            <td class="p-4 text-slate-700 font-bold">{{ $log->user->name ?? 'Masyarakat Umum' }}</td>
                            <td class="p-4 text-xs text-slate-500">{{ $log->dropOffPoint->name ?? '-' }}</td>
                            {{-- Menampilkan data penanggung jawab (Officer) lapangan --}}
                            <td class="p-4 bg-amber-50/20 font-black text-slate-800">
                                👷 {{ $log->officer->name ?? 'Petugas Terhapus' }}
                            </td>
                            <td class="p-4 text-center text-slate-800 font-bold">{{ number_format($log->total_weight ?? 0, 2, ',', '.') }} Kg</td>
                            <td class="p-4 text-right text-emerald-600 font-black pr-6">Rp {{ number_format($log->total_price ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-gray-400 font-medium text-xs">
                                🔎 Tidak ditemukan rekaman setoran sampah pada filter parameter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Navigasi Paginasi --}}
        @if($logs->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    {{-- 5. RUNNING INFORMATION BANNER --}}
    <div class="bg-[#A8C5B5] p-6 rounded-2xl shadow flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="font-bold text-[#2D333D] text-base">
                Otoritas Pengawasan Mutu & Pencegahan Manipulasi Data
            </h2>
            <p class="text-xs text-gray-700 mt-0.5">
                Gunakan filter kerja Officer di atas secara berkala untuk melakukan audit silang jika ditemukan indikasi deviasi grafik keuangan penarikan kas yang tidak wajar.
            </p>
        </div>
    </div>

</div>
@endsection