@extends('user.layout.app')
@section('title', 'Tarik Saldo')

@section('content')
<div class="container p-4 max-w-6xl mx-auto">
    <div class="wrapper flex flex-col gap-6">
        
        <!-- Header Section -->
        <div class="mb-2">
            <h2 class="text-2xl font-bold text-gray-800">Ajukan Pencairan Saldo</h2>
            <p class="text-sm text-gray-500">Saldo akan dikirimkan ke rekening atau e-wallet pilihanmu.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- KOLOM KIRI: FORMULIR -->
            <div class="lg:w-2/3 space-y-6">
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-xl border border-green-200">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-xl border border-red-200">
                            <ul class="list-disc pl-5 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('user.pencairan.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Pilih Metode -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Metode Pencairan</label>
                            <div class="grid grid-cols-2 gap-3">
                                 <label class="relative flex flex-col p-4 border-2 border-(--primary) bg-green-50 rounded-2xl cursor-pointer method-label" id="label-bank">
                                    <input type="radio" name="metode" value="bank" class="sr-only" checked onchange="toggleMethod('bank')">
                                    <x-mdi-bank class="w-6 h-6 text-(--primary) mb-2"/>
                                    <span class="text-sm font-bold text-gray-800">Transfer Bank</span>
                                </label>
                                 <label class="relative flex flex-col p-4 border-2 border-gray-100 rounded-2xl cursor-pointer hover:bg-gray-50 transition-all method-label" id="label-ewallet">
                                    <input type="radio" name="metode" value="ewallet" class="sr-only" onchange="toggleMethod('ewallet')">
                                    <x-mdi-wallet class="w-6 h-6 text-gray-400 mb-2"/>
                                    <span class="text-sm font-bold text-gray-800">E-Wallet</span>
                                </label>
                            </div>
                        </div>

                        <!-- Input Detail Rekening -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Bank / Dompet Digital</label>
                                <select name="bank_name" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-(--primary)">
                                    <option value="Bank Central Asia (BCA)">Bank Central Asia (BCA)</option>
                                    <option value="Bank Mandiri">Bank Mandiri</option>
                                    <option value="GoPay">GoPay</option>
                                    <option value="OVO">OVO</option>
                                    <option value="DANA">DANA</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nomor Rekening / HP</label>
                                <input type="text" name="account_number" placeholder="Contoh: 8830xxxx" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-(--primary)" required>
                            </div>
                        </div>

                        <!-- Input Nominal -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Penarikan</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-400">Rp</span>
                                <input type="number" name="amount" class="w-full pl-12 pr-4 py-4 bg-gray-50 border-none rounded-2xl text-xl font-bold focus:ring-2 focus:ring-(--primary)" placeholder="0" min="20000" required>
                            </div>
                            <p class="text-[11px] text-gray-400 mt-2 italic">*Minimal penarikan Rp 20.000,-</p>
                        </div>

                        <button type="submit" class="w-full bg-(--text-black) hover:bg-gray-800 text-white font-bold py-4 rounded-2xl transition-all shadow-lg flex items-center justify-center gap-2">
                            Konfirmasi Pencairan
                            <x-mdi-arrow-right class="w-5"/>
                        </button>
                    </form>
                </div>
            </div>

           <!-- KOLOM KANAN: RINGKASAN SALDO & STATUS -->
            <div class="lg:w-1/3 flex flex-col gap-6">
                <!-- Card Saldo -->
                <div class="bg-(--text-black) rounded-3xl p-6 text-white shadow-xl shadow-green-100">
                    <h3 class="text-sm font-medium opacity-80 mb-1">Saldo Saat Ini</h3>
                    <p class="text-3xl font-bold mb-6">Rp {{ number_format($balance, 0, ',', '.') }},-</p>
                    
                    <div class="space-y-3 pt-6 border-t border-white/20 text-sm">
                        <div class="flex justify-between opacity-80">
                            <span>Biaya Admin</span>
                            <span>Gratis</span>
                        </div>
                        <div class="flex justify-between font-bold">
                            <span>Estimasi Tiba</span>
                            <span>1x24 Jam</span>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-black/10 rounded-2xl">
                        <div class="flex gap-3">
                            <x-mdi-shield-check class="w-5 h-5 text-white shrink-0"/>
                            <p class="text-[10px] leading-relaxed opacity-90">
                                Dana Anda diproses dengan enkripsi keamanan standar bank. Pastikan data rekening sudah benar sebelum melakukan konfirmasi.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- History Status Penarikan -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-sm mb-4 uppercase tracking-wider">Status Penarikan</h3>
                    <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                        @forelse($withdrawals as $w)
                        <div class="flex justify-between items-start pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $w->account_name }}</p>
                                <p class="text-[10px] text-gray-400">{{ strtoupper($w->method) }} • {{ $w->account_number }}</p>
                                <p class="text-[9px] text-gray-400 mt-1">{{ $w->created_at ? $w->created_at->translatedFormat('d M Y H:i') : '-' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-red-500">-Rp {{ number_format($w->amount, 0, ',', '.') }}</p>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase mt-1
                                    {{ $w->status == 'approved' ? 'bg-green-100 text-green-700' : ($w->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $w->status == 'approved' ? 'Disetujui' : ($w->status == 'rejected' ? 'Ditolak' : 'Pending') }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-xs text-gray-400 py-4">Belum ada riwayat penarikan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function toggleMethod(type) {
        const labels = document.querySelectorAll('.method-label');
        labels.forEach(label => {
            label.classList.remove('border-(--primary)', 'bg-green-50');
            label.classList.add('border-gray-100');
        });
        
        const activeLabel = document.getElementById('label-' + type);
        activeLabel.classList.add('border-(--primary)', 'bg-green-50');
        activeLabel.classList.remove('border-gray-100');
    }
</script>
@endsection