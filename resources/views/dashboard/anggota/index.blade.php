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
                        <!-- Ditambahkan value="old('nama')" -->
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Tulus Adiguno" value="{{ old('nama') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Jenis Kelamin</label>
                        <!-- Ditambahkan logika old() pada option -->
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Gmail / Email</label>
                        <!-- Ditambahkan value="old('email')" -->
                        <input type="email" name="email" class="form-control" placeholder="contoh@gmail.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">No. Telepon / WhatsApp</label>
                        <!-- Ditambahkan value="old('no_tlpn')" -->
                        <input type="text" name="no_tlpn" class="form-control" placeholder="08123456789" value="{{ old('no_tlpn') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Keahlian (Opsional)</label>
                        <!-- Ditambahkan value="old('keahlian')" -->
                        <input type="text" name="keahlian" class="form-control" placeholder="Contoh: Desain Grafis, IT, Teknisi" value="{{ old('keahlian') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Role / Jabatan</label>
                        <!-- Ditambahkan logika old() pada option -->
                        <select name="role" class="form-select" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Pembina" {{ old('role') == 'Pembina' ? 'selected' : '' }}>Pembina</option>
                            <option value="Ketua" {{ old('role') == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="Wakil Ketua" {{ old('role') == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                            <option value="Sekretaris" {{ old('role') == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                            <option value="Bendahara" {{ old('role') == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                            <option value="PDD (Publikasi, Dekorasi & Dokumentasi)" {{ old('role') == 'PDD (Publikasi, Dekorasi & Dokumentasi)' ? 'selected' : '' }}>PDD (Publikasi, Dekorasi & Dokumentasi)</option>
                            <option value="Humas" {{ old('role') == 'Humas' ? 'selected' : '' }}>Humas</option>
                            <option value="Sie Konsumsi" {{ old('role') == 'Sie Konsumsi' ? 'selected' : '' }}>Sie Konsumsi</option>
                            <option value="Sie Perlengkapan" {{ old('role') == 'Sie Perlengkapan' ? 'selected' : '' }}>Sie Perlengkapan</option>
                            <option value="Sie Keamanan" {{ old('role') == 'Sie Keamanan' ? 'selected' : '' }}>Sie Keamanan</option>
                            <option value="Korlap" {{ old('role') == 'Korlap' ? 'selected' : '' }}>Korlap</option>
                            <option value="Sie Kebersihan" {{ old('role') == 'Sie Kebersihan' ? 'selected' : '' }}>Sie Kebersihan</option>
                            <option value="Anggota" {{ old('role') == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-3 fw-bold py-2">
                        <i class="bi bi-save me-1"></i> Simpan Anggota
                    </button>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 mt-3" role="alert">
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
                                <th>Kontak & Keahlian</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                
                                <td>
                                    <span class="fw-medium text-dark"><i class="bi bi-telephone-fill small text-muted me-1"></i> {{ $item->no_tlpn ?? '-' }}</span>
                                    @if($item->keahlian)
                                        <br>
                                        <span class="badge bg-info text-dark mt-1 shadow-sm" style="font-size: 0.7rem;">
                                            <i class="bi bi-star-fill text-warning me-1"></i> {{ $item->keahlian }}
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('dashboard.anggota.edit', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('dashboard.anggota.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
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