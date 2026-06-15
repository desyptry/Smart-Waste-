@extends('officer.layout.app')

@section('content')
    {{-- Include Navigasi Atas --}}
    @include('officer.jadwal.detail-jadwal.sidebar')

    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 md:p-8 space-y-6">
        <div>
            <h2 class="text-lg font-black text-slate-800 uppercase tracking-wider">Log Riwayat Hasil Timbangan</h2>
            <p class="text-xs font-semibold text-gray-400 mt-0.5">Daftar rekapan log seluruh muatan setoran masuk pada penugasan ini</p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm">
            <table class="w-full text-sm text-left bg-white">
                <thead class="bg-[#F4F9FC] text-[10px] font-black uppercase tracking-wider text-slate-800 border-b border-gray-100">
                    <tr>
                        <th class="p-4 pl-6">ID Detail</th>
                        <th class="p-4">ID Setoran Utama</th>
                        <th class="p-4">Kuantitas Berat</th>
                        <th class="p-4">Akumulasi Harga</th>
                        <th class="p-4 pr-6">Waktu Input</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 font-black text-slate-800 pl-6">#DTL-9921</td>
                        <td class="p-4 text-slate-500 font-mono">#DEP-5412</td>
                        <td class="p-4 font-bold text-slate-700">12.50 Kg</td>
                        <td class="p-4 text-emerald-600 font-bold">Rp 43.750</td>
                        <td class="p-4 text-gray-400 text-xs pr-6">10 Juni 2026, 14:15</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
