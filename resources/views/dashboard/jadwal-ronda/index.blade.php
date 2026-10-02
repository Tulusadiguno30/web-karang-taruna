@extends('layouts.dashboard')

@section('title', 'Manajemen Jadwal Ronda')

@section('content')
<div class="row g-4">
    <!-- Form Generate -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-calendar2-check-fill text-primary me-2"></i>Buat Jadwal Baru</h5>
            <p class="small text-muted mb-4">Pilih rentang 3 bulan. Sistem akan mencari hari Sabtu dan membagi warga secara acak merata.</p>
            
            @if(session('error'))
                <div class="alert alert-danger py-2">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success py-2">{{ session('success') }}</div>
            @endif

            <form action="{{ route('dashboard.jadwal-ronda.generate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tanggal Mulai (Misal: 1 Agt)</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold">Tanggal Selesai (Misal: 31 Okt)</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required>
                </div>
                <!-- TOMBOL YANG SUDAH DIREVISI -->
                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold" onclick="return confirm('Sistem akan membuat jadwal dengan kelompok warga yang tetap. Lanjutkan?')">
                    <i class="bi bi-calendar-plus me-1"></i> Buat Jadwal Berurutan
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-clock-history text-primary me-2"></i>Riwayat Jadwal Ronda</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Periode Jadwal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatJadwal as $riwayat)
                        <tr>
                            <td class="fw-bold text-success">{{ $riwayat->periode }}</td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('dashboard.jadwal-ronda.pdf', $riwayat->periode) }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Cetak PDF">
                                        <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
                                    </a>
                                    
                                    <form action="{{ route('dashboard.jadwal-ronda.destroy-periode', $riwayat->periode) }}" method="POST" onsubmit="return confirm('Hapus seluruh jadwal periode ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-circle" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted py-4">Belum ada jadwal yang dibuat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection