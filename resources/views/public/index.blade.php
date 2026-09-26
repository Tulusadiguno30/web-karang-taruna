<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karang Taruna 0210 - Website Resmi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-color: #F8FAFC; }
        .hero-section {
            background: linear-gradient(135deg, #0A2540 0%, #0F172A 100%);
            color: white;
            padding: 90px 0 70px 0;
        }
        .accent-color { color: #10B981; }
        .bg-accent { background-color: #10B981; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #0A2540;">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="#">
            KARTAR <span class="accent-color">0210</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#profil">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="#proker">Proker</a></li>
                <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="#aspirasi">Aspirasi</a></li>
                <li class="nav-item ms-lg-3">
                    <a href="{{ route('login') }}" class="btn btn-outline-success rounded-pill px-4 btn-sm fw-bold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login Pengurus
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Sinergi Pemuda, Membangun Desa</h1>
        <p class="lead text-white-50 mx-auto mb-4" style="max-width: 650px;">
            Wadah kreativitas, inovasi, dan pengabdian masyarakat pemuda Karang Taruna Unit 0210.
        </p>
        <a href="#aspirasi" class="btn btn-success btn-lg rounded-pill px-4 fw-bold shadow">
            <i class="bi bi-chat-heart me-1"></i> Sampaikan Aspirasi
        </a>
    </div>
</section>

<!-- ALERT NOTIFIKASI -->
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- TENTANG KAMI / PROFIL -->
<section id="profil" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold">Profil Organisasi</h3>
            <div class="bg-accent mx-auto" style="height: 3px; width: 60px;"></div>
        </div>
        <div class="row align-items-center g-4">
            <div class="col-md-6">
                <h4 class="fw-bold mb-3">Karang Taruna Unit 0210</h4>
                <p class="text-muted">
                    Karang Taruna 0210 merupakan wadah pengembangan generasi muda yang tumbuh atas dasar kesadaran dan tanggung jawab sosial dari, oleh, dan untuk masyarakat khususnya pemuda di wilayah pemukiman setempat.
                </p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill accent-color me-2"></i> Mengembangkan Potensi Pemuda</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill accent-color me-2"></i> Kemitraan Kegiatan Sosial & Kebudayaan</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill accent-color me-2"></i> Transparansi Pengelolaan Organisasi</li>
                </ul>
            </div>
            <div class="col-md-6 text-center">
                <div class="p-4 bg-white rounded-4 shadow-sm border">
                    <i class="bi bi-people-fill display-1 accent-color mb-2"></i>
                    <h5 class="fw-bold">Aktif & Solid</h5>
                    <p class="text-muted mb-0">Menjalankan agenda kepemudaan secara berkala dan berkesinambungan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROGRAM KERJA -->
<section id="proker" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold">Program Kerja Agenda</h3>
            <div class="bg-accent mx-auto mb-2" style="height: 3px; width: 60px;"></div>
            <small class="text-muted">Kegiatan yang sedang dan akan dilaksanakan</small>
        </div>
        <div class="row g-4">
            @forelse($prokers as $proker)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge {{ $proker->status == 'berjalan' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                            {{ strtoupper($proker->status) }}
                        </span>
                        <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($proker->tanggal_pelaksanaan)->format('d M Y') }}</small>
                    </div>
                    <h5 class="fw-bold mb-2">{{ $proker->nama_proker }}</h5>
                    <p class="text-muted small mb-0">{{ $proker->deskripsi }}</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-3">Belum ada agenda program kerja aktif.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- GALERI KEGIATAN -->
<section id="galeri" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold">Galeri Dokumentasi</h3>
            <div class="bg-accent mx-auto mb-2" style="height: 3px; width: 60px;"></div>
            <small class="text-muted">Dokumentasi momen kegiatan Karang Taruna</small>
        </div>
        <div class="row g-3">
            @forelse($galeris as $galeri)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <img src="{{ asset('storage/' . $galeri->foto) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $galeri->judul }}">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-1">{{ $galeri->judul }}</h6>
                        <small class="text-muted">{{ $galeri->deskripsi }}</small>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-3">Belum ada foto galeri kegiatan.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- ASPIRASI WARGA -->
<section id="aspirasi" class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 p-4">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Formulir Aspirasi Warga</h4>
                        <p class="text-muted small">Sampaikan saran, masukan, atau kritik Anda untuk pemuda Kartar 0210.</p>
                    </div>

                    <form action="{{ route('public.aspirasi.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_pengirim" class="form-control" placeholder="Nama Anda" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Kontak / No. WhatsApp / Email</label>
                            <input type="text" name="kontak" class="form-control" placeholder="08xxxxx / email@domain.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Pesan Aspirasi</label>
                            <textarea name="pesan" class="form-control" rows="4" placeholder="Tuliskan saran atau masukan Anda..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold">
                            <i class="bi bi-send me-1"></i> Kirim Aspirasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-4 text-center text-white" style="background-color: #0A2540;">
    <div class="container">
        <p class="mb-0 small">&copy; {{ date('Y') }} Karang Taruna Unit 0210. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>