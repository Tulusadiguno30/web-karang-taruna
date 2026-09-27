@extends('layouts.dashboard')

@section('title', 'Edit Data Anggota')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-person-badge text-primary me-2"></i>Edit Data Anggota</h5>
            
            <!-- Pastikan routenya sesuai (dashboard.anggota.update) -->
            <form action="{{ route('dashboard.anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ $anggota->nama }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="L" {{ $anggota->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-Laki (L)</option>
                            <option value="P" {{ $anggota->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Email Utama (Login)</label>
                        <input type="email" name="email" class="form-control" value="{{ $anggota->email }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Gmail Tambahan</label>
                        <input type="email" name="gmail" class="form-control" value="{{ $anggota->gmail }}">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">No. Telepon / WhatsApp</label>
                        <input type="text" name="no_tlpn" class="form-control" value="{{ $anggota->no_tlpn }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Role / Jabatan</label>
                        <select name="role" class="form-select" required>
                            @php
                                $roles = ['Pembina', 'Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'PDD (Publikasi, Dekorasi & Dokumentasi)', 'Humas', 'Sie Konsumsi', 'Sie Perlengkapan', 'Sie Keamanan', 'Korlap', 'Sie Kebersihan', 'Anggota', 'Admin'];
                            @endphp
                            @foreach($roles as $r)
                                <option value="{{ $r }}" {{ $anggota->role == $r ? 'selected' : '' }}>{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- FORM INPUT KEAHLIAN YANG BENAR -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Keahlian (Opsional)</label>
                    <input type="text" name="keahlian" class="form-control" value="{{ $anggota->keahlian }}" placeholder="Contoh: Desain Grafis, IT, Teknisi">
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Ganti Foto (Opsional)</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        @if($anggota->foto)
                            <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto Lama" class="rounded-circle border" style="height: 60px; width: 60px; object-fit: cover;">
                        @endif
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard.anggota.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection