@extends('admin.layout.app')
@section('title', 'Konfigurasi Sistem')

@section('content')
{{-- <div class="bg-white p-4 rounded shadow">
    <h2 class="bg-(--primary) text-(--text-black) p-2 mb-4">Konfigurasi</h2>
    <input type="text" class="border p-2 w-full mb-3">
    <button class="bg-(--primary) hover:bg(--text-black)--primary) text-(--text-black) px-4 py-2">Update</button> --}}
<div class="bg-white rounded shadow max-w-2xl mx-auto">
    <div class="bg-(--primary) text-(--text-black) px-6 py-4 font-semibold text-lg rounded-t">
        Konfigurasi Sistem SmartWaste
    </div>
    
    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded border border-red-200">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.konfigurasi.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            @forelse($configurations as $config)
                <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                    <label class="block text-sm font-semibold text-gray-700 mb-1 uppercase tracking-wider">
                        {{ ucwords(str_replace('_', ' ', $config->name)) }}
                    </label>
                    <span class="text-xs text-gray-400 block mb-2">Parameter key: <code class="font-mono text-gray-600">{{ $config->name }}</code></span>
                    
                    @if($config->name === 'maintenance_mode')
                        <select name="{{ $config->name }}" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent">
                            <option value="true" {{ $config->value === 'true' ? 'selected' : '' }}>Aktif (Maintenance)</option>
                            <option value="false" {{ $config->value === 'false' ? 'selected' : '' }}>Nonaktif (Live)</option>
                        </select>
                    @elseif($config->name === 'max_payout_limit' || $config->name === 'points_per_kg')
                        <input type="number" name="{{ $config->name }}" value="{{ $config->value }}" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" required>
                    @elseif($config->name === 'contact_email')
                        <input type="email" name="{{ $config->name }}" value="{{ $config->value }}" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" required>
                    @else
                        <input type="text" name="{{ $config->name }}" value="{{ $config->value }}" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" required>
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-500 py-4">Tidak ada data konfigurasi yang ditemukan di database.</p>
            @endforelse
            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-(--primary) hover:bg-opacity-80 text-(--text-black) px-6 py-2.5 rounded font-bold shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection