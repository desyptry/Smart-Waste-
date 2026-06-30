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
                        <th class="p-4 pl-6">No</th>
                        <th class="p-4">Nasabah</th>
                        <th class="p-4">Komoditas</th>
                        <th class="p-4">Kuantitas Berat</th>
                        <th class="p-4">Akumulasi Harga</th>
                        <th class="p-4">Waktu Input</th>
                        <th class="p-4 text-center pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    {{-- Perbaikan bug: Menggunakan loop iteration Laravel ($loop->iteration) jika variabel $index tidak didefinisikan dari controller --}}
                    @forelse($depositDetails as $detail)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 font-black text-slate-800 pl-6">
                                #{{ $loop->iteration }}
                            </td>
                            <td class="p-4 font-black text-slate-700">
                                        {{ $detail->wasteDeposit->user->name ?? 'Masyarakat/Umum' }}
                            
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
                            <td class="p-4 text-gray-400 text-xs">
                                {{ $detail->created_at->translatedFormat('d F Y, H:i') }} Wita
                            </td>
                            <td class="p-4 text-center pr-6">
                                {{-- BUTTON TRIGGER DETAIL MODAL --}}
                                <button type="button" 
                                    class="open-detail-btn px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs uppercase tracking-wider rounded-lg transition-all"
                                    data-trx="TRX-{{ $detail->waste_deposit_id }}"
                                    data-nasabah="{{ $detail->wasteDeposit->user->name ?? 'Masyarakat Umum' }}"
                                    data-posko="{{ $detail->wasteDeposit->dropOffPoint->name ?? '-' }}"
                                    data-waktu="{{ $detail->created_at->translatedFormat('d F Y, H:i') }} Wita"
                                    data-petugas="{{ $detail->wasteDeposit->officer->name ?? '-' }}"
                                    data-kategori="#CAT-{{ $detail->waste_price_id }}"
                                    data-jenis="{{ $detail->wastePrice->wasteCategory->name ?? '-' }}"
                                    data-berat="{{ number_format($detail->weight_kg, 2, ',', '.') }} Kg"
                                    data-subtotal="Rp {{ number_format($detail->total_price, 0, ',', '.') }}"
                                    data-export-url="{{ route('officer.laporan.exportSingle', $detail->waste_deposit_id) }}">
                                    🔍 Detail Nota
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400 font-medium">
                                Belum ada riwayat timbangan setoran yang tercatat untuk jadwal operasional ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ==================== MODAL OVERLAY DETAIL NOTA (HIDDEN BY DEFAULT) ==================== --}}
    <div id="detail-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 transition-all">
        <div class="bg-[#F8FAFC] w-full max-w-4xl rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 dynamic-modal-content space-y-6 p-6 md:p-8">
            
            {{-- Bagian Atas: Navigasi & Judul --}}
            <div class="flex items-center justify-between">
                <button type="button" id="close-modal-btn" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-xs uppercase tracking-wider rounded-xl transition-all">
                    ❌ Tutup Detail
                </button>
                <span class="px-4 py-1.5 bg-slate-800 text-white font-black text-xs uppercase tracking-widest rounded-full">
                    Arsip Transaksi Valid
                </span>
            </div>

            {{-- Layout Grid Belah Dua Berdasarkan UI Referensi Anda --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Sisi Kiri: Profil Nota & Tombol Cetak Dokumen Tunggal (1 Kolom) --}}
                <div class="space-y-6 lg:col-span-1">
                    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl space-y-5">
                        <div class="border-b border-gray-50 pb-3">
                            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nomor Nota Transaksi</h2>
                            <p id="modal-trx-id" class="text-xl font-black text-slate-800 mt-0.5">#TRX-0000</p>
                        </div>
                        
                        <div class="text-xs space-y-3 font-semibold text-slate-600">
                            <p>👤 <span class="text-gray-400">Nasabah:</span> <strong id="modal-nasabah" class="text-slate-800">-</strong></p>
                            <p>📍 <span class="text-gray-400">Posko Lapangan:</span> <span id="modal-posko">-</span></p>
                            <p>📅 <span class="text-gray-400">Waktu Setor:</span> <span id="modal-waktu">-</span></p>
                            <p>👮 <span class="text-gray-400">Petugas Lapangan:</span> <span id="modal-petugas">-</span></p>
                        </div>
                        
                        <hr class="border-gray-50">
                        
                        {{-- Export Link Struk --}}
                        <a id="modal-export-link" href="#" class="w-full text-center flex items-center justify-center gap-2 px-4 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-emerald-900/10">
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
                                1 Komoditas
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
                                    <tr class="hover:bg-slate-50/40 transition-colors">
                                        <td id="modal-item-cat" class="p-4 text-xs font-mono text-gray-400 pl-6">#CAT-0</td>
                                        <td id="modal-item-jenis" class="p-4 font-black text-slate-800">-</td>
                                        <td id="modal-item-berat" class="p-4 text-center text-slate-700 font-bold">0 Kg</td>
                                        <td id="modal-item-subtotal" class="p-4 text-right text-emerald-600 font-black pr-6">Rp 0</td>
                                    </tr>
                                </tbody>
                                {{-- Baris Footer Akumulasi Angka --}}
                                <tfoot class="bg-[#F4F9FC]/70 font-black text-slate-800 border-t border-gray-100">
                                    <tr>
                                        <td colspan="2" class="p-4 pl-6 uppercase text-xs tracking-wider text-slate-400">Total Keseluruhan</td>
                                        <td id="modal-foot-berat" class="p-4 text-center text-base text-[#69C3C1]">0 Kg</td>
                                        <td id="modal-foot-subtotal" class="p-4 text-right text-base text-emerald-600 pr-6">Rp 0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ==================== SCRIPT INTERAKSI MODAL MODUL ==================== --}}
    <script type="module">
        $(document).ready(function() {
            const $modal = $('#detail-modal');
            const $modalContent = $('.dynamic-modal-content');

            // Jalankan Event Listener saat tombol "Detail Nota" di-klik
            $('.open-detail-btn').on('click', function() {
                // Ambil seluruh data parameter dari atribut baris tabel
                const trx = $(this).data('trx');
                const nasabah = $(this).data('nasabah');
                const posko = $(this).data('posko');
                const waktu = $(this).data('waktu');
                const petugas = $(this).data('petugas');
                const kategori = $(this).data('kategori');
                const jenis = $(this).data('jenis');
                const berat = $(this).data('berat');
                const subtotal = $(this).data('subtotal');
                const exportUrl = $(this).data('export-url');

                // Mapping / Tulis ulang isi kontainer modal secara dinamis
                $('#modal-trx-id').text('#' + trx);
                $('#modal-nasabah').text(nasabah);
                $('#modal-posko').text(posko);
                $('#modal-waktu').text(waktu);
                $('#modal-petugas').text(petugas);
                
                $('#modal-item-cat').text(kategori);
                $('#modal-item-jenis').text(jenis);
                $('#modal-item-berat').text(berat);
                $('#modal-item-subtotal').text(subtotal);

                $('#modal-foot-berat').text(berat);
                $('#modal-foot-subtotal').text(subtotal);
                
                // Ubah endpoint cetak struk ekspor excel secara dinamis
                $('#modal-export-link').attr('href', exportUrl);

                // Tampilkan Modal dengan animasi smooth transisi
                $modal.removeClass('hidden');
                setTimeout(() => {
                    $modalContent.removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
                }, 50);
            });

            // Aksi Tutup Modal
            $('#close-modal-btn, #detail-modal').on('click', function(e) {
                // Cegah modal menutup jika yang diklik adalah bagian dalam box modal
                if (e.target !== this && e.target.id !== 'close-modal-btn') return;

                $modalContent.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                setTimeout(() => {
                    $modal.addClass('hidden');
                }, 200);
            });
        });
    </script>
@endsection