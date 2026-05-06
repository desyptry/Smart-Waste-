@extends('user.layout.app')
@section('title', 'Tarik Saldo')

@section('content')
<div class="container p-4 max-w-4xl">
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
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <!-- Pilih Metode -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Metode Pencairan</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative flex flex-col p-4 border-2 border-(--primary) bg-green-50 rounded-2xl cursor-pointer">
                                    <input type="radio" name="metode" value="bank" class="sr-only" checked>
                                    <x-mdi-bank class="w-6 h-6 text-(--primary) mb-2"/>
                                    <span class="text-sm font-bold text-gray-800">Transfer Bank</span>
                                </label>
                                <label class="relative flex flex-col p-4 border-2 border-gray-100 rounded-2xl cursor-pointer hover:bg-gray-50 transition-all">
                                    <input type="radio" name="metode" value="ewallet" class="sr-only">
                                    <x-mdi-wallet class="w-6 h-6 text-gray-400 mb-2"/>
                                    <span class="text-sm font-bold text-gray-800">E-Wallet</span>
                                </label>
                            </div>
                        </div>

                        <!-- Input Detail Rekening -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Bank / Dompet Digital</label>
                                <select class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-(--primary)">
                                    <option>Bank Central Asia (BCA)</option>
                                    <option>Bank Mandiri</option>
                                    <option>GoPay</option>
                                    <option>OVO / Dana</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nomor Rekening / HP</label>
                                <input type="text" placeholder="Contoh: 8830xxxx" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-(--primary)">
                            </div>
                        </div>

                        <!-- Input Nominal -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Penarikan</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-400">Rp</span>
                                <input type="number" class="w-full pl-12 pr-4 py-4 bg-gray-50 border-none rounded-2xl text-xl font-bold focus:ring-2 focus:ring-(--primary)" placeholder="0">
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

            <!-- KOLOM KANAN: RINGKASAN SALDO -->
            <div class="lg:w-1/3">
                <div class="bg-(--text-black) rounded-3xl p-6 text-white shadow-xl shadow-green-100">
                    <h3 class="text-sm font-medium opacity-80 mb-1">Saldo Saat Ini</h3>
                    <p class="text-3xl font-bold mb-6">Rp 200.000,-</p>
                    
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
            </div>

        </div>
    </div>
</div>
@endsection