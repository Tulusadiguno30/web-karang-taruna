@extends('layouts.dashboard')

@section('title', 'Layanan Surat RT/RW')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4 pb-2 border-bottom">
    <h2 class="fw-bold">Layanan e-Surat</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- KOTAK PILIHAN SURAT -->
<div class="row g-4 mb-5">
    <!-- Surat Pengantar KTP -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 transition-all" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalKTP">
            <div class="bg-primary text-white rounded-circle d-inline-flex p-3 mx-auto mb-3 shadow-sm">
                <i class="bi bi-person-vcard fs-2"></i>
            </div>
            <h5 class="fw-bold">Pengantar KTP/KK</h5>
            <p class="text-muted small">Surat pengantar standar untuk urusan administrasi kependudukan warga.</p>
        </div>
    </div>

    <!-- Surat Edaran -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 transition-all" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalEdaran">
            <div class="bg-warning text-dark rounded-circle d-inline-flex p-3 mx-auto mb-3 shadow-sm">
                <i class="bi bi-megaphone fs-2"></i>
            </div>
            <h5 class="fw-bold">Surat Edaran</h5>
            <p class="text-muted small">Sebarkan informasi, undangan kerja bakti, atau pengumuman ke warga.</p>
        </div>
    </div>

    <!-- Surat Umum -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 transition-all" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalUmum">
            <div class="bg-success text-white rounded-circle d-inline-flex p-3 mx-auto mb-3 shadow-sm">
                <i class="bi bi-envelope-paper fs-2"></i>
            </div>
            <h5 class="fw-bold">Surat Umum (Bebas)</h5>
            <p class="text-muted small">Template fleksibel untuk surat undangan eksternal atau surat dinas lainnya.</p>
        </div>
    </div>
</div>

<!-- TABEL RIWAYAT SURAT -->
<div class="card border-0 shadow-sm rounded-4 p-4">
    <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-clock-history me-2"></i>Riwayat Surat Keluar</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No. Surat</th>
                    <th>Jenis Surat</th>
                    <th>Perihal / Pemohon</th>
                    <th>Dicetak Oleh</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatSurat as $surat)
                <tr>
                    <td class="fw-bold">{{ $surat->nomor_surat }}</td>
                    <td><span class="badge bg-secondary">{{ $surat->jenis_surat }}</span></td>
                    <td>{{ $surat->judul_atau_nama }}</td>
                    <td><i class="bi bi-person me-1"></i>{{ $surat->dicetak_oleh }}</td>
                    <td>{{ $surat->created_at->format('d M Y') }}</td>
                    <td>
                        <form action="{{ route('dashboard.surat.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat surat ini? (File PDF yang sudah dicetak tidak akan terhapus, hanya riwayatnya saja)')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus Riwayat"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada surat yang dicetak.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ================= MODAL FORM SURAT ================= -->

<!-- Modal KTP -->
<div class="modal fade" id="modalKTP" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Buat Surat Pengantar KTP/KK</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <!-- target="_blank" agar PDF terbuka di tab baru tanpa menutup web -->
            <form action="{{ route('dashboard.surat.cetak.ktp') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Lengkap Warga</label>
                            <input type="text" name="nama_warga" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">NIK</label>
                            <input type="number" name="nik" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Agama</label>
                            <select name="agama" class="form-select" required>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Keperluan Surat</label>
                            <input type="text" name="keperluan" class="form-control" placeholder="Contoh: Pembuatan KTP Baru / Perpanjangan SKCK" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="bi bi-printer me-2"></i>Cetak Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edaran -->
<div class="modal fade" id="modalEdaran" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold">Buat Surat Edaran / Pemberitahuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dashboard.surat.cetak.edaran') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Perihal Surat</label>
                            <input type="text" name="perihal" class="form-control" placeholder="Contoh: Undangan Kerja Bakti" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kepada Yth.</label>
                            <input type="text" name="kepada" class="form-control" placeholder="Contoh: Seluruh Warga RT.002" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Paragraf Pembuka</label>
                            <textarea name="isi_pembuka" class="form-control" rows="2" placeholder="Dengan hormat, sehubungan dengan..." required></textarea>
                        </div>
                        <!-- Rincian Acara -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Hari, Tanggal</label>
                            <input type="text" name="hari_tanggal" class="form-control" placeholder="Minggu, 15 Okt 2026" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Waktu (Pukul)</label>
                            <input type="text" name="waktu" class="form-control" placeholder="08.00 - Selesai" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Tempat</label>
                            <input type="text" name="tempat" class="form-control" placeholder="Fasum RT.002" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Paragraf Penutup</label>
                            <textarea name="isi_penutup" class="form-control" rows="2" placeholder="Demikian surat ini kami sampaikan..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-warning text-dark rounded-pill px-4 fw-bold"><i class="bi bi-printer me-2"></i>Cetak Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Umum -->
<div class="modal fade" id="modalUmum" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Buat Surat Umum (Bebas)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dashboard.surat.cetak.umum') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tujuan Surat (Kepada Yth.)</label>
                        <input type="text" name="tujuan" class="form-control" placeholder="Contoh: Kepala Desa Satria Jaya" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Perihal / Hal</label>
                        <input type="text" name="perihal" class="form-control" placeholder="Contoh: Permohonan Izin Kegiatan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Isi Surat Lengkap</label>
                        <textarea name="isi_surat" class="form-control" rows="8" placeholder="Ketik isi surat di sini. Tekan Enter untuk paragraf baru..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold"><i class="bi bi-printer me-2"></i>Cetak Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection