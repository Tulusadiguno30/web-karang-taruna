@extends('layouts.dashboard')

@section('title', 'Edit Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Data Galeri</h5>
            
            <!-- Perhatikan: action mengarah ke update, method POST, dan ada @method('PUT') -->
            <form action="{{ route('dashboard.web-profile.galeri.update', $galeri->id ?? $galeri->galeri_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Judul Kegiatan</label>
                    <input type="text" name="judul" class="form-control" value="{{ $galeri->judul ?? $galeri->title }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ $galeri->kategori ?? $galeri->category }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tanggal Kegiatan</label>
                    <input type="date" name="event_date" class="form-control" value="{{ $galeri->event_date }}">
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Ganti Foto (Kosongkan jika tidak ingin ganti)</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        @if($galeri->foto ?? $galeri->image)
                            <img src="{{ asset('storage/' . ($galeri->foto ?? $galeri->image)) }}" alt="Foto Lama" class="rounded border" style="height: 60px; object-fit: cover;">
                        @endif
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard.web-profile.galeri.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection