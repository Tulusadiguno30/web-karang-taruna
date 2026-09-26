<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['hero_title'] ?? 'Karang Taruna 0210 - Graha Prima' }}</title>
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --brand-blue: #0A2540;
            --brand-blue-light: #1E3A8A;
            --brand-green: #10B981;
            --brand-green-bright: #059669;
            --brand-neon-green: #34D399;
            --bg-light: #F8FAFC;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: #1E293B;
            overflow-x: hidden;
        }

        /* 1. Navbar Glassmorphism */
        .navbar {
            background: rgba(10, 37, 64, 0.85) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        /* 2. Hero Section */
        .hero-section {
            background: linear-gradient(rgba(10, 37, 64, 0.8), rgba(30, 58, 138, 0.8)), url('{{ asset("images/hero-bg.jpg") }}') center/cover no-repeat;
            background-color: var(--brand-blue); /* Fallback */
            color: white;
            padding: 140px 0 100px 0;
            position: relative;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #FFFFFF 30%, var(--brand-neon-green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }
        .badge-tag {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(52, 211, 153, 0.5);
            color: var(--brand-neon-green);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            backdrop-filter: blur(4px);
        }

        /* 4. Struktur Organisasi Card */
        .officer-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .officer-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(10, 37, 64, 0.08);
        }
        .officer-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 5px;
            background: linear-gradient(90deg, var(--brand-blue-light), var(--brand-green));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .officer-card:hover::before { opacity: 1; }
        .officer-avatar {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ECFDF5;
            box-shadow: 0 8px 15px rgba(16, 185, 129, 0.15);
        }

        /* 5. Galeri Card */
        .gallery-card {
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        .gallery-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 35px rgba(10, 37, 64, 0.12);
        }
        .gallery-img-wrapper { height: 220px; overflow: hidden; }
        .gallery-img-wrapper img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.5s ease;
        }
        .gallery-card:hover .gallery-img-wrapper img { transform: scale(1.1); }

        /* Banner Sosmed */
        .banner-ig { background: linear-gradient(135deg, #833AB4 0%, #FD1D1D 50%, #FCB045 100%); border-radius: 24px; }
        .banner-tiktok { background: linear-gradient(135deg, #000000 0%, #00F2FE 50%, #4FACFE 100%); border-radius: 24px; }

        /* Global Titles */
        .section-title { font-weight: 800; color: var(--brand-blue); position: relative; display: inline-block; }
        .section-title::after {
            content: ''; display: block; width: 60px; height: 5px;
            background: linear-gradient(90deg, var(--brand-blue-light), var(--brand-green));
            border-radius: 10px; margin: 10px auto 0 auto;
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 2.2rem; }
        }
    </style>
</head>
<body>

    <!-- 1. NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2" href="#">
                <img src="{{ asset('images/logo-kartar.png') }}" alt="Logo Kartar" height="38" onerror="this.style.display='none'">
                <span class="text-white">KARTAR <span class="text-success">0210</span></span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-1 gap-lg-3 align-items-lg-center">
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="#profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="#pengurus">Struktur</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="#galeri">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="#proker">Proker</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="#kas">Keuangan</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="#aspirasi">Aspirasi</a></li>
                    <li class="nav-item mt-2 mt-lg-0">
                        @auth
                            <a class="btn btn-success text-white btn-sm rounded-pill px-4 fw-bold shadow-sm" href="{{ route('dashboard.index') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        @else
                            <a class="btn btn-outline-success text-white btn-sm rounded-pill px-4 fw-bold border-2" href="{{ route('login') }}">
                                <i class="bi bi-person-lock me-1"></i> Login Admin
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 2. HERO SECTION -->
    <section class="hero-section text-center">
        <div class="container position-relative" data-aos="zoom-in" data-aos-duration="1000">
            <span class="badge-tag d-inline-block shadow-sm mb-3">
                <i class="bi bi-geo-alt-fill me-1"></i> Graha Prima Blok IE RT 02 / RW 10, Tambun Utara
            </span>
            <h1 class="hero-title mb-3">KARANG TARUNA 0210</h1>
            <p class="lead text-light opacity-90 mx-auto mb-4 fw-medium" style="max-width: 680px;">
                "BERSATU, SATU TEKAT, SERIBU KARYA"
            </p>
            <div class="d-flex justify-content-center flex-wrap gap-2 mt-4">
                <a href="#aspirasi" class="btn btn-success btn-lg rounded-pill px-4 fs-6 fw-bold shadow-lg border-0">
                    <i class="bi bi-chat-left-heart-fill me-1"></i> Kirim Aspirasi
                </a>
                <a href="https://www.instagram.com/kartar_graha0210" target="_blank" class="btn btn-outline-light btn-lg rounded-pill px-3 fs-6 fw-bold">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@kartargrahaprima" target="_blank" class="btn btn-outline-light btn-lg rounded-pill px-3 fs-6 fw-bold">
                    <i class="bi bi-tiktok"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 3. PROFIL SINGKAT -->
    <section id="profil" class="py-5" style="margin-top: -30px; position: relative; z-index: 10;">
        <div class="container">
            <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 bg-white" data-aos="fade-up">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="text-success fw-bold text-uppercase small"><i class="bi bi-shield-check me-1"></i> Tentang Kami</span>
                        <h3 class="fw-extrabold mb-3 mt-1" style="color: var(--brand-blue);">Pemuda Penggerak Lingkungan</h3>
                        <p class="text-secondary leading-relaxed mb-4">
                            Karang Taruna 0210 adalah wadah pembinaan dan pengembangan generasi muda yang aktif di wilayah Graha Prima Blok IE RT 02 / RW 10. Kami berkomitmen menjalin silaturahmi, mengembangkan bakat, dan berkontribusi nyata untuk masyarakat sekitar.
                        </p>
                        
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-start gap-3 bg-light p-3 rounded-3 border h-100">
                                    <div class="bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-flag-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Tahun Berdiri</h6>
                                        <span class="text-muted small">Aktif mengabdi untuk lingkungan warga.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-start gap-3 bg-light p-3 rounded-3 border h-100">
                                    <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Total Anggota</h6>
                                        <span class="text-muted small">{{ $totalAnggota ?? 35 }} Orang Anggota Terdaftar.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="p-4 rounded-4 shadow-sm h-100" style="background: linear-gradient(135deg, var(--brand-blue) 0%, #1E3A8A 100%); color: white;">
                            <h5 class="fw-bold text-success mb-3"><i class="bi bi-bullseye me-2"></i>Visi & Misi</h5>
                            <h6 class="fw-bold">Visi:</h6>
                            <p class="small opacity-75 mb-3">Mewujudkan generasi muda yang kreatif, inovatif, peduli lingkungan, dan berjiwa sosial tinggi.</p>
                            <h6 class="fw-bold">Misi:</h6>
                            <ul class="small opacity-75 mb-0 ps-3">
                                <li class="mb-1">Mempererat tali persaudaraan antar pemuda.</li>
                                <li class="mb-1">Mengadakan program kerja sosial kemasyarakatan.</li>
                                <li>Mendukung setiap agenda positif lingkungan RT/RW.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. STRUKTUR ORGANISASI (BPH SAJA) -->
    <section id="pengurus" class="py-5 bg-light">
        <div class="container py-4 text-center">
            <span class="text-success fw-bold text-uppercase small tracking-wide"><i class="bi bi-person-lines-fill me-1"></i> Tim Pengurus Inti</span>
            <h2 class="section-title mb-2">Struktur Organisasi</h2>
            <p class="text-muted mb-5">Badan Pengurus Harian (BPH) KARTAR 0210 yang berdedikasi tinggi</p>

            <div class="row g-3 g-md-4 justify-content-center" data-aos="fade-up">
                @forelse($officers ?? [] as $officer)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="officer-card p-3 p-md-4 text-center h-100 shadow-sm">
                        
                        @if($officer->foto)
                            <img src="{{ asset('storage/' . $officer->foto) }}" class="officer-avatar mb-3 mx-auto" alt="{{ $officer->nama }}">
                        @else
                            <div class="officer-avatar mb-3 mx-auto bg-success text-white d-flex align-items-center justify-content-center fw-bold" style="font-size: 2.5rem;">
                                {{ strtoupper(substr($officer->nama, 0, 1)) }}
                            </div>
                        @endif
                        
                        <h6 class="fw-bold mb-1 text-dark text-truncate" title="{{ $officer->nama }}">{{ $officer->nama }}</h6>
                        <!-- GUNAKAN KOLOM JABATAN SESUAI TABEL PENGURUS -->
                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 fw-bold rounded-pill px-3 py-1 mt-1">
                            {{ $officer->jabatan }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted fst-italic">Data struktur kepengurusan BPH belum ditambahkan.</p>
                </div>
                @endforelse
            </div>

            <!-- Tombol Menuju Halaman Struktur Lengkap -->
            <div class="mt-5 pt-4 border-top" data-aos="fade-up">
                <a href="{{ route('public.struktur') }}" class="btn btn-outline-success rounded-pill px-5 py-2 fw-bold shadow-sm">
                    <i class="bi bi-diagram-3 me-2"></i> Lihat Seluruh Struktur Pengurus & Divisi
                </a>
                <p class="small text-muted mt-2">Menampilkan 35+ Anggota & Koordinator Lapangan</p>
            </div>

        </div>
    </section>

    <!-- 5. GALERI KEGIATAN -->
    <section id="galeri" class="py-5 bg-white">
        <div class="container py-4 text-center">
            <span class="text-success fw-bold text-uppercase small tracking-wide"><i class="bi bi-camera-fill me-1"></i> Dokumentasi</span>
            <h2 class="section-title mb-2">Galeri Kegiatan</h2>
            <p class="text-muted mb-5">Momen keseruan acara dan pengabdian masyarakat</p>

            <div class="row g-4" data-aos="fade-up">
                @forelse($galleries ?? [] as $gallery)
                <div class="col-md-4 col-sm-6">
                    <div class="card gallery-card h-100">
                        <div class="gallery-img-wrapper">
                            @php $galImg = $gallery->image ?? $gallery->foto ?? null; @endphp
                            @if($galImg)
                                <img src="{{ asset('storage/' . $galImg) }}" alt="{{ $gallery->title ?? $gallery->judul ?? 'Galeri' }}">
                            @else
                                <img src="https://via.placeholder.com/400x300?text=No+Image" alt="No Image">
                            @endif
                        </div>
                        <div class="card-body text-start p-4">
                            <span class="badge bg-success mb-2">{{ $gallery->category ?? $gallery->kategori ?? 'Umum' }}</span>
                            <h6 class="fw-bold mb-1 text-dark">{{ $gallery->title ?? $gallery->judul ?? 'Kegiatan' }}</h6>
                            <small class="text-muted d-block"><i class="bi bi-calendar3 me-1"></i> 
                                {{ isset($gallery->event_date) ? date('d M Y', strtotime($gallery->event_date)) : (isset($gallery->created_at) ? $gallery->created_at->format('d M Y') : '-') }}
                            </small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted fst-italic">Belum ada foto galeri yang diupload.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 6. PROGRAM KERJA (PROKER) -->
    <section id="proker" class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-success fw-bold text-uppercase small tracking-wide"><i class="bi bi-kanban-fill me-1"></i> Agenda</span>
                <h2 class="section-title mb-2">Program Kerja</h2>
                <p class="text-muted">Daftar kegiatan, progress, dan penanggung jawab</p>
            </div>

            <div class="row g-3" data-aos="fade-up">
                @forelse($programs ?? [] as $program)
                <div class="col-md-6">
                    <div class="p-4 bg-white rounded-4 d-flex justify-content-between align-items-center border shadow-sm h-100">
                        <div>
                            <h6 class="fw-bold m-0 text-dark mb-1">{{ $program->title ?? $program->nama_proker }}</h6>
                            <small class="text-muted d-block mb-1"><i class="bi bi-person-badge me-1"></i> PIC: <span class="fw-medium text-dark">{{ $program->penanggung_jawab ?? $program->pic ?? 'Pengurus' }}</span></small>
                            <small class="text-secondary">{{ $program->deskripsi ?? 'Kegiatan kepemudaan.' }}</small>
                        </div>
                        <div class="ms-3 text-end">
                            @php $stat = strtolower($program->status ?? 'rencana'); @endphp
                            <span class="badge 
                                @if($stat == 'selesai') bg-success 
                                @elseif($stat == 'berjalan') bg-warning text-dark 
                                @else bg-secondary @endif 
                                rounded-pill px-3 py-2 shadow-sm">
                                {{ ucfirst($stat) }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted">Belum ada program kerja yang ditambahkan.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 7. TRANSPARANSI KAS -->
    <section id="kas" class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-success fw-bold text-uppercase small tracking-wide"><i class="bi bi-wallet2 me-1"></i> Keterbukaan Publik</span>
                <h2 class="section-title mb-2">Transparansi Saldo Kas</h2>
                <p class="text-muted">Laporan rekapitulasi keuangan organisasi secara real-time</p>
            </div>

            <div class="row g-4 justify-content-center" data-aos="fade-up">
                <div class="col-md-4">
                    <div class="card border-0 rounded-4 p-4 text-center bg-light shadow-sm border-top border-success border-5 h-100">
                        <small class="text-muted fw-bold">TOTAL PEMASUKAN</small>
                        <h3 class="fw-extrabold text-success mt-2 mb-0">Rp {{ number_format($totalIn ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 rounded-4 p-4 text-center bg-light shadow-sm border-top border-danger border-5 h-100">
                        <small class="text-muted fw-bold">TOTAL PENGELUARAN</small>
                        <h3 class="fw-extrabold text-danger mt-2 mb-0">Rp {{ number_format($totalOut ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 rounded-4 p-4 text-center bg-light shadow-sm border-top border-primary border-5 h-100">
                        <small class="text-muted fw-bold">SALDO AKHIR</small>
                        <h3 class="fw-extrabold text-primary mt-2 mb-0">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. BANNER MEDIA SOSIAL -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="banner-ig p-4 p-md-5 text-white d-flex flex-column justify-content-between h-100 shadow-lg">
                        <div>
                            <span class="badge bg-white text-dark mb-3 fw-bold"><i class="bi bi-instagram me-1"></i> Instagram Official</span>
                            <h3 class="fw-extrabold mb-2">@kartar_graha0210</h3>
                            <p class="small opacity-90 mb-4">Lihat update foto kegiatan, info event terbaru, dan keseruan pemuda RT 02/RW 10.</p>
                        </div>
                        <a href="https://www.instagram.com/kartar_graha0210" target="_blank" class="btn btn-light rounded-pill fw-bold text-dark w-100 py-2 shadow-sm">
                            Kunjungi Instagram
                        </a>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="banner-tiktok p-4 p-md-5 text-white d-flex flex-column justify-content-between h-100 shadow-lg">
                        <div>
                            <span class="badge bg-white text-dark mb-3 fw-bold"><i class="bi bi-tiktok me-1"></i> TikTok Official</span>
                            <h3 class="fw-extrabold mb-2">@kartargrahaprima</h3>
                            <p class="small opacity-90 mb-4">Tonton video dokumentasi seru, konten kreatif, dan kekompakan warga di TikTok!</p>
                        </div>
                        <a href="https://www.tiktok.com/@kartargrahaprima" target="_blank" class="btn btn-light rounded-pill fw-bold text-dark w-100 py-2 shadow-sm">
                            Kunjungi TikTok
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. FORM ASPIRASI WARGA -->
    <section id="aspirasi" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="zoom-in">
                    <div class="card border-0 rounded-4 p-4 p-md-5 shadow-lg" style="background-color: var(--bg-light);">
                        <div class="text-center mb-4">
                            <span class="text-success fw-bold text-uppercase small"><i class="bi bi-chat-dots-fill me-1"></i> Suara Warga</span>
                            <h3 class="fw-extrabold text-dark mt-1">Form Aspirasi Warga</h3>
                            <p class="text-muted small">Sampaikan saran, masukan, atau kritik untuk kemajuan lingkungan RT 02/RW 10.</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('public.aspirasi.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control form-control-lg fs-6 rounded-3" placeholder="Masukkan nama" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small">RT / RW <span class="text-danger">*</span></label>
                                    <input type="text" name="rt_rw" class="form-control form-control-lg fs-6 rounded-3" placeholder="Contoh: RT 02 / RW 10" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark small">No. WhatsApp <span class="text-danger">*</span></label>
                                    <input type="number" name="no_wa" class="form-control form-control-lg fs-6 rounded-3" placeholder="Contoh: 08123456789" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark small">Pesan / Aspirasi <span class="text-danger">*</span></label>
                                    <textarea name="pesan" rows="4" class="form-control form-control-lg fs-6 rounded-3" placeholder="Tulis saran / keluhan Anda..." required></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill mt-4 fw-bold shadow-sm border-0">
                                <i class="bi bi-send-fill me-1"></i> Kirim Aspirasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. FOOTER -->
    <footer class="py-5" style="background-color: var(--brand-blue); color: #94A3B8;">
        <div class="container">
            <div class="row g-4 justify-content-between mb-4">
                <div class="col-lg-4">
                    <h5 class="text-white fw-bold mb-3">KARTAR 0210</h5>
                    <p class="small mb-3">Karang Taruna Graha Prima Blok IE RT 02 / RW 10, wadah pergerakan sosial kemasyarakatan pemuda-pemudi yang kreatif, aktif, dan inovatif.</p>
                </div>
                <div class="col-lg-3">
                    <h5 class="text-white fw-bold mb-3">Kontak & Alamat</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-success"></i> Desa Satria Jaya, Kec. Tambun Utara, Kab. Bekasi, Jawa Barat.</li>
                        <li class="mb-2"><i class="bi bi-envelope-fill me-2 text-success"></i> kartar0210@gmail.com</li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h5 class="text-white fw-bold mb-3">Sosial Media</h5>
                    <div class="d-flex gap-3">
                        <a href="https://www.instagram.com/kartar_graha0210" target="_blank" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.tiktok.com/@kartargrahaprima" target="_blank" class="text-white fs-4"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary pt-4 text-center">
                <p class="m-0 small text-white-50">&copy; 2026 Karang Taruna Graha Prima 0210. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
</body>
</html>