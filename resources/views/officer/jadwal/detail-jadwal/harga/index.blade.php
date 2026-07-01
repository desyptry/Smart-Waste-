@extends('officer.layout.app')

@section('content')
    {{-- Include Navigasi Atas / Tab Menu --}}
    @include('officer.jadwal.detail-jadwal.sidebar')

    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 md:p-8 space-y-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-lg font-black text-slate-800 uppercase tracking-wider">Atur Nilai Tukar / Harga Sampah</h2>
                <p class="text-xs font-semibold text-gray-400 mt-0.5">Tentukan nominal Rupiah per Kilogram berdasarkan kategori sampah untuk jadwal ini</p>
            </div>

            {{-- INDIKATOR STATUS & TOMBOL SELESAI REVISI --}}
            <div class="flex flex-wrap items-center gap-3">
                @if($schedule->status === 'verified')
                    <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-black uppercase tracking-wider border border-emerald-200 flex items-center gap-1.5 shadow-sm">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> ✓ Verified & Locked
                    </span>
                @elseif($schedule->status === 'declined')
                    {{-- TOMBOL SELESAI REVISI MASSAL --}}
                    <form action="{{ route('officer.jadwal.detail.harga.selesai', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin semua nominal harga sudah benar dan siap diajukan ke Assessor?')">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md transition-all active:scale-95 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Selesai Revisi & Kirim
                        </button>
                    </form>

                    @if($schedule->status === 'declined')
                        <span class="px-4 py-2.5 bg-red-50 text-red-700 rounded-xl text-xs font-black uppercase tracking-wider border border-red-200 shadow-sm">
                            ❌ Rejected (Butuh Revisi)
                        </span>
                    @else
                        <span class="px-4 py-2.5 bg-amber-50 text-amber-700 rounded-xl text-xs font-black uppercase tracking-wider border border-amber-200 shadow-sm">
                            ⏳ Menunggu Review
                        </span>
                    @endif
                @endif
            </div>
        </div>
        
        {{-- BANNER REAL-TIME STATUS & CATATAN ASSESSOR --}}
        <div class="mt-2">
            @if($schedule->status === 'verified')
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m0-6v2m0-8H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-5z" />
                    </svg>
                    <div>
                        <strong class="uppercase block mb-0.5">Gerbang Pengaturan Harga Terkunci!</strong>
                        Harga berjalan telah disetujui oleh Assessor. Fitur perubahan dan penghapusan dinonaktifkan untuk menjaga validitas kalkulasi setoran nasabah.
                    </div>
                </div>
            @elseif($schedule->status === 'declined')
                <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl text-xs space-y-2 shadow-sm">
                    <div class="font-bold flex items-center gap-2 uppercase tracking-wide">
                        <span>❌</span> Ajuan Nilai Tukar Ditolak Assessor
                    </div>
                    @if($schedule->declined_reason)
                        <p class="bg-white/90 p-3 rounded-xl text-red-700 font-semibold border border-red-100/70">
                            <strong>Alasan Penolakan:</strong> "{{ $schedule->declined_reason }}"
                        </p>
                    @endif
                    <p class="text-[11px] text-slate-700 font-medium">💡 *Anda dapat mengubah/mengedit beberapa komoditas sekaligus di bawah ini tanpa mengganggu Assessor. Jika semua sudah selesai disesuaikan, klik tombol <span class="text-emerald-600 font-bold">"Selesai Revisi & Kirim"</span> di kanan atas.</p>
                </div>
            @else
                <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl text-xs font-medium space-y-1 shadow-sm">
                    <p class="font-bold flex items-center gap-2">
                        <span class="w-2 h-2 bg-amber-500 rounded-full animate-ping"></span>
                        ⏳ Mode Kelola Harga Berjalan
                    </p>
                    <p class="text-gray-500 text-[11px]">Silakan masukkan atau edit daftar harga yang diinginkan. Setelah selesai, pastikan menekan tombol kirim di atas agar masuk kembali ke sistem verifikasi Assessor.</p>
                </div>
            @endif
        </div>

        {{-- Notifikasi Flash Laravel Error/Sukses --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl font-semibold text-sm flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl font-semibold text-sm shadow-sm">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        {{-- FORM ADD / UPDATE PRICE --}}
        @if($schedule->status !== 'verified')
            <div class="space-y-2">
                <span id="form-mode-badge" class="hidden inline-block px-3 py-1 bg-amber-500 text-white text-[10px] font-black rounded-lg uppercase tracking-wider">
                    Mode Edit Harga
                </span>
                <form id="price-form" action="{{ route('officer.jadwal.detail.harga.sync', $schedule->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-[#F4F9FC] p-6 rounded-2xl border border-gray-100 shadow-inner">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Kategori Sampah</label>
                        <select name="waste_category_id" id="form-category-id" required class="w-full px-5 py-3.5 bg-white rounded-xl font-bold text-slate-700 border-2 border-transparent outline-none focus:border-[#69C3C1] transition-all">
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Harga Batasan (Rp / Kg)</label>
                        <div class="relative">
                            <input type="number" name="price" id="form-price" required min="0" placeholder="Contoh: 3500" class="w-full px-5 py-3.5 bg-white rounded-xl font-bold text-slate-700 border-2 border-transparent outline-none focus:border-[#69C3C1] transition-all">
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" id="submit-btn" class="w-full py-4 bg-[#69C3C1] hover:bg-[#58A8A6] text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md transition-all active:scale-95">
                            Terapkan Harga
                        </button>
                        <button type="button" id="cancel-edit-btn" class="hidden px-4 py-4 bg-gray-200 hover:bg-gray-300 text-gray-600 font-black text-xs uppercase tracking-wider rounded-xl transition-all">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        @endif

        {{-- Daftar Harga yang Berlaku untuk Sesi Ini --}}
        <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
            <table class="w-full text-sm text-left bg-white">
                <thead class="bg-slate-50 text-[10px] font-black uppercase tracking-wider text-slate-700 border-b border-gray-100">
                    <tr>
                        <th class="p-4 pl-6">Kategori Sampah</th>
                        <th class="p-4">Harga Nilai Tukar</th>
                        @if($schedule->status !== 'verified')
                            <th class="p-4 text-center pr-6">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    @forelse($activePrices as $activePrice)
                        <tr class="hover:bg-slate-50/50 transition-colors price-row" data-category="{{ $activePrice->waste_category_id }}" data-rawprice="{{ $activePrice->price }}">
                            <td class="p-4 font-black text-slate-800 pl-6 category-name">
                                {{ $activePrice->wasteCategory->name }}
                            </td>
                            <td class="p-4 text-[#69C3C1] font-black">
                                Rp {{ number_format($activePrice->price, 0, ',', '.') }} / Kg
                            </td>
                            @if($schedule->status !== 'verified')
                                <td class="p-4 text-center pr-6 flex items-center justify-center gap-2">
                                    <button type="button" class="edit-btn bg-amber-400 hover:bg-amber-500 text-slate-900 px-3 py-1.5 rounded-lg font-bold text-xs transition-all shadow-sm">
                                        Edit
                                    </button>

                                    <form action="{{ route('officer.jadwal.detail.harga.delete', [$schedule->id, $activePrice->id]) }}" method="POST" onsubmit="return confirm('Hapus pengaturan harga untuk kategori ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg font-bold text-xs transition-all shadow-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $schedule->status !== 'verified' ? '3' : '2' }}" class="p-8 text-center text-gray-400 font-medium text-xs">
                                Belum ada batas harga yang ditentukan untuk jadwal operasional ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Script Loader & Interaksi Edit JavaScript --}}
    @if($schedule->status !== 'verified')
    <script type="module">
        $(document).ready(function() {
            $('#price-form').on('submit', function() {
                const $btn = $('#submit-btn');
                $btn.prop('disabled', true).addClass('opacity-70').text('Memproses...');
            });

            $('.edit-btn').on('click', function() {
                const row = $(this).closest('.price-row');
                const categoryId = row.data('category');
                const price = row.data('rawprice');

                $('#form-category-id').val(categoryId).trigger('change');
                $('#form-price').val(price).focus();

                $('#form-mode-badge').removeClass('hidden');
                $('#submit-btn').removeClass('bg-[#69C3C1] hover:bg-[#58A8A6]').addClass('bg-amber-500 hover:bg-amber-600').text('Update Harga');
                $('#cancel-edit-btn').removeClass('hidden');
                
                $('html, body').animate({
                    scrollTop: $("#price-form").offset().top - 120
                }, 400);
            });

            $('#cancel-edit-btn').on('click', function() {
                resetFormMode();
            });

            function resetFormMode() {
                $('#price-form')[0].reset();
                $('#form-category-id').val('').trigger('change');
                $('#form-mode-badge').addClass('hidden');
                $('#submit-btn').removeClass('bg-amber-500 hover:bg-amber-600').addClass('bg-[#69C3C1] hover:bg-[#58A8A6]').text('Terapkan Harga');
                $('#cancel-edit-btn').addClass('hidden');
            }
        });
    </script>
    @endif
@endsection