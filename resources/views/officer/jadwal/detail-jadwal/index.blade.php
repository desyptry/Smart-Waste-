@extends('officer.layout.app')

@section('content')
    {{-- Include Navigasi Atas / Sidebar Sub-Menu --}}
    @include('officer.jadwal.detail-jadwal.sidebar')

    {{-- Tiga Kotak Statistik Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        {{-- Massa Terkumpul (Dinamis) --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-gray-100 flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-gray-400 font-black uppercase text-[10px] tracking-wider">Massa Terkumpul</p>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                    {{ number_format($totalMassa ?? 0, 2) }} <span class="text-sm font-semibold text-gray-400">Kg</span>
                </h3>
                <p class="text-[11px] text-[#69C3C1] font-bold">Total muatan masuk jadwal ini</p>
            </div>
            <div class="p-4 bg-[#F4F9FC] text-[#69C3C1] rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
            </div>
        </div>

        {{-- Perputaran Kas (Dinamis) --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-gray-100 flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-gray-400 font-black uppercase text-[10px] tracking-wider">Perputaran Kas</p>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                    Rp {{ number_format($totalKas ?? 0, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-emerald-500 font-bold">Dana saldo tersalurkan</p>
            </div>
            <div class="p-4 bg-emerald-50 text-emerald-500 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        {{-- Aktivitas Setoran (Dinamis) --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-gray-100 flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-gray-400 font-black uppercase text-[10px] tracking-wider">Aktivitas Setoran</p>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                    {{ $totalNasabah ?? 0 }} <span class="text-sm font-semibold text-gray-400">Nasabah</span>
                </h3>
                <p class="text-[11px] text-amber-500 font-bold">Antrean timbangan tercatat</p>
            </div>
            <div class="p-4 bg-amber-50 text-amber-500 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

    </div>

    {{-- Layout Grid Bawah --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Log Timbangan Terakhir --}}
        <div class="bg-white rounded-[2rem] p-6 md:p-8 shadow-xl border border-gray-100 lg:col-span-2 space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-base font-black text-slate-800 uppercase tracking-wider">Aktivitas Timbangan Terakhir</h3>
                    <p class="text-xs text-gray-400 font-semibold mt-0.5">Transaksi setoran masuk paling mutakhir</p>
                </div>
                <a href="{{ route('officer.jadwal.detail.setoran', $schedule->id) }}" class="text-xs font-black text-[#69C3C1] hover:underline uppercase tracking-wide">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-gray-50">
                <table class="w-full text-sm text-left bg-white">
                    <thead class="bg-[#F4F9FC] text-[10px] font-black uppercase tracking-wider text-slate-800 border-b border-gray-100">
                        <tr>
                            <th class="p-4 pl-6">ID Detail</th>
                            <th class="p-4">Berat</th>
                            <th class="p-4">Total Rupiah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 font-semibold text-slate-600">
                        {{-- Loop riwayat timbangan riil jika sudah ada relasi ke transaksi --}}
                        @forelse($recentTransactions ?? [] as $tx)
                            <tr>
                                <td class="p-4 font-black text-slate-800 pl-6">#DTL-{{ $tx->id }}</td>
                                <td class="p-4">{{ number_format($tx->total_weight, 2) }} Kg</td>
                                <td class="p-4 text-emerald-600 font-bold">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-6 text-center text-gray-400 text-xs font-medium">Belum ada aktivitas penimbangan untuk jadwal ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Card Informasi Petugas & Waktu Terikat Jadwal --}}
        <div class="bg-white rounded-[2rem] p-6 md:p-8 shadow-xl border border-gray-100 space-y-6 flex flex-col justify-between">
            <div class="space-y-4">
                <h3 class="text-base font-black text-slate-800 uppercase tracking-wider">Informasi Petugas & Waktu</h3>
                
                <div class="space-y-3">
                    <div class="p-4 bg-[#F4F9FC] rounded-2xl border border-gray-50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Petugas Penanggung Jawab</p>
                        {{-- Mengambil nama user melalui relasi officer -> user --}}
                        <p class="font-black text-slate-800 text-sm mt-1">
                            {{ $schedule->officer->user->name ?? 'Ahmad Setiawan' }}
                        </p>
                    </div>

                    <div class="p-4 bg-[#F4F9FC] rounded-2xl border border-gray-50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Jam Mulai Operasional</p>
                        <p class="font-bold text-slate-700 text-sm mt-1">
                            {{ \Carbon\Carbon::parse($schedule->start_date)->translatedFormat('d F Y, H:i') }} WITA
                        </p>
                    </div>

                    <div class="p-4 bg-[#F4F9FC] rounded-2xl border border-gray-50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Jam Selesai Operasional</p>
                        <p class="font-bold text-slate-700 text-sm mt-1">
                            {{ \Carbon\Carbon::parse($schedule->finish_date)->translatedFormat('d F Y, H:i') }} WITA
                        </p>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi Menuju Menu Timbangan --}}
            <a href="{{ route('officer.jadwal.detail.setoran', $schedule->id) }}" class="w-full py-4 bg-[#2D333D] hover:bg-slate-800 text-white font-black text-center text-xs uppercase tracking-widest rounded-xl transition-all shadow-md block">
                Mulai Timbang Sekarang
            </a>
        </div>

    </div> {{-- Penutup tag Grid Utama yang sebelumnya hilang --}}
@endsection
