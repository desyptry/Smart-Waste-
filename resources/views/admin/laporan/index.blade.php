@extends('admin.layout.app')

@section('title', 'Laporan Transaksi Setoran')

@section('content')

<div class="bg-white rounded shadow">

    {{-- Header --}}
    <div class="bg-(--primary) text-(--text-black) px-4 py-2 font-semibold">
        Laporan Transaksi Setoran Sampah
    </div>

    <div class="p-4">

         {{-- FILTER TANGGAL --}}
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-(--primary) focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Tanggal Selesai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-(--primary) focus:border-transparent">
                </div>
            </div>

        <div class="flex gap-2">
                <button type="submit" class="bg-(--primary) hover:bg-opacity-80 text-(--text-black) px-4 py-2 rounded font-semibold transition">
                    Tampilkan Filter
                </button>
                @if(request('start_date') || request('end_date'))
                    <a href="{{ route('admin.laporan.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded font-semibold transition">
                        Reset Filter
                    </a>
                @endif
            </div>
        </form>

        {{-- TABEL --}}
         <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-(--primary) text-(--text-black)">
                    <tr>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Nasabah</th>
                        <th class="p-3 text-left">Posko</th>
                        <th class="p-3 text-left">Jenis Sampah</th>
                        <th class="p-3 text-right">Berat (Kg)</th>
                        <th class="p-3 text-right">Total Rupiah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $r)
                    <tr class="hover:bg-gray-100 border-b border-gray-150 last:border-0">
                        <td class="p-3 whitespace-nowrap">
                            {{ $r->deposit_date ? $r->deposit_date->format('d-m-Y H:i') : '-' }}
                        </td>
                        <td class="p-3">
                            {{ $r->user->name ?? 'Masyarakat Umum' }}
                        </td>
                        <td class="p-3 text-gray-600">
                            {{ $r->dropOffPoint->name ?? '-' }}
                        </td>
                        <td class="p-3 text-gray-600">
                            {{ $r->depositDetails->map(fn($d) => $d->wastePrice->wasteCategory->name ?? '')->unique()->filter()->implode(', ') ?: '-' }}
                        </td>
                        <td class="p-3 text-right font-mono font-medium">
                            {{ number_format($r->total_weight ?? $r->depositDetails->sum('weight_kg'), 2, ',', '.') }}
                        </td>
                        <td class="p-3 text-right font-mono font-medium text-green-700">
                            Rp {{ number_format($r->total_price ?? $r->depositDetails->sum('total_price'), 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center p-6 text-gray-500">
                            Tidak ditemukan data transaksi setoran untuk periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- BUTTON EXPORT --}}
        <div class="mt-4">
            {{-- <button class="bg-(--primary) hover:bg(--text-black)--primary) text-(--text-black) px-4 py-2">
                Export / Cetak
            </button> --}}
             {{ $reports->links() }}
        </div>

    </div>

</div>

@endsection