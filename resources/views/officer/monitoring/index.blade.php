@extends('officer.layout.app')

@section('title', 'Monitoring')

@section('content')

<div class="bg-white rounded shadow">

    <div class="bg-(--primary) p-2 font-semibold">
        Monitoring Setoran Sampah
    </div>

    <div class="p-4">

        {{-- TABEL --}}
        <table class="w-full border-collapse text-sm">

            <thead class="bg-(--primary)">
                <tr>
                    <th class=" p-2">Tanggal</th>
                    <th class=" p-2">Nama</th>
                    <th class=" p-2">Jenis Sampah</th>
                    <th class=" p-2">Berat</th>
                    <th class=" p-2">Total</th>
                    <th class=" p-2">Status</th>
                </tr>
            </thead>

            <tbody>

                {{-- DATA DUMMY --}}
                <tr class="hover:bg-gray-100">
                    <td class=" p-2">01-01-2025</td>
                    <td class=" p-2">Budi</td>
                    <td class=" p-2">Plastik</td>
                    <td class=" p-2">2 Kg</td>
                    <td class=" p-2">Rp 4.000</td>
                    <td class=" p-2">
                        <span class="bg-green-500 text-white px-2 py-1 text-xs">
                            Selesai
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-100">
                    <td class=" p-2">02-01-2025</td>
                    <td class=" p-2">Sari</td>
                    <td class=" p-2">Kertas</td>
                    <td class=" p-2">3 Kg</td>
                    <td class=" p-2">Rp 3.000</td>
                    <td class=" p-2">
                        <span class="bg-yellow-400 px-2 py-1 text-xs">
                            Pending
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-100">
                    <td class=" p-2">03-01-2025</td>
                    <td class=" p-2">Andi</td>
                    <td class=" p-2">Logam</td>
                    <td class=" p-2">1 Kg</td>
                    <td class=" p-2">Rp 5.000</td>
                    <td class=" p-2">
                        <span class="bg-blue-500 text-white px-2 py-1 text-xs">
                            Diproses
                        </span>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection