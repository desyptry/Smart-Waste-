@extends('officer.layout.app')

@section('content')
<div class="space-y-6">
    {{-- Atas: Navigasi Kembali --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('officer.laporan.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs uppercase tracking-wider rounded-xl transition-all flex items-center gap-2">
            ⬅ Kembali ke Monitoring Utama
        </a>
        <span class="px-4 py-1.5 bg-slate-800 text-white font-black text-xs uppercase tracking-widest rounded-full">
            Arsip Transaksi Valid
        </span>
    </div>

    {{-- Layout Grid Belah Dua --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Sisi Kiri: Profil Nota & Tombol Cetak Dokumen Tunggal (1 Kolom) --}}
        <div class="space-y-6 lg:col-span-1">
            <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl space-y-5">
                <div class="border-b border-gray-50 pb-3">
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nomor Nota Transaksi</h2>
                    <p class="text-2xl font-black text-slate-800 mt-0.5">#TRX-{{ $deposit->id }}</p>
                </div>
                
                <div class="text-xs space-y-3 font-semibold text-slate-600">
                    <p>👤 <span class="text-gray-400">Nasabah:</span> <strong class="text-slate-800">{{ $deposit->user->name ?? 'Masyarakat Umum' }}</strong></p>
                    <p>📍 <span class="text-gray-400">Posko Lapangan:</span> {{ $deposit->dropOffPoint->name ?? '-' }}</p>
                    <p>📅 <span class="text-gray-400">Waktu Setor:</span> {{ \Carbon\Carbon::parse($deposit->deposit_date)->translatedFormat('d F Y, H:i') }} Wita</p>
                    <p>👮 <span class="text-gray-400">Petugas Lapangan:</span> {{ $deposit->officer->name ?? '-' }}</p>
                </div>
                
                <hr class="border-gray-50">
                
                {{-- TOMBOL UTAMA: Export File Excel Nota Tunggal --}}
                <a href="{{ route('officer.laporan.exportSingle', $deposit->id) }}" class="w-full text-center flex items-center justify-center gap-2 px-4 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-emerald-900/10 transform hover:-translate-y-0.5">
                    📥 Cetak Struk Nota (.XLS)
                </a>
            </div>
        </div>

        {{-- Sisi Kanan: Tabel Rincian Komoditas Sampah (2 Kolom) --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-xl overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Rincian Item Timbangan Nasabah</h3>
                    <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-lg text-xs font-black">
                        {{ $deposit->depositDetails->count() }} Komoditas
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-white text-[10px] font-black uppercase tracking-wider text-slate-400 border-b border-gray-100">
                            <tr>
                                <th class="p-4 pl-6">ID Kategori</th>
                                <th class="p-4">Jenis Sampah</th>
                                <th class="p-4 text-center">Massa Berat</th>
                                <th class="p-4 text-right pr-6">Subtotal Rupiah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                            @php $grandWeight = 0; $grandPrice = 0; @endphp
                            @forelse($deposit->depositDetails as $detail)
                                @php 
                                    $grandWeight += $detail->weight_kg; 
                                    $grandPrice += $detail->total_price; 
                                @endphp
                                <tr class="hover:bg-slate-50/40 transition-colors">
                                    <td class="p-4 text-xs font-mono text-gray-400 pl-6">#CAT-{{ $detail->waste_price_id }}</td>
                                    <td class="p-4 font-black text-slate-800">{{ $detail->wastePrice->wasteCategory->name ?? '-' }}</td>
                                    <td class="p-4 text-center text-slate-700 font-bold">{{ number_format($detail->weight_kg, 2, ',', '.') }} Kg</td>
                                    <td class="p-4 text-right text-emerald-600 font-black pr-6">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-gray-400 font-medium">Nota ini tidak memiliki item timbangan terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        {{-- Baris Footer Akumulasi Angka --}}
                        <tfoot class="bg-[#F4F9FC]/70 font-black text-slate-800 border-t border-gray-100">
                            <tr>
                                <td colspan="2" class="p-4 pl-6 uppercase text-xs tracking-wider text-slate-400">Total Keseluruhan</td>
                                <td class="p-4 text-center text-base text-[#69C3C1]">{{ number_format($grandWeight, 2, ',', '.') }} Kg</td>
                                <td class="p-4 text-right text-base text-emerald-600 pr-6">Rp {{ number_format($grandPrice, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection