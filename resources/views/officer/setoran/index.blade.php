@extends('officer.layout.app')

@section('content')

<div class="bg-white p-4 rounded shadow">

    <h3 class="bg-(--primary) p-2 mb-3">Input Setoran Warga</h3>

    <input type="text" placeholder="Pilih Warga" class=" p-2 w-full mb-2">
    <input type="text" placeholder="Jenis Sampah" class=" p-2 w-full mb-2">
    <input type="text" placeholder="Berat (kg)" class=" p-2 w-full mb-2">

    <button class="bg-(--primary) px-4 py-2 text-(--text-black)">Simpan</button>

</div>

@endsection