@extends('user.layout.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div class="container mx-auto p-4 max-w-7xl">
    <div class="wrapper flex flex-col w-full gap-6">

        <!-- Header Riwayat & Filter -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h2>
                <p class="text-sm text-gray-500">Pantau semua aliran saldo dan pencairan danamu di sini.</p>
            </div>
            
            <!-- Filter Sederhana -->
            <div class="flex gap-2">
                <select class="bg-white border border-gray-200 text-sm rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-(--primary)">
                    <option>Semua Transaksi</option>
                    <option>Masuk (Setor Sampah)</option>
                    <option>Keluar (Pencairan)</option>
                </select>
            </div>
        </div>

        <!-- Tabel / List Transaksi -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Transaksi</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Status</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $transaksi = [
                                [
                                    'tipe' => 'masuk',
                                    'judul' => 'Kaleng - 10Kg',
                                    'sub' => 'Balai Br. Ambengan',
                                    'tgl' => '27 Maret 2026',
                                    'status' => 'Berhasil',
                                    'nominal' => '+12.500'
                                ],
                                [
                                    'tipe' => 'keluar',
                                    'judul' => 'Pencairan Saldo',
                                    'sub' => 'Bank Transfer - BCA',
                                    'tgl' => '25 Maret 2026',
                                    'status' => 'Proses',
                                    'nominal' => '-50.000'
                                ],
                                [
                                    'tipe' => 'masuk',
                                    'judul' => 'Kardus 10Kg',
                                    'sub' => 'Lapangan Renon',
                                    'tgl' => '20 Maret 2026',
                                    'status' => 'Berhasil',
                                    'nominal' => '+8.200'
                                ],
                                [
                                    'tipe' => 'keluar',
                                    'judul' => 'Pencairan Saldo',
                                    'sub' => 'E-Wallet - OVO',
                                    'tgl' => '15 Maret 2026',
                                    'status' => 'Berhasil',
                                    'nominal' => '-20.000'
                                ],
                            ];
                        @endphp

                        @foreach($transaksi as $t)
                        <tr class="hover:bg-gray-50 transition-colors group cursor-pointer">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 rounded-2xl {{ $t['tipe'] == 'masuk' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                        @if($t['tipe'] == 'masuk')
                                            <x-mdi-tray-arrow-down class="w-5 h-5"/>
                                        @else
                                            <x-mdi-tray-arrow-up class="w-5 h-5"/>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">{{ $t['judul'] }}</p>
                                        <p class="text-xs text-gray-400">{{ $t['sub'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-500">
                                {{ $t['tgl'] }}
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider 
                                    {{ $t['status'] == 'Berhasil' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                    {{ $t['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <p class="font-bold text-sm {{ $t['tipe'] == 'masuk' ? 'text-green-600' : 'text-gray-800' }}">
                                    Rp {{ $t['nominal'] }}
                                </p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Sederhana -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <p class="text-xs text-gray-500">Menampilkan 4 dari 24 transaksi</p>
                <div class="flex gap-2">
                    <button class="p-2 border border-gray-200 rounded-lg hover:bg-white transition-colors">
                        <x-mdi-chevron-left class="w-4 h-4 text-gray-400"/>
                    </button>
                    <button class="p-2 border border-gray-200 rounded-lg hover:bg-white transition-colors">
                        <x-mdi-chevron-right class="w-4 h-4 text-gray-400"/>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection