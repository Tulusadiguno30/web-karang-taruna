<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi Lengkap - Karang Taruna 0210</title>
    
    <!-- Bootstrap 5, Icons, Fonts, AOS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --brand-blue: #0A2540;
            --brand-green: #10B981;
            --bg-light: #F8FAFC;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: #1E293B;
        }
        .navbar-custom {
            background: var(--brand-blue);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .hero-header {
            background: linear-gradient(135deg, var(--brand-blue) 0%, #1E3A8A 100%);
            color: white;
            padding: 100px 0 60px 0;
            margin-bottom: -40px;
        }
        
        /* Divider Antar Divisi */
        .divisi-title {
            position: relative;
            display: inline-block;
            font-weight: 800;
            color: var(--brand-blue);
            margin-bottom: 2rem;
            padding-bottom: 10px;
        }
        .divisi-title::after {
            content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
            width: 80px; height: 4px; background: var(--brand-green); border-radius: 5px;
        }

        /* Card Anggota */
        .officer-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        .officer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(10, 37, 64, 0.08);
            border-color: var(--brand-green);
        }
        .officer-avatar {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ECFDF5;
            box-shadow: 0 6px 12px rgba(16, 185, 129, 0.15);
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-5 d-flex align-items-center gap-2" href="{{ route('public.index') }}">
                <i class="bi bi-arrow-left-circle-fill text-success fs-4"></i>
                <span class="text-white d-none d-sm-inline">Kembali ke Beranda</span>
            </a>
            <span class="text-white-50 small fw-medium ms-auto">KARTAR 0210 GRAHA PRIMA</span>
        </div>
    </nav>

    <!-- HEADER -->
    <header class="hero-header text-center text-white">
        <div class="container" data-aos="zoom-in">
            <h1 class="fw-extrabold mb-3">Struktur Organisasi Lengkap</h1>
            <p class="lead opacity-75 mx-auto" style="max-width: 600px;">
                Daftar lengkap jajaran kepengurusan, koordinator, dan anggota divisi Karang Taruna Graha Prima Blok IE RT 02 / RW 10.
            </p>
        </div>
    </header>

    <!-- DAFTAR PENGURUS -->
    <section class="py-5" style="position: relative; z-index: 10;">
        <div class="container">
            
            @php
                // Mengelompokkan semua data berdasarkan jabatannya
                $groupedOfficers = $officers->groupBy('jabatan');
                
                // Urutan hierarki yang akan dirender (Pastikan namanya sama persis dengan yang ada di database)
                $hierarki = [
                    'Pembina', 
                    'Ketua', 
                    'Wakil Ketua', 
                    'Sekretaris', 
                    'Bendahara', 
                    'PDD (Publikasi, Dekorasi & Dokumentasi)', 
                    'Humas', 
                    'Sie Konsumsi', 
                    'Sie Perlengkapan', 
                    'Sie Keamanan', 
                    'Korlap', 
                    'Sie Kebersihan', 
                    'Anggota'
                ];
            @endphp

            @foreach($hierarki as $jabatan)
                @if($groupedOfficers->has($jabatan))
                    <div class="text-center mt-5 mb-4" data-aos="fade-up">
                        <h3 class="divisi-title">{{ strtoupper($jabatan) }}</h3>
                    </div>

                    <div class="row justify-content-center g-3 g-md-4 mb-5" data-aos="fade-up" data-aos-delay="100">
                        @foreach($groupedOfficers[$jabatan] as $officer)
                            <!-- Jika BPH (Inti) gunakan card lebih besar, jika divisi gunakan grid lebih banyak -->
                            <div class="col-6 col-md-4 {{ in_array($jabatan, ['Pembina', 'Ketua', 'Wakil Ketua']) ? 'col-lg-4' : 'col-lg-3' }}">
                                <div class="officer-card p-4 text-center shadow-sm">
                                    
                                    @if($officer->foto)
                                        <img src="{{ asset('storage/' . $officer->foto) }}" class="officer-avatar mb-3 mx-auto" alt="{{ $officer->nama }}">
                                    @else
                                        <div class="officer-avatar mb-3 mx-auto bg-success text-white d-flex align-items-center justify-content-center fw-bold" style="font-size: 2rem;">
                                            {{ strtoupper(substr($officer->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                    
                                    <h6 class="fw-bold mb-1 text-dark text-truncate" title="{{ $officer->nama }}">{{ $officer->nama }}</h6>
                                    
                                    <!-- Jika ada keterangan tugas/tambahan, bisa ditaruh di sini -->
                                    <span class="text-muted small">Anggota Aktif</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach

            <!-- JIKA KOSONG SAMA SEKALI -->
            @if($officers->isEmpty())
                <div class="text-center py-5 my-5">
                    <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                    <h5 class="text-muted mt-3">Belum ada data struktur kepengurusan.</h5>
                </div>
            @endif

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-4 text-center text-white" style="background-color: var(--brand-blue);">
        <div class="container">
            <p class="m-0 small">&copy; 2026 Karang Taruna Graha Prima 0210. All Rights Reserved.</p>
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