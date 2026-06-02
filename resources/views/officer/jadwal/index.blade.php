@extends('officer.layout.app')

@section('content')

<div class="bg-white rounded shadow">

    <div class="bg-(--primary) p-2 font-semibold flex justify-between items-center">
        <span>Kelola Jadwal & Harga Sampah</span>
    </div>

    <div class="p-4">

        {{-- FORM INPUT --}}
        <form action="#" method="POST" class="mb-6 bg-gray-50 p-4  rounded">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                <div>
                    <label class="block text-xs font-bold mb-1">Tanggal</label>
                    <input type="date" name="tanggal" class=" -gray-400 p-2 w-full rounded">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Kategori Sampah</label>
                    <select name="kategori" class=" -gray-400 p-2 w-full rounded">
                        <option value="Plastik">Plastik</option>
                        <option value="Kertas/Kardus">Kertas/Kardus</option>
                        <option value="Logam/Besi">Logam/Besi</option>
                        <option value="Organik">Organik</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Harga (Rp/Kg)</label>
                    <input type="number" name="harga" placeholder="Contoh: 3000" class=" -gray-400 p-2 w-full rounded">
                </div>
            </div>

            <button type="submit" class="bg-(--primary) hover:bg-(--primary-hover) text-(--text-black) font-bold px-6 py-2 rounded shadow">
                Simpan Jadwal & Harga
            </button>
        </form>

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto">
            <table class="w-full  text-sm border-collapse text-left">
                <thead class="bg-(--primary)">
                    <tr>
                        <th class=" p-2">Tanggal</th>
                        <th class=" p-2">Kategori</th>
                        <th class=" p-2">Harga /Kg</th>
                        <th class=" p-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh Baris Data --}}
                    <tr class="hover:bg-gray-100">
                        <td class=" p-2">2025-01-01</td>
                        <td class=" p-2"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Plastik</span></td>
                        <td class=" p-2">Rp 3.000</td>
                        <td class=" p-2 text-center">
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mr-1">Edit</button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class=" p-2">2025-01-01</td>
                        <td class=" p-2"><span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">Kertas</span></td>
                        <td class=" p-2">Rp 1.500</td>
                        <td class=" p-2 text-center">
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mr-1">Edit</button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection