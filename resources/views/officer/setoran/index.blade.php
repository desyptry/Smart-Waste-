@extends('officer.layout.app')

@section('content')

<div class="bg-white p-4 rounded shadow">

    <h3 class="bg-green-300 p-2 mb-3">Input Setoran Warga</h3>

    <input type="text" placeholder="Pilih Warga" class="border p-2 w-full mb-2">
    <input type="text" placeholder="Jenis Sampah" class="border p-2 w-full mb-2">
    <input type="text" placeholder="Berat (kg)" class="border p-2 w-full mb-2">

    <button class="bg-green-400 px-4 py-2 text-white">Simpan</button>

</div>

@endsection