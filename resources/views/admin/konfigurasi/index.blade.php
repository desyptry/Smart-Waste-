@extends('admin.layout.app')
@section('title', 'Konfigurasi')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h2 class="bg-(--primary) text-(--text-black) p-2 mb-4">Konfigurasi</h2>
    <input type="text" class="border p-2 w-full mb-3">
    <button class="bg-(--primary) hover:bg(--text-black)--primary) text-(--text-black) px-4 py-2">Update</button>
</div>
@endsection