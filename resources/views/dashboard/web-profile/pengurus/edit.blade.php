@extends('layouts.dashboard')

@section('title', 'Edit Data Pengurus')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-person-lines-fill text-primary me-2"></i>Edit Data Pengurus</h5>
            
            <form action="{{ route('dashboard.web-profile.pengurus.update', $pengurus->id ?? $pengurus->pengurus_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ $pengurus->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Jabatan / Posisi</label>
                    <select name="jabatan" class="form-select" required>
                        <option value="Pembina" {{ $pengurus->jabatan == 'Pembina' ? 'selected' : '' }}>Pembina</option>
                        <option value="Ketua" {{ $pengurus->jabatan == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                        <option value="Wakil Ketua" {{ $pengurus->jabatan == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                        <option value="Sekretaris" {{ $pengurus->jabatan == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                        <option value="Bendahara" {{ $pengurus->jabatan == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                        <option value="PDD (Publikasi, Dekorasi & Dokumentasi)" {{ $pengurus->jabatan == 'PDD (Publikasi, Dekorasi & Dokumentasi)' ? 'selected' : '' }}>PDD (Publikasi, Dekorasi & Dokumentasi)</option>
                        <option value="Humas" {{ $pengurus->jabatan == 'Humas' ? 'selected' : '' }}>Humas</option>
                        <option value="Sie Konsumsi" {{ $pengurus->jabatan == 'Sie Konsumsi' ? 'selected' : '' }}>Sie Konsumsi</option>
                        <option value="Sie Perlengkapan" {{ $pengurus->jabatan == 'Sie Perlengkapan' ? 'selected' : '' }}>Sie Perlengkapan</option>
                        <option value="Sie Keamanan" {{ $pengurus->jabatan == 'Sie Keamanan' ? 'selected' : '' }}>Sie Keamanan</option>
                        <option value="Korlap" {{ $pengurus->jabatan == 'Korlap' ? 'selected' : '' }}>Korlap</option>
                        <option value="Sie Kebersihan" {{ $pengurus->jabatan == 'Sie Kebersihan' ? 'selected' : '' }}>Sie Kebersihan</option>
                        <option value="Anggota" {{ $pengurus->jabatan == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Ganti Foto (Opsional)</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        @if($pengurus->foto)
                            <img src="{{ asset('storage/' . $pengurus->foto) }}" alt="Foto Lama" class="rounded-circle border" style="height: 60px; width: 60px; object-fit: cover;">
                        @endif
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard.web-profile.pengurus.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection