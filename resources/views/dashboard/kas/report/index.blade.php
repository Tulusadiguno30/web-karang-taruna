@extends('layouts.dashboard')

@section('title', 'Laporan Kas')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold text-dark"><i class="bi bi-file-earmark-bar-graph text-primary me-2"></i>Laporan Keuangan Karang Taruna</h4>
    <p class="text-muted">Ringkasan total kas masuk, kas keluar, dan saldo akhir.</p>
</div>

<!-- 3 Kartu Ringkasan (Card) -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-success text-white h-100">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-25 p-3 rounded-3 me-3">
                    <i class="bi bi-arrow-down-circle fs-3"></i>
                </div>
                <div>
                    <p class="mb-1 opacity-75 small fw-bold text-uppercase">Total Kas Masuk</p>
                    <h4 class="mb-0 fw-bold">Rp {{ number_format($totalMasuk ?? 0, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-danger text-white h-100">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-25 p-3 rounded-3 me-3">
                    <i class="bi bi-arrow-up-circle fs-3"></i>
                </div>
                <div>
                    <p class="mb-1 opacity-75 small fw-bold text-uppercase">Total Kas Keluar</p>
                    <h4 class="mb-0 fw-bold">Rp {{ number_format($totalKeluar ?? 0, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-primary text-white h-100">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-25 p-3 rounded-3 me-3">
                    <i class="bi bi-wallet2 fs-3"></i>
                </div>
                <div>
                    <p class="mb-1 opacity-75 small fw-bold text-uppercase">Saldo Akhir</p>
                    <h4 class="mb-0 fw-bold">Rp {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Area Tabel Laporan -->
<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Detail Transaksi</h5>
        <!-- Sesuaikan URL ini dengan route PDF kamu di web.php -->
        <a href="/dashboard/kas/report/pdf" class="btn btn-outline-primary btn-sm rounded-pill fw-bold">
            <i class="bi bi-printer me-1"></i> Cetak PDF
        </a>
    </div>
    
    <!-- Nav Tabs -->
    <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="masuk-tab" data-bs-toggle="tab" data-bs-target="#masuk-pane" type="button" role="tab" aria-controls="masuk-pane" aria-selected="true">
                <i class="bi bi-arrow-down-circle text-success me-1"></i> Kas Masuk
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="keluar-tab" data-bs-toggle="tab" data-bs-target="#keluar-pane" type="button" role="tab" aria-controls="keluar-pane" aria-selected="false">
                <i class="bi bi-arrow-up-circle text-danger me-1"></i> Kas Keluar
            </button>
        </li>
    </ul>

    <!-- Isi Tabs -->
    <div class="tab-content" id="reportTabsContent">
        <!-- Tabel Kas Masuk -->
        <div class="tab-pane fade show active" id="masuk-pane" role="tabpanel" aria-labelledby="masuk-tab" tabindex="0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan / Sumber</th>
                            <th class="text-end">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasMasuk as $masuk)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($masuk->tanggal ?? $masuk->created_at)->format('d M Y') }}</td>
                            <td>{{ $masuk->keterangan ?? $masuk->sumber ?? '-' }}</td>
                            <td class="text-end text-success fw-bold">+ Rp {{ number_format($masuk->nominal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Belum ada data kas masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Kas Keluar -->
        <div class="tab-pane fade" id="keluar-pane" role="tabpanel" aria-labelledby="keluar-tab" tabindex="0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan / Tujuan</th>
                            <th class="text-end">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasKeluar as $keluar)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($keluar->tanggal ?? $keluar->created_at)->format('d M Y') }}</td>
                            <td>{{ $keluar->keterangan ?? $keluar->tujuan ?? '-' }}</td>
                            <td class="text-end text-danger fw-bold">- Rp {{ number_format($keluar->nominal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Belum ada data kas keluar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection