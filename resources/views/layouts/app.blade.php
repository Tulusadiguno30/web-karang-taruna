<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard KARTAR 0210</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #0b2239; color: #fff; width: 260px; }
        .sidebar .brand { font-size: 1.5rem; font-weight: 800; letter-spacing: 1px; color: #fff; }
        .sidebar .brand span { color: #10b981; }
        .sidebar .user-info { font-size: 0.9rem; color: #94a3b8; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; }
        .sidebar .nav-link { color: #cbd5e1; padding: 12px 16px; border-radius: 8px; font-weight: 500; margin-bottom: 4px; display: flex; align-items: center; text-decoration: none; }
        .sidebar .nav-link i { font-size: 1.2rem; margin-right: 12px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: rgba(255, 255, 255, 0.08); color: #10b981; }
        .sidebar .nav-link.text-danger:hover { color: #ef4444 !important; background-color: rgba(239, 68, 68, 0.1); }
        .main-content { flex-grow: 1; padding: 25px; }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar Navigation -->
        <div class="sidebar p-3 d-flex flex-column flex-shrink-0">
            <div class="brand mb-2 px-2">
                KARTAR <span>0210</span>
            </div>
            <div class="user-info mb-3 px-2">
                <i class="bi bi-person-circle me-1"></i> Tulus Adiguno
                <div class="small text-muted">(KETUA)</div>
            </div>

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard.kas.report.index') }}" class="nav-link {{ Request::is('dashboard/kas/report*') ? 'active' : '' }}">
                        <i class="bi bi-pie-chart-fill"></i> Laporan Kas
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.kas.masuk.index') }}" class="nav-link {{ Request::is('dashboard/kas/masuk*') ? 'active' : '' }}">
                        <i class="bi bi-box-arrow-in-down-left"></i> Kas Masuk
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.kas.keluar.index') }}" class="nav-link {{ Request::is('dashboard/kas/keluar*') ? 'active' : '' }}">
                        <i class="bi bi-box-arrow-up-right"></i> Kas Keluar
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.web-profile.proker.index') }}" class="nav-link {{ Request::is('dashboard/web-profile/proker*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event"></i> Proker
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.web-profile.galeri.index') }}" class="nav-link {{ Request::is('dashboard/web-profile/galeri*') ? 'active' : '' }}">
                        <i class="bi bi-image"></i> Galeri
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.aspirasi.index') }}" class="nav-link {{ Request::is('dashboard/aspirasi*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text"></i> Aspirasi
                    </a>
                </li>
            </ul>

            <div class="pt-3 border-top border-secondary">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link text-danger w-100 border-0 bg-transparent text-start">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>