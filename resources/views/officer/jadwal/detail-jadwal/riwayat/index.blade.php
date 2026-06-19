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
                        <th class="p-4">Nasabah</th>
                        <th class="p-4">Komoditas</th>
                        <th class="p-4">Kuantitas Berat</th>
                        <th class="p-4">Akumulasi Harga</th>
                        <th class="p-4 pr-6">Waktu Input</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    @forelse($depositDetails as $detail)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 font-black text-slate-800 pl-6">
                                #DTL-{{ $detail->id }}
                            </td>
                            <td class="p-4">
                                <span class="block font-black text-slate-700">
                                    {{ $detail->wasteDeposit->user->name ?? 'Masyarakat/Umum' }}
                                </span>
                                <span class="text-[10px] font-mono text-slate-400">
                                    #DEP-{{ $detail->waste_deposit_id }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-slate-700">
                                {{ $detail->wastePrice->wasteCategory->name ?? 'Kategori Dihapus' }}
                            </td>
                            <td class="p-4 font-bold text-slate-700">
                                {{ number_format($detail->weight_kg, 2, ',', '.') }} Kg
                            </td>
                            <td class="p-4 text-emerald-600 font-black">
                                Rp {{ number_format($detail->total_price, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-gray-400 text-xs pr-6">
                                {{ $detail->created_at->translatedFormat('d F Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 font-medium">
                                Belum ada riwayat timbangan setoran yang tercatat untuk jadwal operasional ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
