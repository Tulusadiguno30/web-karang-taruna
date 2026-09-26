@extends('layouts.dashboard')

@section('title', 'Kas Masuk')

@section('content')
<div class="row g-4">
    <!-- Form Input Kas Masuk -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle text-success me-2"></i>Catat Kas Masuk</h5>
            
            <form action="{{ route('dashboard.kas.masuk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Dropdown Pilih Anggota -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Pilih Anggota / Pembayar</label>
                    <select name="anggota_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Nama Anggota --</option>
                        @foreach($anggotas as $anggota)
                            <option value="{{ $anggota->id }}">
                                {{ $anggota->nama }} ({{ $anggota->role }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Keterangan / Sumber Dana</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Iuran Bulanan Warga" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nominal (Rp)</label>
                    <input type="number" name="nominal" class="form-control" placeholder="50000" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Upload Bukti / Nota (Opsional)</label>
                    <input type="file" name="bukti_nota" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan Transaksi
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Data Kas Masuk -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-arrow-down-right-circle text-success me-2"></i>Riwayat Kas Masuk</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pembayar</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasMasuks as $kas)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d/m/Y') }}</td>
                            <td>
                                <span class="fw-semibold text-dark d-block">{{ $kas->anggota->nama ?? '-' }}</span>
                                <small class="badge bg-secondary">{{ $kas->anggota->role ?? '-' }}</small>
                            </td>
                            <td class="fw-semibold">{{ $kas->keterangan }}</td>
                            <td class="text-success fw-bold">+Rp {{ number_format($kas->nominal, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <form action="{{ route('dashboard.kas.masuk.destroy', $kas->kas_masuk_id ?? $kas->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Belum ada pencatatan kas masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection