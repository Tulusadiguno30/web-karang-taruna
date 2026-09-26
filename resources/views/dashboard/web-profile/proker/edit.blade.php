@extends('layouts.dashboard')

@section('title', 'Edit Program Kerja')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-kanban-fill text-primary me-2"></i>Edit Program Kerja</h5>
            
            <!-- Perhatikan penggunaan $proker->proker_id di sini -->
            <form action="{{ route('dashboard.web-profile.proker.update', $proker->proker_id ?? $proker->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Program Kerja</label>
                    <input type="text" name="nama_proker" class="form-control" value="{{ $proker->nama_proker }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Deskripsi / Tujuan</label>
                    <textarea name="deskripsi" class="form-control" rows="3" required>{{ $proker->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal_pelaksanaan" class="form-control" value="{{ isset($proker->tanggal_pelaksanaan) ? \Carbon\Carbon::parse($proker->tanggal_pelaksanaan)->format('Y-m-d') : '' }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Status Pelaksanaan</label>
                    <select name="status" class="form-select fw-bold" required>
                        <option value="rencana" {{ (strtolower($proker->status) == 'rencana') ? 'selected' : '' }} class="text-secondary">Rencana</option>
                        <option value="berjalan" {{ (strtolower($proker->status) == 'berjalan') ? 'selected' : '' }} class="text-warning">Sedang Berjalan</option>
                        <option value="selesai" {{ (strtolower($proker->status) == 'selesai') ? 'selected' : '' }} class="text-success">Selesai</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard.web-profile.proker.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection