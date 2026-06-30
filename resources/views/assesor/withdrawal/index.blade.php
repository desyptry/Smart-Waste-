@extends('assesor.layout.app')

@section('content')

{{-- Notifikasi Info --}}
@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl font-semibold text-sm flex items-center gap-2 shadow-sm">
        <x-mdi-check-circle class="w-5 h-5 text-emerald-500"/>
        {{ session('success') }}
    </div>
@endif

{{-- Header Banner --}}
<div class="grid grid-cols-1 gap-6 mb-6">
    <div class="bg-[#2D333D] text-white p-6 rounded-2xl shadow flex justify-between items-center">
        <div>
            <h1 class="text-xl font-semibold uppercase tracking-wide">Validasi Penarikan Dana (Withdrawal)</h1>
            <p class="text-gray-300 text-sm mt-1">Daftar giliran pencairan saldo nasabah yang didelegasikan otomatis ke akun Anda.</p>
        </div>
        <div class="p-3 bg-slate-700/50 rounded-xl text-emerald-400">
            <x-mdi-cash-marker class="w-7 h-7"/>
        </div>
    </div>
</div>

{{-- Container Utama List --}}
<div class="bg-white p-6 rounded-2xl shadow space-y-6">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <h2 class="font-bold text-[#2D333D]">Antrean Penarikan Saldo Anda</h2>
        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-black rounded-full">{{ $withdrawals->count() }} Menunggu Transfer</span>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse($withdrawals as $wd)
            <div class="border border-gray-100 rounded-2xl p-5 hover:bg-slate-50/50 transition-all flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                
                {{-- Kiri: Detail Pengaju & Nominal --}}
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono px-2 py-0.5 bg-gray-100 rounded text-gray-500">#WD-{{ $wd->id }}</span>
                        <h3 class="text-sm font-black text-slate-800">{{ $wd->user->name ?? 'Nasabah Tanpa Nama' }}</h3>
                    </div>
                    <p class="text-2xl font-black text-emerald-600">Rp {{ number_format($wd->amount, 0, ',', '.') }}</p>
                    <p class="text-[11px] text-gray-400 font-medium">Diajukan pada: {{ $wd->created_at->translatedFormat('d M Y, H:i') }} Wita</p>
                </div>

                {{-- Tengah: Tujuan Informasi Rekening / E-Wallet --}}
                <div class="bg-[#F4F9FC] p-4 rounded-xl min-w-[250px] space-y-1">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Tujuan Pengiriman Dana</p>
                    <p class="text-xs font-black text-slate-700 uppercase flex items-center gap-1.5">
                        @if($wd->method === 'bank_transfer') 💼 Bank: @else 📱 E-Wallet: @endif {{ $wd->account_name }}
                    </p>
                    <p class="text-sm font-mono font-bold text-slate-800 tracking-wider bg-white px-2.5 py-1 rounded border border-cyan-100 inline-block mt-1">
                        {{ $wd->account_number }}
                    </p>
                </div>

                {{-- Kanan: Form Eksekusi Approval / Reject --}}
                <div class="w-full lg:w-auto">
                    <form action="{{ route('assesor.withdrawal.verify', $wd->id) }}" method="POST" class="space-y-3">
                        @csrf
                        
                        {{-- Input Alasan Penolakan Dinamis --}}
                        <div class="hidden id-reject-box-{{ $wd->id }} space-y-1">
                            <input type="text" name="rejection_reason" placeholder="Ketik alasan penolakan..." class="w-full lg:w-64 p-2 text-xs border border-red-200 rounded-xl outline-none focus:border-red-500">
                            <button type="submit" name="action" value="reject" class="w-full py-1.5 bg-red-600 text-white font-bold text-[10px] rounded-lg uppercase">Konfirmasi Tolak ❌</button>
                        </div>

                        <div class="flex gap-2 id-action-buttons-{{ $wd->id }}">
                            {{-- Tombol Trigger Box Tolak --}}
                            <!-- <button type="button" onclick="showRejectInput({{ $wd->id }})" class="px-3 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs uppercase rounded-xl transition-all">
                                Tolak
                            </button> -->

                            {{-- Tombol Approve Setelah Selesai Transfer Manual --}}
                            <button type="submit" name="action" value="approve" class="flex-1 lg:flex-none px-4 py-2.5 bg-[#69C3C1] hover:bg-[#57A3A1] text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm">
                                Sudah Saya Transfer ✓
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        @empty
            <div class="text-center py-12 bg-slate-50/50 rounded-2xl border border-dashed text-gray-400 text-xs font-medium">
                🔒 Dompet Aman! Tidak ada antrean tugas pencairan dana bergiliran untuk Anda saat ini.
            </div>
        @endforelse
    </div>
</div>

<script>
function showRejectInput(id) {
    document.querySelector('.id-reject-box-' + id).classList.remove('hidden');
    document.querySelector('.id-action-buttons-' + id).classList.add('hidden');
}
</script>

@endsection