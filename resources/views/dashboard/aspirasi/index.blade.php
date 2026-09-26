@extends('layouts.dashboard')

@section('title', 'Aspirasi Warga')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Aspirasi & Masukan Warga</h4>
        <small class="text-muted">Kelola masukan, kritik, dan saran publik dari website utama</small>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Pengirim</th>
                    <th>Kontak / Email</th>
                    <th>Pesan Aspirasi</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirasis as $item)
                <tr>
                    <td class="fw-bold">{{ $item->nama_pengirim }}</td>
                    <td>{{ $item->kontak }}</td>
                    <td style="max-width: 300px;">{{ $item->pesan }}</td>
                    <td>
                        <form action="{{ route('dashboard.aspirasi.updateStatus', $item->aspirasi_id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select form-select-sm fw-semibold {{ $item->status == 'sudah_ditanggapi' ? 'bg-success text-white' : ($item->status == 'dibaca' ? 'bg-info text-white' : 'bg-warning text-dark') }}" onchange="this.form.submit()">
                                <option value="belum_dibaca" {{ $item->status == 'belum_dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                                <option value="dibaca" {{ $item->status == 'dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                                <option value="sudah_ditanggapi" {{ $item->status == 'sudah_ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
                            </select>
                        </form>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('dashboard.aspirasi.destroy', $item->aspirasi_id) }}" method="POST" onsubmit="return confirm('Hapus pesan aspirasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada aspirasi masuk dari warga.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection