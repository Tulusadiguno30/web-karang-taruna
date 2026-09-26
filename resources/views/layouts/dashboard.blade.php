<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - KARTAR 0210</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; overflow-x: hidden; }
        
        .sidebar { height: 100vh; background-color: #0f172a; color: #cbd5e1; width: 260px; position: fixed; top: 0; left: 0; z-index: 100; overflow-y: auto; }
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background-color: #334155; border-radius: 4px; }
        
        .main-content { margin-left: 260px; flex-grow: 1; padding: 25px; min-height: 100vh; }
        
        .sidebar .brand { font-size: 1.4rem; font-weight: 800; letter-spacing: 1px; color: #fff; margin-bottom: 15px; }
        .sidebar .brand span { color: #10b981; }
        
        .user-box { border: 1px solid #334155; background-color: #1e293b; border-radius: 8px; padding: 12px; margin-bottom: 15px; }
        
        .sidebar .nav-link { color: #cbd5e1; padding: 10px 14px; border-radius: 8px; font-weight: 500; margin-bottom: 2px; display: flex; align-items: center; text-decoration: none; font-size: 0.95rem; transition: all 0.2s; }
        .sidebar .nav-link i { font-size: 1.1rem; margin-right: 12px; }
        
        .sidebar .nav-link:hover { background-color: #1e293b; color: white; }
        .sidebar .nav-link.active { background-color: #0d6efd; color: white; box-shadow: 0 4px 6px -1px rgba(13, 110, 253, 0.2); }
    </style>
</head>
<body>
    @php 
        $role = strtolower(auth()->user()->role ?? 'anggota'); 
        // Pengecekan badge aspirasi baru
        $aspirasiBaru = \App\Models\Aspirasi::where('status', 'belum_dibaca')->count();
    @endphp

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3 d-flex flex-column flex-shrink-0">
            <div class="brand px-2 mt-1">
                <i class="bi bi-shield-check text-success me-1"></i> KARTAR <span>0210</span>
            </div>
            
            <div class="user-box mx-1">
                <div class="fw-bold text-white text-truncate mb-1">{{ auth()->user()->name ?? 'Tulus Adiguno' }}</div>
                <span class="badge bg-success px-2 py-1 text-uppercase">{{ $role }}</span>
            </div>

            <ul class="nav nav-pills flex-column mb-auto px-1">
                <!-- 1. Dashboard (SEMUA ROLE) -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <!-- 2. Data Anggota (KETUA, ADMIN) -->
                @if(in_array($role, ['ketua', 'admin']))
                <li class="nav-item">
                    <a href="/dashboard/anggota" class="nav-link {{ Request::is('dashboard/anggota*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Data Anggota
                    </a>
                </li>
                @endif

                <!-- 3. Kas Masuk & Keluar (KETUA, SEKRETARIS, BENDAHARA) -->
                @if(in_array($role, ['ketua', 'sekretaris', 'bendahara']))
                <li class="nav-item">
                    <a href="/dashboard/kas/masuk" class="nav-link {{ Request::is('dashboard/kas/masuk*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-down-circle"></i> Kas Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/kas/keluar" class="nav-link {{ Request::is('dashboard/kas/keluar*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-up-circle"></i> Kas Keluar
                    </a>
                </li>
                @endif

                <!-- 4. Laporan Kas (SEMUA ROLE) -->
                <li class="nav-item">
                    <a href="/dashboard/kas/report" class="nav-link {{ Request::is('dashboard/kas/report*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph"></i> Laporan Kas
                    </a>
                </li>

                <!-- 5. Proker, Galeri, Struktur Org (KETUA, ADMIN) -->
                @if(in_array($role, ['ketua', 'admin']))
                <li class="nav-item">
                    <a href="/dashboard/web-profile/proker" class="nav-link {{ Request::is('dashboard/web-profile/proker*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event"></i> Program Kerja
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/web-profile/galeri" class="nav-link {{ Request::is('dashboard/web-profile/galeri*') ? 'active' : '' }}">
                        <i class="bi bi-images"></i> Galeri Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/web-profile/pengurus" class="nav-link {{ Request::is('dashboard/web-profile/pengurus*') ? 'active' : '' }}">
                        <i class="bi bi-person-lines-fill"></i> Struktur Organisasi
                    </a>
                </li>
                @endif

                <!-- 6. Aspirasi (KETUA, SEKRETARIS) -->
                @if(in_array($role, ['ketua', 'sekretaris']))
                <li class="nav-item">
                    <a href="/dashboard/aspirasi" class="nav-link {{ Request::is('dashboard/aspirasi*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text"></i> Aspirasi
                        @if($aspirasiBaru > 0)
                            <span class="badge bg-danger ms-auto rounded-circle">{{ $aspirasiBaru }}</span>
                        @endif
                    </a>
                </li>
                @endif
            </ul>

            <div class="mt-4 pt-4 px-1 border-top border-secondary pb-4">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 fw-bold rounded-3 text-white shadow-sm d-flex align-items-center justify-content-center py-2">
                        <i class="bi bi-box-arrow-left fs-5 me-2"></i> LOGOUT
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>