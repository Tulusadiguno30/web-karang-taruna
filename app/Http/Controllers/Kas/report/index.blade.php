@extends('layouts.dashboard')

@section('title', 'Laporan Kas Organisasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Laporan Transaksi & Saldo Kas</h4>
        <small class="text-muted">Rekapitulasi pemasukan dan pengeluaran keuangan Karang Taruna</small>
    </div>
    <a href="{{ route('dashboard.kas.report.pdf') }}" class="btn btn-danger rounded-pill px-3 fw-bold">
        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak Laporan PDF
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-success text-white">
            <small class="text-white-50">Total Kas Masuk</small>
            <h4 class="fw-bold mb-0">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-danger text-white">
            <small class="text-white-50">Total Pengeluaran</small>
            <h4 class="fw-bold mb-0">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-primary text-white">
            <small class="text-white-50">Sisa Saldo Kas</small>
            <h4 class="fw-bold mb-0">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h4>
        </div>
    </div>
</div>
@endsection