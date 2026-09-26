@extends('layouts.dashboard')

@section('title', 'Data Anggota - KARTAR 0210')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4 pb-2 border-bottom">
        <h2 class="fw-bold">Data Anggota</h2>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- FORM TAMBAH ANGGOTA -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4 text-success"><i class="bi bi-person-plus me-2"></i>Tambah Anggota</h5>
                
                <form action="{{ route('dashboard.anggota.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Tulus Adiguno" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Gmail / Email</label>
                        <input type="email" name="email" class="form-control" placeholder="contoh@gmail.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">No. Telepon / WhatsApp</label>
                        <input type="text" name="kontak" class="form-control" placeholder="08123456789" required>
                    </div>

                    <div class="mb-3">
    <label class="form-label fw-bold text-muted small">Role / Jabatan</label>
    <select name="role" class="form-select" required>
        <option value="">-- Pilih Jabatan --</option>
        <option value="Pembina">Pembina</option>
        <option value="Ketua">Ketua</option>
        <option value="Wakil Ketua">Wakil Ketua</option>
        <option value="Sekretaris">Sekretaris</option>
        <option value="Bendahara">Bendahara</option>
        <option value="PDD">PDD (Publikasi, Dekorasi & Dokumentasi)</option>
        <option value="Humas">Humas</option>
        <option value="Sie Konsumsi">Sie Konsumsi</option>
        <option value="Sie Perlengkapan">Sie Perlengkapan</option>
        <option value="Sie Keamanan">Sie Keamanan</option>
        <option value="Korlap">Korlap</option>
        <option value="Sie Kebersihan">Sie Kebersihan</option>
        <option value="Anggota">Anggota</option>
        <option value="Admin">Admin</option>
    </select>
</div>
                    <button type="submit" class="btn btn-success w-100 rounded-3 fw-bold py-2">
                        <i class="bi bi-save me-1"></i> Simpan Anggota
                    </button>
                    <!-- TAMPILKAN PESAN ERROR JIKA ADA VALIDASI YANG GAGAL -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Gagal Menyimpan!</strong> Periksa kembali inputan kamu:
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
                </form>
            </div>
        </div>

        <!-- TABEL DATA ANGGOTA -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-people me-2"></i>Daftar Anggota Terdaftar</h5>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>L/P</th>
                                <th>Role</th>
                                <th>Kontak</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel anggotas (bisa disesuaikan jika controller kamu pakai $anggota) --}}
                            @forelse($anggotas ?? $anggota ?? [] as $item)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $item->nama }}</div>
                                    <div class="small text-muted">{{ $item->email }}</div>
                                </td>
                                <td>{{ $item->jenis_kelamin ?? $item->jk ?? '-' }}</td>
                                <td>
                                    @if(strtolower($item->role ?? '') == 'ketua')
                                        <span class="badge bg-primary">Ketua</span>
                                    @elseif(strtolower($item->role ?? '') == 'admin')
                                        <span class="badge bg-dark">Admin</span>
                                    @else
                                        <span class="badge bg-success">{{ ucfirst($item->role ?? 'Anggota') }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->kontak ?? $item->no_hp ?? '-' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('dashboard.anggota.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                                        <a href="{{ route('dashboard.anggota.edit', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Edit">
                                           <i class="bi bi-pencil"></i>
                                            </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Belum ada data anggota.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection