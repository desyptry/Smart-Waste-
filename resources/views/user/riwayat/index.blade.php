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
                <select class="bg-white border border-gray-200 text-sm rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-(--primary)" id="filter-transaksi" onchange="filterTransaksi()">
                    <option value="semua">Semua Transaksi</option>
                    <option value="masuk">Masuk (Setor Sampah)</option>
                    <option value="keluar">Keluar (Pencairan)</option>
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
                    <tbody class="divide-y divide-gray-100" id="tabel-body-transaksi">
                        @forelse($transaksi as $t)
                        <tr class="hover:bg-gray-50 transition-colors group cursor-pointer row-transaksi" data-tipe="{{ $t['tipe'] }}">
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
                                    {{ $t['status'] == 'Berhasil' ? 'bg-green-100 text-green-600' : ($t['status'] == 'Ditolak' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600') }}">
                                    {{ $t['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <p class="font-bold text-sm {{ $t['tipe'] == 'masuk' ? 'text-green-600' : 'text-gray-800' }}">
                                    Rp {{ $t['nominal'] }}
                                </p>
                            </td>
                        </tr>
                        @empty
                        <tr id="empty-row-transaksi">
                            <td colspan="4" class="text-center text-sm text-gray-500 py-6">Belum ada transaksi recorded.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
             <!-- Info Jumlah Transaksi -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <p class="text-xs text-gray-500" id="info-jumlah">Menampilkan {{ count($transaksi) }} transaksi</p>
            </div>
        </div>

    </div>
</div>
<script>
    function filterTransaksi() {
        const value = document.getElementById('filter-transaksi').value;
        const rows = document.querySelectorAll('.row-transaksi');
        let countVisible = 0;
        
        rows.forEach(row => {
            if (value === 'semua' || row.getAttribute('data-tipe') === value) {
                row.style.display = '';
                countVisible++;
            } else {
                row.style.display = 'none';
            }
        });
        
        const emptyRow = document.getElementById('empty-row-transaksi');
        if (countVisible === 0 && rows.length > 0) {
            if (!emptyRow) {
                const tr = document.createElement('tr');
                tr.id = 'empty-row-transaksi';
                tr.innerHTML = '<td colspan="4" class="text-center text-sm text-gray-500 py-6">Tidak ada transaksi yang cocok dengan filter.</td>';
                document.getElementById('tabel-body-transaksi').appendChild(tr);
            } else {
                emptyRow.style.display = '';
                emptyRow.querySelector('td').textContent = 'Tidak ada transaksi yang cocok dengan filter.';
            }
        } else {
            if (emptyRow) {
                if (rows.length === 0) {
                    emptyRow.style.display = '';
                    emptyRow.querySelector('td').textContent = 'Belum ada transaksi recorded.';
                } else {
                    emptyRow.style.display = 'none';
                }
            }
        }
        
        document.getElementById('info-jumlah').textContent = 'Menampilkan ' + countVisible + ' transaksi';
    }
</script>
@endsection