@extends('admin.layout.app')

@section('title', 'Kategori Sampah')

@section('content')
<div class="bg-white rounded shadow">
    <div class="bg-(--primary) text-(--text-black) px-4 py-2 font-semibold">
        Kelola Kategori Sampah
    </div>

    <div class="p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 mb-3 rounded">{{ session('success') }}</div>
        @endif

        {{-- FORM TAMBAH --}}
        <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data" class="mb-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block mb-1 font-medium">Nama Kategori</label>
                    <input type="text" name="name" placeholder="Nama Kategori" class="w-full p-2 rounded border" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Deskripsi</label>
                    <textarea name="description" placeholder="Deskripsi" class="w-full p-2 rounded border" rows="1"></textarea>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Aturan (opsional)</label>
                    <textarea name="rules" placeholder="Aturan" class="w-full p-2 rounded border" rows="1"></textarea>
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Foto Kategori</label>
                <div class="relative inline-block">
                    <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="photoInput">
                    <button type="button" class="bg-(--primary) text-(--text-black) px-4 py-2 rounded" id="photoButton">Pilih Foto</button>
                    <span id="fileName" class="ml-2 text-gray-500">Tidak ada file dipilih</span>
                </div>
            </div>
            <button type="submit" class="bg-(--primary) hover:bg-opacity-80 text-(--text-black) px-4 py-2 rounded">
                Simpan
            </button>
        </form>

        {{-- TABEL --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-(--primary) text-(--text-black)">
                    <tr>
                        <th class="p-2">Foto</th>
                        <th class="p-2">Nama</th>
                        <th class="p-2">Deskripsi</th>
                        <th class="p-2">Aturan</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $k)
                    <tr class="hover:bg-gray-100">
                        <td class="p-2 text-center">
                            @if($k->photo && Storage::disk('public')->exists($k->photo))
                                <img src="{{ Storage::url($k->photo) }}" width="50" height="50" class="object-cover rounded mx-auto">
                            @else
                                <img src="{{ asset('images/kresek.jpg') }}" width="50" height="50" class="object-cover rounded mx-auto">
                            @endif
                        </td>
                        <td class="p-2">{{ $k->name }}</td>
                        <td class="p-2">{{ $k->description ?? '-' }}</td>
                        <td class="p-2">{{ $k->rules ?? '-' }}</td>
                        <td class="p-2 whitespace-nowrap">
                            <button class="bg-yellow-500 text-white px-2 py-1 mr-1 rounded" onclick="openEditModal({{ $k->id }}, '{{ addslashes($k->name) }}', '{{ addslashes($k->description) }}', '{{ addslashes($k->rules) }}', '{{ $k->photo }}')">Edit</button>
                            <form action="{{ route('admin.kategori.destroy', $k->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">Belum ada data kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center" style="z-index:1000;">
    <div class="bg-white rounded shadow w-full max-w-md p-4">
        <h3 class="font-semibold mb-3">Edit Kategori</h3>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label>Nama Kategori</label>
                <input type="text" name="name" id="edit_name" class="w-full border rounded p-1" required>
            </div>
            <div class="mb-2">
                <label>Deskripsi</label>
                <textarea name="description" id="edit_description" class="w-full border rounded p-1"></textarea>
            </div>
            <div class="mb-2">
                <label>Aturan</label>
                <textarea name="rules" id="edit_rules" class="w-full border rounded p-1"></textarea>
            </div>
            <div class="mb-2">
                <label>Foto</label>
                <div class="relative inline-block">
                    <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="editPhotoInput">
                    <button type="button" class="bg-(--primary) text-(--text-black) px-3 py-1 rounded">Pilih Foto</button>
                    <span id="editFileName" class="ml-2 text-gray-500">Tidak ada file dipilih</span>
                </div>
                <div id="current_photo" class="mt-2"></div>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="bg-gray-300 px-3 py-1 rounded">Batal</button>
                <button type="submit" class="bg-(--primary) px-3 py-1 rounded">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Form tambah: tampilkan nama file
    const photoInput = document.getElementById('photoInput');
    const fileNameSpan = document.getElementById('fileName');
    if (photoInput) {
        photoInput.addEventListener('change', function() {
            fileNameSpan.textContent = this.files && this.files[0] ? this.files[0].name : 'Tidak ada file dipilih';
        });
    }

    // Modal edit: tampilkan nama file
    let editPhotoInput = document.getElementById('editPhotoInput');
    let editFileNameSpan = document.getElementById('editFileName');
    if (editPhotoInput) {
        editPhotoInput.addEventListener('change', function() {
            editFileNameSpan.textContent = this.files && this.files[0] ? this.files[0].name : 'Tidak ada file dipilih';
        });
    }

    function openEditModal(id, name, description, rules, photo) {
        const form = document.getElementById('editForm');
        form.action = "{{ url('admin/kategori') }}/" + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description || '';
        document.getElementById('edit_rules').value = rules || '';
        let photoHtml = '';
        if (photo) {
            photoHtml = '<img src="{{ Storage::url('') }}' + photo + '" width="50" class="mb-1"><br><small class="text-gray-500">Kosongkan jika tidak ingin mengganti foto</small>';
        } else {
            photoHtml = '<img src="{{ asset('images/kresek.jpg') }}" width="50" class="mb-1"><br><small class="text-gray-500">Gambar default</small>';
        }
        document.getElementById('current_photo').innerHTML = photoHtml;
        if (editPhotoInput) editPhotoInput.value = '';
        if (editFileNameSpan) editFileNameSpan.textContent = 'Tidak ada file dipilih';
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>
@endsection