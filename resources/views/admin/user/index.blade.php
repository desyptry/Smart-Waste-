@extends('admin.layout.app')

@section('title', 'Kelola User')

@section('content')
<div class="bg-white rounded shadow">
    <div class="bg-(--primary) text-(--text-black) px-4 py-2 font-semibold">
        Kelola Data User
    </div>
    <div class="p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 mb-3 rounded">{{ session('success') }}</div>
        @endif
        <button class="bg-(--primary) text-(--text-black) px-4 py-2 mb-4 rounded" onclick="openCreateModal()">
            + Tambah User
        </button>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-(--primary) text-(--text-black)">
                    <tr>
                        <th class="p-2">Nama</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Role</th>
                        <th class="p-2">Alamat</th>
                        <th class="p-2">Telepon</th>
                        <th class="p-2">Status</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">
                            @if($user->role == 'admin') Admin
                            @elseif($user->role == 'officer') Petugas
                            @else Warga
                            @endif
                        </td>
                        <td class="p-2">{{ $user->address ?? '-' }}</td>
                        <td class="p-2">{{ $user->phone_number ?? '-' }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded text-xs {{ $user->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $user->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <button class="bg-yellow-500 text-white px-2 py-1 mr-1 rounded" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}', '{{ addslashes($user->address) }}', '{{ addslashes($user->phone_number) }}', '{{ $user->status }}')">Edit</button>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Yakin hapus user ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center p-4">Belum ada data user.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</div>

{{-- MODAL CREATE --}}
<div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded shadow w-full max-w-md p-4">
        <h3 class="font-semibold mb-3">Tambah User</h3>
        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf
            <div class="mb-2"><label>Nama</label><input type="text" name="name" class="w-full border rounded p-1" required></div>
            <div class="mb-2"><label>Email</label><input type="email" name="email" class="w-full border rounded p-1" required></div>
            <div class="mb-2"><label>Password</label><input type="password" name="password" class="w-full border rounded p-1" required></div>
            <div class="mb-2"><label>Role</label>
                <select name="role" class="w-full border rounded p-1">
                    <option value="admin">Admin</option>
                    <option value="officer">Petugas</option>
                    <option value="resident">Warga</option>
                </select>
            </div>
            <div class="mb-2"><label>Alamat</label><input type="text" name="address" class="w-full border rounded p-1"></div>
            <div class="mb-2"><label>No. Telepon</label><input type="text" name="phone_number" class="w-full border rounded p-1"></div>
            <div class="mb-2"><label>Status</label>
                <select name="status" class="w-full border rounded p-1">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeCreateModal()" class="bg-gray-300 px-3 py-1 rounded">Batal</button>
                <button type="submit" class="bg-(--primary) px-3 py-1 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded shadow w-full max-w-md p-4">
        <h3 class="font-semibold mb-3">Edit User</h3>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="mb-2"><label>Nama</label><input type="text" name="name" id="edit_name" class="w-full border rounded p-1" required></div>
            <div class="mb-2"><label>Email</label><input type="email" name="email" id="edit_email" class="w-full border rounded p-1" required></div>
            <div class="mb-2"><label>Password (kosongkan jika tidak diubah)</label><input type="password" name="password" class="w-full border rounded p-1"></div>
            <div class="mb-2"><label>Role</label>
                <select name="role" id="edit_role" class="w-full border rounded p-1">
                    <option value="admin">Admin</option>
                    <option value="officer">Petugas</option>
                    <option value="resident">Warga</option>
                </select>
            </div>
            <div class="mb-2"><label>Alamat</label><input type="text" name="address" id="edit_address" class="w-full border rounded p-1"></div>
            <div class="mb-2"><label>No. Telepon</label><input type="text" name="phone_number" id="edit_phone" class="w-full border rounded p-1"></div>
            <div class="mb-2"><label>Status</label>
                <select name="status" id="edit_status" class="w-full border rounded p-1">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="bg-gray-300 px-3 py-1 rounded">Batal</button>
                <button type="submit" class="bg-(--primary) px-3 py-1 rounded">Update</button>
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
    function openEditModal(id, name, email, role, address, phone, status) {
        const form = document.getElementById('editForm');
        form.action = "{{ url('admin/user') }}/" + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('edit_address').value = address || '';
        document.getElementById('edit_phone').value = phone || '';
        document.getElementById('edit_status').value = status || 'active';
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>
@endsection