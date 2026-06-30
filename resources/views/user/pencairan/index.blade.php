@extends('user.layout.app')
@section('title', 'Tarik Saldo')

@section('content')
<div class="container p-4 max-w-4xlmx-auto space-y-6">
    
    <!-- Flash Message Notifikasi -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-semibold">
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header Section -->
    <div class="mb-2">
        <h2 class="text-2xl font-bold text-gray-800">Ajukan Pencairan Saldo</h2>
        <p class="text-sm text-gray-500">Saldo akan dikirimkan ke rekening atau e-wallet pilihanmu secara aman.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- KOLOM KIRI: FORMULIR -->
        <div class="lg:w-2/3 space-y-6">
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
                <form action="{{ route('user.withdrawal.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Pilih Metode -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Metode Pencairan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative flex flex-col p-4 border-2 border-green-600 bg-green-50 rounded-2xl cursor-pointer" id="label-bank">
                                <input type="radio" name="metode" value="bank_transfer" class="sr-only" checked onclick="switchMethod('bank')">
                                <x-mdi-bank class="w-6 h-6 text-green-600 mb-2"/>
                                <span class="text-sm font-bold text-gray-800">Transfer Bank</span>
                            </label>
                            <label class="relative flex flex-col p-4 border-2 border-gray-100 rounded-2xl cursor-pointer hover:bg-gray-50 transition-all" id="label-wallet">
                                <input type="radio" name="metode" value="e_wallet" class="sr-only" onclick="switchMethod('wallet')">
                                <x-mdi-wallet class="w-6 h-6 text-gray-400 mb-2"/>
                                <span class="text-sm font-bold text-gray-800">E-Wallet</span>
                            </label>
                        </div>
                    </div>

                    <!-- Input Detail Rekening -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2" id="title-account-name">Nama Bank Tujuan</label>
                            <select name="account_name" id="account_name" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-600 focus:bg-white transition-all">
                                <option id="opt-bca" value="Bank Central Asia (BCA)">Bank Central Asia (BCA)</option>
                                <option id="opt-mandiri" value="Bank Mandiri">Bank Mandiri</option>
                                <option id="opt-bni" value="Bank Negara Indonesia (BNI)">Bank Negara Indonesia (BNI)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2" id="title-account-number">Nomor Rekening</label>
                            <input type="text" name="account_number" id="account_number" required placeholder="Contoh: 8830xxxx" value="{{ old('account_number') }}" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-600 focus:bg-white transition-all">
                        </div>
                    </div>

                    <!-- Input Nominal -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Penarikan</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-400">Rp</span>
                            <input type="number" name="amount" min="20000" max="{{ $citizenDetail->balance }}" value="{{ old('amount') }}" required class="w-full pl-12 pr-4 py-4 bg-gray-50 border-gray-200 rounded-2xl text-xl font-bold focus:ring-2 focus:ring-green-600 focus:bg-white transition-all" placeholder="0">
                        </div>
                        <p class="text-[11px] text-gray-400 mt-2 italic">*Minimal penarikan Rp 20.000,-</p>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-2xl transition-all shadow-lg flex items-center justify-center gap-2">
                        Konfirmasi Pencairan
                        <x-mdi-arrow-right class="w-5"/>
                    </button>
                </form>
            </div>
        </div>

        <!-- KOLOM KANAN: RINGKASAN SALDO -->
        <div class="lg:w-1/3 space-y-6">
            <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl">
                <h3 class="text-sm font-medium opacity-80 mb-1">Saldo Saat Ini</h3>
                <p class="text-3xl font-bold mb-6">Rp {{ number_format($citizenDetail->balance, 0, ',', '.') }},-</p>
                
                <div class="space-y-3 pt-6 border-t border-white/20 text-sm">
                    <div class="flex justify-between opacity-80">
                        <span>Biaya Admin</span>
                        <span class="text-emerald-400 font-bold">Gratis</span>
                    </div>
                    <div class="flex justify-between font-bold">
                        <span>Estimasi Tiba</span>
                        <span>1x24 Jam</span>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-black/20 rounded-2xl">
                    <div class="flex gap-3">
                        <x-mdi-shield-check class="w-5 h-5 text-emerald-400 shrink-0"/>
                        <p class="text-[10px] leading-relaxed opacity-90">
                            Dana Anda diproses dengan enkripsi keamanan standar bank. Pastikan data rekening sudah benar sebelum melakukan konfirmasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MONITORING REALTIME: RIWAYAT & STATUS PERSETUJUAN -->
    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
        <h3 class="text-base font-bold text-gray-800 mb-4">Status Pengajuan Penarikan</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-[10px] font-bold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Metode & Tujuan</th>
                        <th class="p-3">Nominal</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3">Asessor Penilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-semibold text-gray-600">
                    @forelse($history as $log)
                        <tr>
                            <td class="p-3 text-xs text-gray-400">{{ $log->created_at->format('d M Y, H:i') }} WIB</td>
                            <td class="p-3 text-xs">
                                <span class="capitalize font-bold text-gray-800">{{ str_replace('_', ' ', $log->method) }}</span><br>
                                <span class="text-gray-400">{{ $log->account_name }} ({{ $log->account_number }})</span>
                            </td>
                            <td class="p-3 text-slate-800 font-bold">Rp {{ number_format($log->amount, 0, ',', '.') }}</td>
                            <td class="p-3 text-center">
                                @if($log->status == 'pending')
                                    <span class="inline-block px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-xs font-bold animate-pulse">Menunggu Persetujuan</span>
                                @elseif($log->status == 'approved')
                                    <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold">Dana Dicairkan</span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 rounded-full text-xs font-bold">Ditolak</span>
                                @endif
                            </td>
                            <td class="p-3 text-xs text-gray-500">
                                @if($log->status == 'pending')
                                    <span class="italic text-gray-400">Sedang diperiksa...</span>
                                @else
                                    <span class="font-bold text-gray-700">{{ $log->asessor->name ?? 'Sistem Otomatis' }}</span>
                                    <br><span class="text-[10px] text-gray-400">{{ $log->approved_at ? \Carbon\Carbon::parse($log->approved_at)->format('d/m H:i') : '' }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 text-sm">Belum ada riwayat pengajuan penarikan saldo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $history->links() }}
        </div>
    </div>
</div>

<!-- JavaScript Integrasi Dinamis -->
<script>
    function switchMethod(type) {
        const labelBank = document.getElementById('label-bank');
        const labelWallet = document.getElementById('label-wallet');
        const titleName = document.getElementById('title-account-name');
        const titleNumber = document.getElementById('title-account-number');
        const selectName = document.getElementById('account_name');
        const inputNumber = document.getElementById('account_number');

        if(type === 'bank') {
            labelBank.className = "relative flex flex-col p-4 border-2 border-green-600 bg-green-50 rounded-2xl cursor-pointer";
            labelWallet.className = "relative flex flex-col p-4 border-2 border-gray-100 rounded-2xl cursor-pointer hover:bg-gray-50 transition-all";
            titleName.innerText = "Nama Bank Tujuan";
            titleNumber.innerText = "Nomor Rekening";
            inputNumber.placeholder = "Contoh: 8830xxxx";

            selectName.innerHTML = `
                <option value="Bank Central Asia (BCA)">Bank Central Asia (BCA)</option>
                <option value="Bank Mandiri">Bank Mandiri</option>
                <option value="Bank Negara Indonesia (BNI)">Bank Negara Indonesia (BNI)</option>
            `;
        } else {
            labelWallet.className = "relative flex flex-col p-4 border-2 border-green-600 bg-green-50 rounded-2xl cursor-pointer";
            labelBank.className = "relative flex flex-col p-4 border-2 border-gray-100 rounded-2xl cursor-pointer hover:bg-gray-50 transition-all";
            titleName.innerText = "Nama Dompet Digital (E-Wallet)";
            titleNumber.innerText = "Nomor HP Akun E-Wallet";
            inputNumber.placeholder = "Contoh: 0812xxxxxxxx";

            selectName.innerHTML = `
                <option value="GoPay">GoPay</option>
                <option value="OVO">OVO</option>
                <option value="Dana">Dana</option>
                <option value="LinkAja">LinkAja</option>
            `;
        }
    }
</script>
@endsection