@extends('layouts.dashboard')

@section('title', 'Program Kerja')

@section('content')
<div class="row g-4">
    <!-- Form Tambah Proker -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-kanban text-primary me-2"></i>Tambah Program Kerja</h5>
            
            <form action="{{ route('dashboard.web-profile.proker.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Program Kerja</label>
                    <input type="text" name="nama_proker" class="form-control" placeholder="Contoh: HUT RI ke-81" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Deskripsi / Tujuan</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat proker..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal_pelaksanaan" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Status Pelaksanaan</label>
                    <select name="status" class="form-select" required>
                        <option value="rencana">Rencana</option>
                        <option value="berjalan">Sedang Berjalan</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan Proker
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Data Proker -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-list-task text-primary me-2"></i>Daftar Program Kerja</h5>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 py-2" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close pb-2" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Program</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prokers ?? [] as $proker)
                        <tr>
                            <td class="fw-bold">{{ $proker->nama_proker }}</td>
                            <td>{{ isset($proker->tanggal_pelaksanaan) ? \Carbon\Carbon::parse($proker->tanggal_pelaksanaan)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <span class="text-muted text-truncate d-inline-block" style="max-width: 150px;" title="{{ $proker->deskripsi }}">
                                    {{ $proker->deskripsi }}
                                </span>
                            </td>
                            <td>
                                @if(strtolower($proker->status) == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif(strtolower($proker->status) == 'berjalan')
                                    <span class="badge bg-warning text-dark">Berjalan</span>
                                @else
                                    <span class="badge bg-secondary">Rencana</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <!-- TOMBOL EDIT -->
                                    <a href="{{ route('dashboard.web-profile.proker.edit', $proker->id ?? $proker->proker_id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Edit Status">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- FORM HAPUS -->
                                    <form action="{{ route('dashboard.web-profile.proker.destroy', $proker->id ?? $proker->proker_id) }}" method="POST" onsubmit="return confirm('Hapus program kerja ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data program kerja.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection