<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan Kas Masuk - Karang Taruna 0210</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; }
        .sidebar { min-height: 100vh; background-color: #0A2540; color: white; }
        .sidebar .nav-link { color: #CBD5E1; padding: 12px 20px; border-radius: 8px; margin-bottom: 4px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #1E293B; color: #10B981; }
        .accent-color { color: #10B981; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <h5 class="fw-bold mb-4 px-2">KARTAR <span class="accent-color">0210</span></h5>
            <div class="small text-white-50 px-2 mb-3">
                <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }} ({{ strtoupper(auth()->user()->role) }})
            </div>
            <hr class="border-secondary">

            <ul class="nav flex-column">
                @if(auth()->user()->role == 'ketua' || auth()->user()->role == 'bendahara')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.kas.report.index') }}">
                        <i class="bi bi-pie-chart-fill me-2"></i> Laporan Kas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('dashboard.kas.masuk.index') }}">
                        <i class="bi bi-arrow-down-left-square me-2"></i> Kas Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.kas.keluar.index') }}">
                        <i class="bi bi-arrow-up-right-square me-2"></i> Kas Keluar
                    </a>
                </li>
                @endif

                @if(auth()->user()->role == 'ketua' || auth()->user()->role == 'sekretaris')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.web-profile.proker.index') }}">
                        <i class="bi bi-calendar-event me-2"></i> Proker
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.web-profile.galeri.index') }}">
                        <i class="bi bi-images me-2"></i> Galeri
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.aspirasi.index') }}">
                        <i class="bi bi-chat-left-text me-2"></i> Aspirasi
                    </a>
                </li>
                @endif

                <li class="nav-item mt-4">
                    <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <h1 class="h3 fw-bold">Pencatatan Kas Masuk</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- FORM INPUT -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-3 text-success"><i class="bi bi-plus-circle me-2"></i>Tambah Kas Masuk</h5>
                        
                        <form action="{{ route('dashboard.kas.masuk.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Tanggal Transaksi</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Keterangan / Sumber Dana</label>
                                <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Iuran Bulanan Warga" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Nominal (Rp)</label>
                                <input type="number" name="nominal" class="form-control" placeholder="50000" min="1" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2">
                                <i class="bi bi-save me-1"></i> Simpan Transaksi
                            </button>
                        </form>
                    </div>
                </div>

                <!-- TABEL DATA -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-3">Riwayat Kas Masuk</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Nominal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kasMasuks ?? [] as $kas)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d/m/Y') }}</td>
                                        <td class="fw-semibold">{{ $kas->keterangan }}</td>
                                        <td class="text-success fw-bold">+Rp {{ number_format($kas->nominal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('dashboard.kas.masuk.destroy', $kas->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Belum ada pencatatan kas masuk.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>