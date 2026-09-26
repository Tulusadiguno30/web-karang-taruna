@extends('layouts.dashboard')

@section('title', 'Data Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Kelola Data Anggota</h4>
        <small class="text-muted">Master data seluruh pengurus & anggota Karang Taruna</small>
    </div>
    <a href="{{ route('dashboard.master.anggota.create') }}" class="btn btn-success rounded-pill px-3 fw-bold">
        <i class="bi bi-person-plus me-1"></i> Tambah Anggota
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Gmail / Email</th>
                    <th>Jenis Kelamin</th>
                    <th>No. WhatsApp</th>
                    <th>Role Jabatan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anggotas as $anggota)
                <tr>
                    <td class="fw-bold">{{ $anggota->name }}</td>
                    <td>{{ $anggota->email }}</td>
                    <td>{{ $anggota->jenis_kelamin ?? '-' }}</td>
                    <td>{{ $anggota->no_hp ?? '-' }}</td>
                    <td>
                        <span class="badge bg-success text-uppercase">{{ $anggota->role->nama_role ?? 'Tanpa Role' }}</span>
                    </td>
                    <td class="text-center">
                        @if($anggota->id !== auth()->id())
                            <form action="{{ route('dashboard.master.anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('Hapus data anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="bi bi-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection