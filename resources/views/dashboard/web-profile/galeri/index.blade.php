@extends('layouts.dashboard')

@section('title', 'Galeri Kegiatan')

@section('content')
<div class="row g-4">
    <!-- Form Upload Foto -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-cloud-upload text-primary me-2"></i>Upload Foto Baru</h5>
            
            <form action="{{ route('dashboard.web-profile.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Judul Kegiatan</label>
                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Kerja Bakti 17 Agustus" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" class="form-control" rows="2" placeholder="Penjelasan singkat..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Pilih File Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                    <i class="bi bi-upload me-1"></i> Upload Foto
                </button>
            </form>
        </div>
    </div>

    <!-- Grid Data Galeri -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-images text-primary me-2"></i>Daftar Foto Galeri</h5>
            
            <div class="row g-3">
                @forelse($galeris ?? [] as $item)
                    <div class="col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                            <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-1 text-truncate" title="{{ $item->judul }}">{{ $item->judul }}</h6>
                                <p class="small text-muted mb-3 text-truncate">{{ $item->deskripsi ?? '-' }}</p>
                                
                               <div class="d-flex gap-2 justify-content-center">
    <!-- TOMBOL EDIT -->
    <a href="{{ route('dashboard.web-profile.galeri.edit', $item->galeri_id ?? $item->id_galeri ?? $item->id) }}" class="btn btn-sm btn-outline-primary w-50 rounded-pill" title="Edit">
        <i class="bi bi-pencil"></i> Edit
    </a>

    <!-- FORM HAPUS -->
    <form action="{{ route('dashboard.web-profile.galeri.destroy', $item->galeri_id ?? $item->id_galeri ?? $item->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?')" class="w-50">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill" title="Hapus">
            <i class="bi bi-trash"></i> Hapus
        </button>
    </form>
</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="bi bi-camera-fill fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        Belum ada foto yang diupload.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection