@extends('officer.layout.app')

@section('content')
    {{-- Include Navigasi Atas / Tab Menu --}}
    @include('officer.jadwal.detail-jadwal.sidebar')

    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 md:p-8 space-y-8">
        <div>
            <h2 class="text-lg font-black text-slate-800 uppercase tracking-wider">Atur Nilai Tukar / Harga Sampah</h2>
            <p class="text-xs font-semibold text-gray-400 mt-0.5">Tentukan nominal Rupiah per Kilogram berdasarkan kategori sampah untuk jadwal ini</p>
        </div>
        
        {{-- Notifikasi Flash --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl font-semibold text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Add / Update Price --}}
        <form id="price-form" action="{{ route('officer.jadwal.detail.harga.sync', $schedule->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-[#F4F9FC] p-6 rounded-2xl border border-gray-100">
            @csrf
            
            <div class="space-y-1.5">
                <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Kategori Sampah</label>
                <select name="waste_category_id" required class="w-full px-5 py-3.5 bg-white rounded-xl font-bold text-slate-700 border-2 border-transparent outline-none focus:border-[#69C3C1]">
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Harga Batasan (Rp / Kg)</label>
                <div class="relative">
                    <input type="number" name="price" required min="0" placeholder="Contoh: 3500" class="w-full px-5 py-3.5 bg-white rounded-xl font-bold text-slate-700 border-2 border-transparent outline-none focus:border-[#69C3C1]">
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-[#69C3C1] hover:bg-[#58A8A6] text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md transition-all active:scale-95">
                Terapkan Harga
            </button>
        </form>

        {{-- Daftar Harga yang Berlaku untuk Sesi Ini --}}
        <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
            <table class="w-full text-sm text-left bg-white">
                <thead class="bg-slate-50 text-[10px] font-black uppercase tracking-wider text-slate-700 border-b border-gray-100">
                    <tr>
                        <th class="p-4 pl-6">Kategori Sampah</th>
                        <th class="p-4">Harga Nilai Tukar</th>
                        <th class="p-4 text-center pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    @forelse($activePrices as $activePrice)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 font-black text-slate-800 pl-6">
                                {{ $activePrice->wasteCategory->name }}
                            </td>
                            <td class="p-4 text-[#69C3C1] font-black">
                                Rp {{ number_format($activePrice->price, 0, ',', '.') }} / Kg
                            </td>
                            <td class="p-4 text-center pr-6">
                                {{-- Form Delete Harga Tertentu --}}
                                <form action="{{ route('officer.jadwal.detail.harga.delete', [$schedule->id, $activePrice->id]) }}" method="POST" onsubmit="return confirm('Hapus pengaturan harga untuk kategori ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg font-bold text-xs transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-8 text-center text-gray-400 font-medium">
                                Belum ada batas harga yang ditentukan untuk jadwal operasional ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Script JavaScript / Alpine / jQuery --}}
    <script type="module">
        $(document).ready(function() {
            $('#price-form').on('submit', function() {
                const $btn = $(this).find('button[type="submit"]');
                $btn.prop('disabled', true).addClass('opacity-70').text('Memproses...');
            });
        });
    </script>
@endsection
