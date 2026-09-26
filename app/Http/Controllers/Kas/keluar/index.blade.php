@extends('layouts.dashboard')

@section('title', 'Kas Keluar')

@section('content')
<div class="row g-4">
    <!-- Form Input Kas Keluar -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-minus-circle text-danger me-2"></i>Catat Kas Keluar</h5>
            
            <form action="{{ route('dashboard.kas.keluar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Keterangan / Keperluan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Beli Perlengkapan Rapat" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nominal (Rp)</label>
                    <input type="number" name="nominal" class="form-control" placeholder="25000" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Upload Bukti Nota / Struk</label>
                    <input type="file" name="bukti_nota" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan Kas Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Data Kas Keluar -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-arrow-up-right-circle text-danger me-2"></i>Riwayat Kas Keluar</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th>Nota</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasKeluars as $kas)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d/m/Y') }}</td>
                            <td class="fw-semibold">{{ $kas->keterangan }}</td>
                            <td class="text-danger fw-bold">-Rp {{ number_format($kas->nominal, 0, ',', '.') }}</td>
                            <td>
                                @if($kas->bukti_nota)
                                    <a href="{{ asset('storage/' . $kas->bukti_nota) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="bi bi-image"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('dashboard.kas.keluar.destroy', $kas->kas_keluar_id) }}" method="POST" onsubmit="return confirm('Hapus transaksi pengeluaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Belum ada pencatatan kas keluar.</td>
                        </tr>
                        @ forelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection