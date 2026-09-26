@extends('layouts.dashboard')

@section('title', 'Dashboard Utama')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Selamat Datang, {{ auth()->user()->name }}!</h3>
    <p class="text-muted">Anda login sebagai <span class="badge bg-primary text-uppercase">{{ $role }}</span></p>
</div>

@switch($role)
    {{-- ================================= KETUA ================================= --}}
    @case('ketua')
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #10B981 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-wallet2 fs-1 text-success me-3"></i>
                        <div>
                            <p class="mb-1 text-muted small fw-bold text-uppercase">Saldo Kas</p>
                            <h4 class="mb-0 fw-bold">Rp {{ number_format($data['saldo_kas'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #3b82f6 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-arrow-down-circle fs-1 text-primary me-3"></i>
                        <div>
                            <p class="mb-1 text-muted small fw-bold text-uppercase">Kas Masuk (Bulan Ini)</p>
                            <h4 class="mb-0 fw-bold">Rp {{ number_format($data['kas_masuk_bulan'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #ef4444 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-arrow-up-circle fs-1 text-danger me-3"></i>
                        <div>
                            <p class="mb-1 text-muted small fw-bold text-uppercase">Kas Keluar (Bulan Ini)</p>
                            <h4 class="mb-0 fw-bold">Rp {{ number_format($data['kas_keluar_bulan'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #f59e0b !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people fs-1 text-warning me-3"></i>
                        <div>
                            <p class="mb-1 text-muted small fw-bold text-uppercase">Total Anggota</p>
                            <h4 class="mb-0 fw-bold">{{ $data['total_anggota'] }} Orang</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #8b5cf6 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-kanban fs-1 text-purple me-3" style="color:#8b5cf6;"></i>
                        <div>
                            <p class="mb-1 text-muted small fw-bold text-uppercase">Proker Berjalan</p>
                            <h4 class="mb-0 fw-bold">{{ $data['proker_berjalan'] }} Proker</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #ef4444 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-chat-dots fs-1 text-danger me-3"></i>
                        <div>
                            <p class="mb-1 text-muted small fw-bold text-uppercase">Aspirasi Baru</p>
                            <h4 class="mb-0 fw-bold text-danger">{{ $data['aspirasi_baru'] }} Pesan</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark text-white shadow-sm border-0 rounded-4 p-3 h-100 d-flex justify-content-center align-items-center">
                    <a href="/dashboard/kas/masuk" class="btn btn-outline-light btn-sm mb-2 w-100">+ Input Kas</a>
                    <a href="/dashboard/web-profile/proker" class="btn btn-primary btn-sm w-100">Cek Proker</a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-clock-history me-2"></i>8 Transaksi Keuangan Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light"><tr><th>Tanggal</th><th>Jenis</th><th>Keterangan</th><th class="text-end">Nominal</th></tr></thead>
                    <tbody>
                        @foreach($data['transaksi'] as $t)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->waktu)->format('d M Y') }}</td>
                            <td>{!! $t->jenis == 'masuk' ? '<span class="badge bg-success">Masuk</span>' : '<span class="badge bg-danger">Keluar</span>' !!}</td>
                            <td>{{ $t->teks }}</td>
                            <td class="text-end fw-bold {{ $t->jenis == 'masuk' ? 'text-success' : 'text-danger' }}">
                                {{ $t->jenis == 'masuk' ? '+' : '-' }} Rp {{ number_format($t->nominal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @break

    {{-- ================================= ADMIN ================================= --}}
    @case('admin')
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #f59e0b !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people fs-1 text-warning me-3"></i>
                        <div><p class="mb-1 text-muted small fw-bold text-uppercase">Total Anggota</p><h4 class="mb-0 fw-bold">{{ $data['total_user'] }}</h4></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #10B981 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-badge fs-1 text-success me-3"></i>
                        <div><p class="mb-1 text-muted small fw-bold text-uppercase">Pengurus Aktif</p><h4 class="mb-0 fw-bold">{{ $data['pengurus_aktif'] }}</h4></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #06b6d4 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-images fs-1 text-info me-3"></i>
                        <div><p class="mb-1 text-muted small fw-bold text-uppercase">Total Galeri</p><h4 class="mb-0 fw-bold">{{ $data['total_galeri'] }}</h4></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #8b5cf6 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-kanban fs-1 text-purple me-3" style="color:#8b5cf6;"></i>
                        <div><p class="mb-1 text-muted small fw-bold text-uppercase">Proker Berjalan</p><h4 class="mb-0 fw-bold">{{ $data['proker_berjalan'] }}</h4></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
            <h5 class="fw-bold mb-4">Aksi Cepat Admin</h5>
            <div class="d-flex justify-content-center gap-3">
                <a href="/dashboard/anggota" class="btn btn-warning fw-bold"><i class="bi bi-person-plus me-1"></i> Tambah Anggota</a>
                <a href="/dashboard/web-profile/galeri" class="btn btn-info text-white fw-bold"><i class="bi bi-upload me-1"></i> Upload Galeri</a>
                <a href="/dashboard/web-profile/proker" class="btn btn-primary fw-bold"><i class="bi bi-journal-plus me-1"></i> Tambah Proker</a>
            </div>
        </div>
        @break

    {{-- =============================== SEKRETARIS ============================== --}}
    @case('sekretaris')
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #10B981 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Saldo Kas</p><h4 class="mb-0 fw-bold text-success">Rp {{ number_format($data['saldo_kas'], 0, ',', '.') }}</h4></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #3b82f6 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Masuk (Bulan Ini)</p><h4 class="mb-0 fw-bold text-primary">Rp {{ number_format($data['kas_masuk_bulan'], 0, ',', '.') }}</h4></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #ef4444 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Keluar (Bulan Ini)</p><h4 class="mb-0 fw-bold text-danger">Rp {{ number_format($data['kas_keluar_bulan'], 0, ',', '.') }}</h4></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #ef4444 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Aspirasi Baru</p><h4 class="mb-0 fw-bold text-danger">{{ $data['aspirasi_baru'] }} Pesan</h4></div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm border-0 rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-chat-dots me-2"></i>Aspirasi Terbaru</h5>
                <a href="/dashboard/aspirasi" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($data['aspirasi_terbaru'] as $asp)
                    <li class="list-group-item px-0 py-3">
                        <div class="fw-bold">{{ $asp->nama }} <span class="badge bg-danger ms-2">Baru</span></div>
                        <div class="text-muted small mt-1">{{ Str::limit($asp->pesan, 100) }}</div>
                    </li>
                @endforeach
            </ul>
        </div>
        @break

    {{-- =============================== BENDAHARA =============================== --}}
    @case('bendahara')
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #10B981 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Total Saldo Kas</p><h4 class="mb-0 fw-bold text-success">Rp {{ number_format($data['saldo_kas'], 0, ',', '.') }}</h4></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #3b82f6 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Masuk (Bulan Ini)</p><h4 class="mb-0 fw-bold text-primary">Rp {{ number_format($data['kas_masuk_bulan'], 0, ',', '.') }}</h4></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #ef4444 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Keluar (Bulan Ini)</p><h4 class="mb-0 fw-bold text-danger">Rp {{ number_format($data['kas_keluar_bulan'], 0, ',', '.') }}</h4></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 bg-light">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Total Transaksi</p><h4 class="mb-0 fw-bold">{{ $data['total_transaksi'] }} Kali</h4></div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm border-0 rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-wallet2 me-2"></i>5 Transaksi Terakhir</h5>
                <div>
                    <a href="/dashboard/kas/masuk" class="btn btn-outline-success btn-sm me-1">+ Masuk</a>
                    <a href="/dashboard/kas/keluar" class="btn btn-outline-danger btn-sm">- Keluar</a>
                </div>
            </div>
            <table class="table align-middle">
                <tbody>
                    @foreach($data['transaksi'] as $t)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($t->waktu)->format('d M') }}</td>
                        <td>{!! $t->jenis == 'masuk' ? '<span class="text-success"><i class="bi bi-arrow-down-circle"></i> Masuk</span>' : '<span class="text-danger"><i class="bi bi-arrow-up-circle"></i> Keluar</span>' !!}</td>
                        <td>{{ $t->teks }}</td>
                        <td class="text-end fw-bold">Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @break

    {{-- =============================== ANGGOTA ================================= --}}
    @case('anggota')
        <div class="alert alert-info rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-info-circle-fill me-2"></i> Halo! Sebagai anggota, Anda memiliki akses untuk memantau transparansi laporan keuangan Karang Taruna.
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #10B981 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Saldo Kas Saat Ini</p><h4 class="mb-0 fw-bold text-success">Rp {{ number_format($data['saldo_kas'], 0, ',', '.') }}</h4></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #3b82f6 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Total Kas Masuk</p><h4 class="mb-0 fw-bold text-primary">Rp {{ number_format($data['total_masuk'], 0, ',', '.') }}</h4></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100" style="border-left: 5px solid #ef4444 !important;">
                    <div><p class="mb-1 text-muted small fw-bold text-uppercase">Total Kas Keluar</p><h4 class="mb-0 fw-bold text-danger">Rp {{ number_format($data['total_keluar'], 0, ',', '.') }}</h4></div>
                </div>
            </div>
        </div>
        <a href="/dashboard/kas/report" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-file-earmark-bar-graph me-2"></i> Lihat Laporan Detail</a>
        @break

@endswitch
@endsection