@extends('layouts.dashboard')

@section('title', 'Pencatatan Kas Masuk')

@section('content')
    <h2 class="fw-bold mb-4">Pencatatan Kas Masuk</h2>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- FORM TAMBAH KAS MASUK -->
        <div class="col-md-5">
            <div class="card p-4 border-0 shadow-sm rounded-4">
                <h5 class="fw-bold text-success mb-4"><i class="bi bi-plus-circle me-1"></i> Tambah Kas Masuk</h5>
                
                <form action="{{ route('dashboard.kas.masuk.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Tanggal Transaksi</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- DROPDOWN PILIH ANGGOTA -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Pilih Anggota</label>
                        <select name="anggota_id" class="form-select">
                            <option value="">-- Pilih Anggota (Opsional) --</option>
                            @foreach($anggota ?? [] as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->role ?? 'Anggota' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Keterangan / Sumber Dana</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Iuran Bulanan / Kas Rutin" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small">Nominal (Rp)</label>
                        <input type="number" name="nominal" class="form-control" placeholder="50000" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 rounded-3">
                        <i class="bi bi-box-arrow-in-down-right me-1"></i> Simpan Transaksi
                    </button>
                </form>
            </div>
        </div>

        <!-- TABEL RIWAYAT KAS MASUK -->
        <div class="col-md-7">
            <div class="card p-4 border-0 shadow-sm rounded-4">
                <h5 class="fw-bold text-primary mb-4"><i class="bi bi-clock-history me-1"></i> Riwayat Kas Masuk</h5>
                
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama / Keterangan</th>
                                <th>Nominal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kasMasuk ?? [] as $kas)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d/m/Y') }}</td>
                                <td>
                                    @if($kas->anggota)
                                        <span class="badge bg-primary mb-1">{{ $kas->anggota->nama }}</span><br>
                                    @endif
                                    <span class="text-muted small">{{ $kas->keterangan }}</span>
                                </td>
                                <td class="text-success fw-bold">+Rp {{ number_format($kas->nominal, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('dashboard.kas.destroy', $kas->id) }}" method="POST" onsubmit="return confirm('Hapus data transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm rounded-circle"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Belum ada data kas masuk.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection