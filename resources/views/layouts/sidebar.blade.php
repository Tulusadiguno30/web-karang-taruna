<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Kartar 0210</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #F8FAFC; font-family: 'Segoe UI', system-ui, sans-serif; }
        .sidebar { background: linear-gradient(180deg, #0A2540 0%, #0F172A 100%); min-height: 100vh; }
        .nav-link { color: rgba(255, 255, 255, 0.75); border-radius: 10px; margin-bottom: 2px; }
        .nav-link:hover, .nav-link.active { color: #fff; background-color: #10B981; font-weight: 600; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 p-3 sidebar text-white d-flex flex-column">
            <a href="{{ route('dashboard.index') }}" class="text-white text-decoration-none d-flex align-items-center mb-3">
                <i class="bi bi-shield-check text-success fs-3 me-2"></i>
                <span class="fs-5 fw-bold">KARTAR <span class="text-success">0210</span></span>
            </a>

            <div class="p-2 bg-dark rounded-3 mb-3 border border-secondary">
                <small class="text-muted d-block">Login sebagai:</small>
                <div class="fw-bold text-truncate">{{ auth()->user()->name }}</div>
                <span class="badge bg-success small">{{ strtoupper(auth()->user()->role->nama_role ?? auth()->user()->role ?? 'USER') }}</span>
            </div>

            @php
                // Mengambil role user dengan aman untuk pengecekan menu
                $userRole = strtolower(auth()->user()->role->nama_role ?? auth()->user()->role ?? 'user');
            @endphp

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                {{-- MASTER DATA (ADMIN & KETUA) --}}
                @if(in_array($userRole, ['ketua', 'admin']))
                    <small class="text-uppercase text-muted fw-bold mt-3 mb-1 px-2" style="font-size: 11px;">Master Data</small>
                    <li>
                       <a href="{{ route('dashboard.anggota.index') }}" class="nav-link {{ request()->routeIs('dashboard.anggota.*') ? 'active' : '' }}">
                            <i class="bi bi-people me-2"></i> Data Anggota
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.role.index') }}" class="nav-link {{ request()->routeIs('dashboard.role.*') ? 'active' : '' }}">
                            <i class="bi bi-person-badge me-2"></i> User Role
                        </a>
                    </li>
                @endif

                {{-- WEB PROFILE (ADMIN & KETUA) --}}
                @if(in_array($userRole, ['ketua', 'admin']))
                    <small class="text-uppercase text-muted fw-bold mt-3 mb-1 px-2" style="font-size: 11px;">Web Profile</small>
                    <li>
                        <a href="{{ route('dashboard.web-profile.galeri.index') }}" class="nav-link {{ request()->routeIs('dashboard.web-profile.galeri.*') ? 'active' : '' }}">
                            <i class="bi bi-images me-2"></i> Galeri Kegiatan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.web-profile.proker.index') }}" class="nav-link {{ request()->routeIs('dashboard.web-profile.proker.*') ? 'active' : '' }}">
                            <i class="bi bi-kanban me-2"></i> Program Kerja
                        </a>
                    </li>
                @endif

                {{-- TRANSAKSI KAS (SEKRETARIS, BENDAHARA & KETUA) --}}
                @if(in_array($userRole, ['ketua', 'sekretaris', 'bendahara']))
                    <small class="text-uppercase text-muted fw-bold mt-3 mb-1 px-2" style="font-size: 11px;">Kas Organisasi</small>
                    <li>
                        <a href="{{ route('dashboard.kas.masuk.index') }}" class="nav-link {{ request()->routeIs('dashboard.kas.masuk.*') ? 'active' : '' }}">
                            <i class="bi bi-arrow-down-right-circle me-2"></i> Kas Masuk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.kas.keluar.index') }}" class="nav-link {{ request()->routeIs('dashboard.kas.keluar.*') ? 'active' : '' }}">
                            <i class="bi bi-arrow-up-right-circle me-2"></i> Kas Keluar
                        </a>
                    </li>
                @endif

                {{-- REPORT KAS (ANGGOTA & KETUA) --}}
                @if(in_array($userRole, ['ketua', 'anggota', 'sekretaris', 'bendahara']))
                    <li>
                        <a href="{{ route('dashboard.kas.report.index') }}" class="nav-link {{ request()->routeIs('dashboard.kas.report.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Kas
                        </a>
                    </li>
                @endif

                {{-- ASPIRASI (SEKRETARIS & KETUA) --}}
                @if(in_array($userRole, ['ketua', 'sekretaris']))
                    <small class="text-uppercase text-muted fw-bold mt-3 mb-1 px-2" style="font-size: 11px;">Interaksi</small>
                    <li>
                        <a href="{{ route('dashboard.aspirasi.index') }}" class="nav-link {{ request()->routeIs('dashboard.aspirasi.*') ? 'active' : '' }}">
                            <i class="bi bi-chat-dots me-2"></i> Aspirasi Warga
                        </a>
                    </li>
                @endif
            </ul>

            <form action="{{ route('logout') }}" method="POST" class="mt-auto pt-3">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill btn-sm fw-bold">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>