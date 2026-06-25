@extends('admin.layout.app')

@section('title', 'Kelola Posko')

@section('content')

<div class="bg-white rounded shadow">

    {{-- Header --}}
    <div class="bg-(--primary) text-(--text-black) px-4 py-2 font-semibold flex justify-between items-center">
        <span>Kelola Data Posko (Drop-Off Points)</span>
    </div>

    <div class="p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 mb-3 rounded border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        {{-- FORM INPUT --}}
        {{-- <div class="grid grid-cols-2 gap-2 mb-3">
            <input type="text" placeholder="Nama Posko" class=" p-2 rounded">
            <input type="text" placeholder="Alamat" class=" p-2 rounded">
        </div> --}}
         @if($errors->any())
            <div class="bg-red-100 text-red-700 p-2 mb-3 rounded border border-red-200">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- <button class="bg-(--primary) hover:bg(--text-black)--primary) text-(--text-black) px-4 py-2 mb-4 rounded">
            Simpan --}}
             <button class="bg-(--primary) text-(--text-black) hover:bg-opacity-80 px-4 py-2 mb-4 rounded transition" onclick="openCreateModal()">
            + Tambah Posko
        </button>

    

        {{-- TABEL --}}
         <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-(--primary) text-(--text-black)">
                    <tr>
                        <th class="p-2 text-left">Nama Posko</th>
                        <th class="p-2 text-left">Alamat / Lokasi</th>
                        <th class="p-2 text-left">Assesor Penanggung Jawab</th>
                        <th class="p-2 text-left">Latitude</th>
                        <th class="p-2 text-left">Longitude</th>
                        <th class="p-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($poskos as $p)
                    <tr class="hover:bg-gray-100 border-b border-gray-150 last:border-0">
                        <td class="p-2 font-medium">{{ $p->name }}</td>
                        <td class="p-2 text-gray-600">{{ $p->location }}</td>
                        <td class="p-2">
                            @if($p->assesor)
                                <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">
                                    {{ $p->assesor->name }}
                                </span>
                            @else
                                <span class="text-gray-400 font-italic">Belum ditunjuk</span>
                            @endif
                        </td>
                        <td class="p-2 text-gray-500 font-mono">{{ number_format($p->latitude, 6) }}</td>
                        <td class="p-2 text-gray-500 font-mono">{{ number_format($p->longitude, 6) }}</td>
                        <td class="p-2 whitespace-nowrap text-center">
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 mr-1 rounded transition" 
                                    onclick="openEditModal({{ $p->id }}, '{{ addslashes($p->name) }}', '{{ addslashes($p->location) }}', {{ $p->latitude }}, {{ $p->longitude }}, '{{ $p->assesor_id }}')">
                                Edit
                            </button>
                            <form action="{{ route('admin.posko.destroy', $p->id) }}" method="POST" class="inline">
                                @csrf 
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition" 
                                        onclick="return confirm('Yakin ingin menghapus posko ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center p-6 text-gray-500">Belum ada data posko. Silakan tambahkan baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

            {{-- <thead class="bg-(--primary) text-(--text-black)">
                <tr>
                    <th class="p-2">Nama Posko</th>
                    <th class="p-2">Alamat</th>
                    <th class="p-2">Petugas</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead> --}}

        <div class="mt-4">
            {{ $poskos->links() }}
        </div>
    </div>
</div>
            {{-- <tbody>
                @foreach($poskos as $p)
                <tr class=" hover:bg-gray-100">

                    <td class="p-2">{{ $p['nama'] }}</td>

                    <td class="p-2">{{ $p['alamat'] }}</td>

                    <td class="p-2">
                        <span class="b text-green-700 px-2 py-1 rounded text-xs">
                            {{ $p['petugas'] }} Petugas
                        </span>
                    </td>

                    <td class="p-2">
                        <a href="/admin/posko/{{ $p['id'] }}/edit"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 mr-1 rounded">
                            Edit
                        </a>

                        <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
                            Hapus
                        </button>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div> --}}
{{-- MODAL CREATE --}}
<div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded shadow w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-[#2D333D]">Tambah Posko Baru</h3>
            <button type="button" onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 font-bold">&times;</button>
        </div>
        <form action="{{ route('admin.posko.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Nama Posko</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" placeholder="Contoh: Posko Seririt" required>
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Alamat / Lokasi</label>
                <textarea name="location" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" rows="2" placeholder="Alamat lengkap lokasi" required></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Latitude</label>
                    <input type="number" step="any" name="latitude" value="-8.112000" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Longitude</label>
                    <input type="number" step="any" name="longitude" value="115.088000" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Assesor Penanggung Jawab</label>
                <select name="assesor_id" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent">
                    <option value="">-- Pilih Assesor --</option>
                    @foreach($assesors as $assesor)
                        <option value="{{ $assesor->id }}">{{ $assesor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCreateModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded text-gray-800 transition">Batal</button>
                <button type="submit" class="bg-(--primary) hover:bg-opacity-80 px-4 py-2 rounded text-(--text-black) font-semibold transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded shadow w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-[#2D333D]">Edit Data Posko</h3>
            <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 font-bold">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf 
            @method('PUT')
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Nama Posko</label>
                <input type="text" name="name" id="edit_name" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" required>
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Alamat / Lokasi</label>
                <textarea name="location" id="edit_location" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" rows="2" required></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Latitude</label>
                    <input type="number" step="any" name="latitude" id="edit_latitude" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Longitude</label>
                    <input type="number" step="any" name="longitude" id="edit_longitude" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Assesor Penanggung Jawab</label>
                <select name="assesor_id" id="edit_assesor_id" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-(--primary) focus:border-transparent">
                    <option value="">-- Pilih Assesor --</option>
                    @foreach($assesors as $assesor)
                        <option value="{{ $assesor->id }}">{{ $assesor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded text-gray-800 transition">Batal</button>
                <button type="submit" class="bg-(--primary) hover:bg-opacity-80 px-4 py-2 rounded text-(--text-black) font-semibold transition">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
        document.getElementById('createModal').classList.add('flex');
    }
    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
        document.getElementById('createModal').classList.remove('flex');
    }
    function openEditModal(id, name, location, latitude, longitude, assesor_id) {
        const form = document.getElementById('editForm');
        form.action = "{{ url('admin/posko') }}/" + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_location').value = location;
        document.getElementById('edit_latitude').value = latitude;
        document.getElementById('edit_longitude').value = longitude;
        document.getElementById('edit_assesor_id').value = assesor_id || '';
        
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>
@endsection