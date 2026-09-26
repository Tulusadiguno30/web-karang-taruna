@extends('layouts.dashboard')

@section('title', 'Manajemen User Role')

@section('content')
<div class="row g-4">
    <!-- Form Tambah Role -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-shield-plus text-success me-2"></i>Tambah Role Baru</h5>
            
            <form action="{{ route('dashboard.master.role.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Role</label>
                    <input type="text" name="nama_role" class="form-control" placeholder="Contoh: humas" required>
                    <small class="text-muted fs-7">Gunakan huruf kecil tanpa spasi.</small>
                </div>
                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan Role
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Role -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-shield-check text-primary me-2"></i>Daftar Hak Akses (Role)</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID Role</th>
                            <th>Nama Role</th>
                            <th>Jumlah Pengguna</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td><code>#{{ $role->role_id }}</code></td>
                            <td><span class="badge bg-primary text-uppercase">{{ $role->nama_role }}</span></td>
                            <td>{{ $role->users_count }} Anggota</td>
                            <td class="text-center">
                                @if(!in_array($role->nama_role, ['ketua', 'admin', 'sekretaris', 'bendahara', 'anggota']))
                                    <form action="{{ route('dashboard.master.role.destroy', $role->role_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="bi bi-trash"></i></button>
                                    </form>
                                @else
                                    <span class="badge bg-secondary">System Role</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection