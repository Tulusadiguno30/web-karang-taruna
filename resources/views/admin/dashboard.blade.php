<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Karang Taruna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #1e293b; color: white; }
        .sidebar .nav-link { color: #cbd5e1; }
        .sidebar .nav-link.active { background-color: #0f172a; color: white; border-radius: 8px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-3 sidebar">
            <h4 class="text-center py-3 fw-bold border-bottom border-secondary"><i class="bi bi-shield-lock-fill"></i> Admin Panel</h4>
            <ul class="nav nav-pills flex-column mb-auto mt-3">
                <li class="nav-item">
                    <a href="#settings-sec" class="nav-link active"><i class="bi bi-gear-fill me-2"></i> Teks Website</a>
                </li>
                <li>
                    <a href="#officer-sec" class="nav-link"><i class="bi bi-people-fill me-2"></i> Pengurus / Anggota</a>
                </li>
                <li>
                    <a href="#gallery-sec" class="nav-link"><i class="bi bi-images me-2"></i> Galeri Kegiatan</a>
                </li>
                <li>
                    <a href="#cash-sec" class="nav-link"><i class="bi bi-wallet2 me-2"></i> Keuangan Kas</a>
                </li>
                <li>
                    <a href="#program-sec" class="nav-link"><i class="bi bi-journal-check me-2"></i> Program Kerja</a>
                </li>
                <li>
                    <a href="#message-sec" class="nav-link"><i class="bi bi-chat-left-dots-fill me-2"></i> Pesan Warga</a>
                </li>
            </ul>
        </div>

        <!-- Content Utama -->
        <div class="col-md-9 col-lg-10 p-4">

            <!-- Alert Success -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h2 class="fw-bold mb-4">Dashboard Kelola Website</h2>

            <!-- 1. EDIT TEKS WEBSITE -->
            <div class="card mb-4 p-4" id="settings-sec">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-pencil-square"></i> Pengaturan Teks Website Profil</h5>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Judul Banner (Hero Title)</label>
                            <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Subjudul / Slogan</label>
                            <input type="text" name="hero_subtitle" class="form-control" value="{{ $settings['hero_subtitle'] ?? '' }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label font-weight-bold">Deskripsi Profil Singkat</label>
                            <textarea name="about_text" class="form-control" rows="3">{{ $settings['about_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-save"></i> Simpan Teks</button>
                </form>
            </div>

            <!-- 2. KELOLA PENGURUS / ANGGOTA -->
            <div class="card mb-4 p-4" id="officer-sec">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-people-fill"></i> Kelola Pengurus & Anggota</h5>
                
                <!-- Form Input Pengurus Baru -->
                <form action="{{ route('admin.officer.store') }}" method="POST" enctype="multipart/form-data" class="mb-4 bg-light p-3 rounded">
                    @csrf
                    <h6 class="fw-bold mb-3">Tambah Pengurus / Anggota Baru</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Ahmad Subagja" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="position" class="form-control" placeholder="Contoh: Ketua / Sekretaris" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Urutan Tampil</label>
                            <input type="number" name="order_level" class="form-control" placeholder="1 untuk Ketua" value="1" required>
                            <small class="text-muted">Urutan posisi foto</small>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Foto Anggota</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3"><i class="bi bi-person-plus-fill"></i> Tambah Pengurus</button>
                </form>

                <!-- Tabel Data Pengurus -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Urutan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($officers as $officer)
                            <tr>
                                <td class="text-center" style="width: 80px;">
                                    @if($officer->photo)
                                        <img src="{{ asset('storage/' . $officer->photo) }}" width="50" height="50" class="rounded-circle object-fit-cover">
                                    @else
                                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-person-fill fs-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $officer->name }}</td>
                                <td><span class="badge bg-primary">{{ $officer->position }}</span></td>
                                <td>Urutan ke-{{ $officer->order_level }}</td>
                                <td>
                                    <form action="{{ route('admin.officer.destroy', $officer->id) }}" method="POST" onsubmit="return confirm('Hapus pengurus ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada data pengurus/anggota. Silakan tambahkan di atas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. KELOLA GALERI KEGIATAN -->
            <div class="card mb-4 p-4" id="gallery-sec">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-images"></i> Upload Galeri Kegiatan</h5>
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="mb-4 bg-light p-3 rounded">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Judul Kegiatan</label>
                            <input type="text" name="title" class="form-control" required placeholder="Contoh: Family Gathering">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="category" class="form-control" placeholder="Lomba / Gathering / Rapat" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="event_date" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">File Foto</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-upload"></i> Upload Foto</button>
                </form>

                <div class="row">
                    @foreach($galleries as $gallery)
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top object-fit-cover" style="height: 150px;">
                            <div class="card-body p-2">
                                <h6 class="card-title fw-bold m-0">{{ $gallery->title }}</h6>
                                <small class="text-muted">{{ $gallery->category }}</small>
                            </div>
                            <div class="card-footer p-2 bg-white border-0">
                                <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm w-100"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- 4. KELOLA PROGRAM KERJA (PROKER) -->
            <div class="card mb-4 p-4" id="program-sec">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-journal-check"></i> Program Kerja (Proker)</h5>
                <form action="{{ route('admin.program.store') }}" method="POST" class="mb-4 bg-light p-3 rounded">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Nama Program Kerja</label>
                            <input type="text" name="title" class="form-control" placeholder="Contoh: Turnamen Voli RT 02" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Divisi / Penanggung Jawab</label>
                            <input type="text" name="division" class="form-control" placeholder="Divisi Olahraga" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status Program</label>
                            <select name="status" class="form-control" required>
                                <option value="Perencanaan">Perencanaan</option>
                                <option value="Berjalan">Berjalan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i> Tambah Proker</button>
                </form>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Program Kerja</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                        <tr>
                            <td>{{ $program->title }}</td>
                            <td>{{ $program->division }}</td>
                            <td><span class="badge bg-info">{{ $program->status }}</span></td>
                            <td>
                                <form action="{{ route('admin.program.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Hapus proker ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">Belum ada Program Kerja.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 5. KELOLA KAS & LAPORAN -->
            <div class="card mb-4 p-4" id="cash-sec">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-primary m-0"><i class="bi bi-wallet2"></i> Transparansi & Rekapitulasi Kas</h5>
                    <a href="{{ route('admin.cash.export-pdf') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF Laporan Kas</a>
                </div>

                <!-- Ringkasan Saldo -->
                <div class="row text-center mb-4">
                    <div class="col-md-4"><div class="p-3 bg-success text-white rounded"><h6>Total Pemasukan</h6><h4>Rp {{ number_format($totalIn, 0, ',', '.') }}</h4></div></div>
                    <div class="col-md-4"><div class="p-3 bg-danger text-white rounded"><h6>Total Pengeluaran</h6><h4>Rp {{ number_format($totalOut, 0, ',', '.') }}</h4></div></div>
                    <div class="col-md-4"><div class="p-3 bg-primary text-white rounded"><h6>Sisa Saldo Kas</h6><h4>Rp {{ number_format($balance, 0, ',', '.') }}</h4></div></div>
                </div>

                <!-- Nav Tabs Kas -->
                <ul class="nav nav-tabs mb-3" id="cashTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="iuran-tab" data-bs-toggle="tab" data-bs-target="#iuran-panel" type="button" role="tab"><i class="bi bi-people-fill me-1"></i> 1. Pemasukan (Iuran Anggota)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="out-tab" data-bs-toggle="tab" data-bs-target="#out-panel" type="button" role="tab"><i class="bi bi-cart-dash-fill me-1"></i> 2. Pengeluaran Operasional Kas</button>
                    </li>
                </ul>

                <div class="tab-content" id="cashTabContent">
                    
                    <!-- TAB 1: PEMASUKAN IURAN ANGGOTA -->
                    <div class="tab-pane fade show active p-3 bg-light rounded" id="iuran-panel" role="tabpanel">
                        <h6 class="fw-bold mb-3 text-success"><i class="bi bi-plus-circle-fill"></i> Catat Pembayaran Iuran Anggota</h6>
                        
                        <form action="{{ route('admin.member-contribution.store') }}" method="POST" class="mb-4 bg-white p-3 rounded border">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Pilih Anggota</label>
                                    <select name="officer_id" class="form-select" required>
                                        <option value="">-- Pilih Nama Anggota --</option>
                                        @foreach($officers as $officer)
                                            <option value="{{ $officer->id }}">{{ $officer->name }} ({{ $officer->position }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Bulan / Periode</label>
                                    <input type="text" name="month_period" class="form-control" placeholder="Contoh: September 2026" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Nominal (Rp)</label>
                                    <input type="number" name="amount" class="form-control" value="10000" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status Bayar</label>
                                    <select name="status" class="form-select" required>
                                        <option value="paid">Sudah Bayar (Lunas)</option>
                                        <option value="unpaid">Belum Bayar</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-3"><i class="bi bi-save"></i> Simpan Status Iuran</button>
                        </form>

                        <h6 class="fw-bold mb-2">Daftar Status Bayar Anggota</h6>
                        <div class="table-responsive bg-white rounded border">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Nama Anggota</th>
                                        <th>Jabatan</th>
                                        <th>Periode</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contributions as $item)
                                    <tr>
                                        <td><strong>{{ $item->officer->name ?? '-' }}</strong></td>
                                        <td>{{ $item->officer->position ?? '-' }}</td>
                                        <td>{{ $item->month_period }}</td>
                                        <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($item->status == 'paid')
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Sudah Bayar</span>
                                            @else
                                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Belum Bayar</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted p-3">Belum ada data iuran recorded.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB 2: PENGELUARAN OPERASIONAL KAS -->
                    <div class="tab-pane fade p-3 bg-light rounded" id="out-panel" role="tabpanel">
                        <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-dash-circle-fill"></i> Catat Pengeluaran Kas Operasional</h6>
                        
                        <form action="{{ route('admin.cash.store') }}" method="POST" enctype="multipart/form-data" class="mb-4 bg-white p-3 rounded border">
                            @csrf
                            <input type="hidden" name="type" value="out">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Keterangan Pengeluaran</label>
                                    <input type="text" name="title" class="form-control" placeholder="Contoh: Beli perlengkapan lomba 17an" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jumlah Pengeluaran (Rp)</label>
                                    <input type="number" name="amount" class="form-control" placeholder="50000" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kategori & Tanggal</label>
                                    <input type="text" name="category" class="form-control mb-2" placeholder="Operasional / Konsumsi" required>
                                    <input type="date" name="transaction_date" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Foto Nota (Opsional)</label>
                                    <input type="file" name="receipt_image" class="form-control" accept="image/*">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger mt-3"><i class="bi bi-plus-lg"></i> Tambah Pengeluaran</button>
                        </form>
                    </div>

                </div>
            </div>

            <!-- 6. PESAN & ASPIRASI WARGA -->
            <div class="card mb-4 p-4" id="message-sec">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-chat-left-dots-fill"></i> Pesan & Aspirasi Masuk</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Warga</th>
                                <th>RT/RW</th>
                                <th>Isi Pesan / Aspirasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $msg)
                            <tr>
                                <td><strong>{{ $msg->name }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $msg->rt_rw }}</span></td>
                                <td>{{ $msg->content }}</td>
                                <td>
                                    <form action="{{ route('admin.message.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada pesan dari warga.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>