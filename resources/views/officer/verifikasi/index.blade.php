@extends('officer.layout.app')

@section('title', 'Verifikasi')

@section('content')

<div class="bg-white rounded shadow">

    <div class="bg-(--primary) p-2 font-semibold">
        Verifikasi Penarikan
    </div>

    <div class="p-4">

        <table class="w-full border-gray-400 border-collapse text-sm">

            <thead class="bg-(--primary)">
                <tr>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Saldo</th>
                    <th class="p-2">Nominal</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>

                {{-- DATA DUMMY --}}
                <tr class="hover:bg-gray-100">
                    <td class="p-2">Budi</td>
                    <td class="p-2">Rp 50.000</td>
                    <td class="p-2">Rp 20.000</td>
                    <td class="p-2">
                        <span class="bg-yellow-400 px-2 py-1 text-xs">Pending</span>
                    </td>
                    <td class="p-2">
                        <button class="bg-green-500 text-white px-2 py-1 mr-1">
                            Setujui
                        </button>
                        <button class="bg-red-500 text-white px-2 py-1">
                            Tolak
                        </button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-100">
                    <td class="p-2">Sari</td>
                    <td class="p-2">Rp 80.000</td>
                    <td class="p-2">Rp 30.000</td>
                    <td class="p-2">
                        <span class="bg-yellow-400 px-2 py-1 text-xs">Pending</span>
                    </td>
                    <td class="p-2">
                        <button class="bg-green-500 text-white px-2 py-1 mr-1">
                            Setujui
                        </button>
                        <button class="bg-red-500 text-white px-2 py-1">
                            Tolak
                        </button>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection