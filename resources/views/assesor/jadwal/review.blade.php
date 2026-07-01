@extends('assesor.layout.app')

@section('content')
<div class="space-y-6">
    {{-- Navigasi Kembali --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('assesor.jadwal') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs uppercase tracking-wider rounded-xl transition-all flex items-center gap-2">
            ⬅ Kembali ke Antrean
        </a>
        <span class="px-3 py-1 bg-amber-100 text-amber-700 font-black text-xs uppercase rounded-full">
            Status: {{ $schedule->status }}
        </span>
    </div>

    {{-- Detail Informasi Blok Jadwal --}}
    <div class="bg-[#2D333D] text-white p-6 rounded-2xl shadow-xl flex flex-wrap gap-6 items-center justify-between">
        <div class="space-y-1">
            <h1 class="text-lg font-bold flex items-center gap-2">
                <x-mdi-map-marker class="w-5 h-5 text-[#69C3C1]"/>
                {{ $schedule->dropOffPoint->name ?? '-' }}
            </h1>
            <p class="text-sm text-gray-300 flex items-center gap-2">
                <x-mdi-calendar class="w-4 h-4 text-[#69C3C1]"/>
                {{ $schedule->start_date->translatedFormat('l, d F Y') }}
                <x-mdi-clock-outline class="w-4 h-4 text-[#69C3C1] ml-2"/>
                {{ $schedule->start_date->format('H.i') }} - {{ $schedule->finish_date->format('H.i') }} Wita
            </p>
        </div>
        <div class="text-right text-xs text-gray-400 font-medium">
            Diajukan oleh Officer Lapangan
        </div>
    </div>

    {{-- Tabel Komparasi Harga --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b font-bold text-slate-800 text-sm">
            Daftar Komoditas & Analisis Pengajuan Harga Sampah
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-white text-[10px] font-black uppercase tracking-wider text-slate-400 border-b">
                    <tr>
                        <th class="p-4 pl-6">Kategori Sampah</th>
                        <th class="p-4 text-center">Harga Standard Sistem</th>

                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                    @forelse($schedule->schedulePrices as $item)
                        @php
                            $masterPrice = $item->price ?? 0;
                        @endphp
                        <tr class="hover:bg-slate-50/50">
                            <td class="p-4 pl-6 font-bold text-slate-800">
                                {{ $item->wasteCategory->name ?? 'Tanpa Nama' }}
                            </td>
                            <td class="p-4 text-center">
                                Rp {{ number_format($masterPrice, 0, ',', '.') }} /Kg
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-400">Officer belum memasukkan daftar komoditas harga untuk jadwal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

{{-- Panel Aksi Keputusan Otoritas Assessor --}}
    @if($schedule->status === 'not-verified')
        <div class="bg-slate-50 p-6 rounded-2xl border border-dashed flex flex-col justify-between gap-4">
            <div class="text-xs text-slate-500 w-full">
                <strong>💡 Catatan Penilai:</strong> Memverifikasi jadwal ini akan mengunci skema harga di atas dan mengaktifkan gerbang setoran (*Waste Deposit*) bagi nasabah pada waktu yang ditentukan.
            </div>
            
            <div class="flex flex-col w-full gap-4">
                {{-- Form Utama Peninjauan --}}
                <form action="{{ route('assesor.jadwal.verify', $schedule->id) }}" method="POST" id="verify-form" class="w-full space-y-4">
                    @csrf
                    @method("POST")
                    {{-- Blok Input Alasan Penolakan (Tersembunyi secara default) --}}
                    <div id="declined-box" class="hidden space-y-2 bg-red-50 p-4 rounded-xl border border-red-200 transition-all">
                        <label class="text-xs font-bold text-red-800 uppercase tracking-wider block">Alasan Penolakan Jadwal / Harga:</label>
                        <textarea name="declined_reason" id="declined_reason" rows="3" class="w-full p-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-red-500" placeholder="Contoh: Harga kertas karton yang diajukan terlalu tinggi dari batas deviasi pasar standar..."></textarea>
                        @error('declined_reason')
                            <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Baris Tombol Trigger Utama --}}
                    <div class="flex justify-end gap-3">
                        {{-- Tombol Tolak Pertama (Untuk memunculkan kolom alasan) --}}
                        <button type="button" id="btn-trigger-reject" class="px-5 py-3 bg-red-100 hover:bg-red-200 text-red-700 font-bold text-xs uppercase tracking-wider rounded-xl transition-all">
                            Tolak Pengajuan
                        </button>

                        {{-- Tombol Tolak Konfirmasi Akhir (Tersembunyi secara default) --}}
                        <button type="submit" name="action" value="reject" id="btn-submit-reject" class="hidden px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-md">
                            Kirim & Tolak Jadwal ❌
                        </button>

                        {{-- Tombol Setujui --}}
                        <button type="submit" name="action" value="approve" id="btn-submit-approve" class="px-6 py-3 bg-[#69C3C1] hover:bg-[#57A3A1] text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-md">
                            ✓ Verifikasi & Aktifkan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

{{-- JAVASCRIPT INTERAKTIF --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnTriggerReject = document.getElementById('btn-trigger-reject');
    const btnSubmitReject = document.getElementById('btn-submit-reject');
    const btnSubmitApprove = document.getElementById('btn-submit-approve');
    const declinedBox = document.getElementById('declined-box');
    const declinedInput = document.getElementById('declined_reason');

    // Ketika Tombol Tolak Pertama Kali Diklik
    btnTriggerReject.addEventListener('click', function() {
        // Tampilkan kotak alasan penolakan dan tombol submit reject khusus
        declinedBox.classList.remove('hidden');
        btnSubmitReject.classList.remove('hidden');
        
        // Sembunyikan tombol approve dan tombol trigger awal agar tidak membingungkan
        btnSubmitApprove.classList.add('hidden');
        this.classList.add('hidden');
        
        // Fokuskan kursor langsung ke textarea alasan
        declinedInput.focus();
    });
});
</script>
@endsection