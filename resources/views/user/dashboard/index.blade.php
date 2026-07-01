@extends('user.layout.app')
@section('page-title', 'User Dashboard')
@section('title', 'User Dashboard')

@section('content')
<div class="container mx-auto p-4 max-w-7xl">
    <div class="wrapper flex flex-col w-full gap-6">

        <!-- ROW 1: Header & Harga -->
        <div class="flex flex-col lg:flex-row w-full gap-6">
            
            <!-- Kolom Kiri: Saldo & Jadwal -->
            <div class="flex flex-col lg:w-2/3 gap-6">
                <!-- Card Saldo -->
                <div class="flex flex-col-reverse sm:flex-row rounded-2xl bg-(--text-black) text-white p-6 md:p-8 justify-between items-start sm:items-center">
                    <div class="mt-6 sm:mt-0">
                         Selamat {{ $greeting }}, <span class='font-bold'>{{ auth()->user()->name }}</span>!
                        </h2>
                        <p class='text-xs md:text-sm mt-4 opacity-70'>Saldo kamu:</p>
                        <p class="font-semibold text-3xl md:text-4xl mt-1 tracking-tight">
                            <span class="text-lg font-normal">Rp</span>{{ number_format($balance, 0, ',', '.') }},-
                        </p>
                        <a href="{{ route('user.withdrawal') }}" class='inline-block mt-8 text-(--primary) font-bold text-sm border-b border-transparent hover:border-(--primary) transition-all'>
                            Ajukan Pencairan
                        </a>
                    </div>
                    <div class="flex flex-row items-center gap-4 self-end sm:self-start">
                        <button class="p-2 hover:bg-white/10 rounded-full transition-colors">
                            <x-mdi-bell-outline class='w-6 md:w-7 text-white opacity-80'/>
                        </button>
                        <div class="profile-picture w-10 h-10 md:w-12 md:h-12 bg-gray-400 rounded-full overflow-hidden border-2 border-white/20">
                            <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://i.pravatar.cc/150?u=' . auth()->id() }}" alt="Profile" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Card Jadwal & Lokasi -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-lg md:text-xl mb-4 text-gray-800">Jadwal & Lokasi Pengumpulan Sampah</h3>
                    
                    <!-- Mobile View: List Style -->
                    <div class="flex flex-col gap-4 md:hidden">
                        @forelse ($schedules as $sched)
                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 flex flex-col gap-2">
                            <div class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <x-mdi-calendar-month-outline class="w-4 text-cyan-500"/> {{ $sched->start_date->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <div class="flex flex-col gap-1 text-xs text-gray-500">
                                    <span class="flex items-center gap-1"><x-mdi-clock-outline class="w-3"/> {{ $sched->start_date->format('H.i') }} - {{ $sched->finish_date->format('H.i') }}</span>
                                    <span class="flex items-center gap-1"><x-mdi-map-marker-outline class="w-3"/> {{ $sched->dropOffPoint->name ?? '-' }}</span>
                                </div>
                                <a href="{{ route('user.jadwal.show', $sched->id) }}" class="text-xs font-bold text-(--secondary)">Detail</a>
                            </div>
                        </div>
                       @empty
                        <p class="text-center text-xs text-gray-500 py-4">Belum ada jadwal terdekat.</p>
                        @endforelse
                    </div>

                    <!-- Desktop View: Table Style -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($schedules as $sched)
                                <tr class="text-gray-500 hover:bg-gray-50 transition-colors group">
                                    <td class="py-4 flex items-center gap-3">
                                        <x-mdi-calendar-month-outline class="w-5 text-cyan-500 opacity-70 group-hover:opacity-100"/>
                                        {{ $sched->start_date->translatedFormat('l, d F Y') }}
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                             <x-mdi-clock-outline class="w-4 text-cyan-500 opacity-70"/> {{ $sched->start_date->format('H.i') }} - {{ $sched->finish_date->format('H.i') }}
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-2">
                                            <x-mdi-map-marker-outline class="w-4 text-cyan-500 opacity-70"/> {{ $sched->dropOffPoint->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="py-4 text-right px-2">
                                        <a href="{{ route('user.jadwal.show', $sched->id) }}" class="text-(--secondary) font-bold hover:underline">Detail</a>
                                    </td>
                                </tr>
                               @empty
                                <tr>
                                    <td colspan="4" class="text-center text-sm text-gray-500 py-4">Belum ada jadwal terdekat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:w-1/3 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between lg:block mb-6">
                    <h3 class="font-bold text-lg md:text-xl text-gray-800">Harga Sampah Terkini</h3>
                    <span class="lg:hidden text-[10px] bg-cyan-50 text-cyan-600 px-2 py-1 rounded-full uppercase font-bold tracking-wider">Update Hari Ini</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3">
                    @forelse ($wastePrices as $wp)
                    <div class="flex justify-between items-center p-3 rounded-xl border border-dashed border-gray-200 lg:border-none lg:p-0">
                        <span class="text-gray-600 font-medium text-sm md:text-base">{{ $wp['name'] }}</span>
                        <span class="text-gray-900 font-bold text-sm md:text-base">Rp {{ number_format($wp['price'], 0, ',', '.') }}<span class="text-[10px] text-gray-400 font-normal">/Kg</span></span>
                    </div>
                    @empty
                    <p class="text-center text-xs text-gray-500 py-4">Belum ada data harga.</p>
                    @endforelse
                </div>
            </div>
        </div>

 <!-- Row Bawah: Riwayat -->
        <div class="wrapper-row-2 w-full">
            <div class="flex flex-col w-full rounded-2xl bg-[#A8D1B7]/80 backdrop-blur-sm p-5 md:p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                    <div>
                        <h3 class="font-bold text-xl text-gray-800">Riwayat Pengumpulan Sampah</h3>
                        <p class="text-sm text-gray-700 font-medium opacity-80">Periode: {{ now()->translatedFormat('F Y') }}</p>
                    </div>
             
                    <p class="text-sm text-gray-800">Total Pendapatan: <span class="font-bold text-lg text-(--text-black)">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span></p>
                </div>
                    </span>
                </div>
                
                 <!-- Grid Responsif untuk Card Riwayat -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                    @forelse ($riwayat as $item)
                    <div class="bg-white/90 rounded-2xl p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <span class="text-[10px] font-bold uppercase text-gray-400 px-2 py-1 rounded-md">
                                {{ $item->wasteDeposit->deposit_date ? $item->wasteDeposit->deposit_date->translatedFormat('d M') : '-' }}
                            </span>
                        </div>
                        
                        <div class="flex flex-col">
                            <h4 class="font-bold text-gray-800 text-base">{{ $item->wastePrice->wasteCategory->name ?? '-' }}</h4>
                            <div class="flex items-center gap-1 text-gray-500 text-sm mt-1">
                                <x-mdi-weight-kilogram class="w-4"/>
                                <span>{{ number_format($item->weight_kg, 1, ',', '.') }} Kg</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-dashed border-gray-200 flex justify-between items-center">
                            <span class="text-[10px] text-gray-400 font-medium">Pendapatan</span>
                            <span class="text-sm font-bold text-(--secondary)">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center text-sm text-gray-600 py-4">Belum ada riwayat setoran sampah.</div>
                    @endforelse
                </div>
                    </div>
                
            </div>
            
        </div>
    </div>
</div>

@endsection