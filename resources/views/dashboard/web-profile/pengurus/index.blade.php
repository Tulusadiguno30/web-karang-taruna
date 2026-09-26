@extends('layouts.dashboard')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="row g-4">
    <!-- Form Tambah (Kiri) -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Pengurus</h5>
            
            <form action="{{ route('dashboard.web-profile.pengurus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" required placeholder="Contoh: Budi Santoso">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="jabatan" class="form-control" required placeholder="Contoh: Ketua Umum">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Urutan Tampil (Opsional)</label>
                    <input type="number" name="urutan" class="form-control" value="0" min="0">
                    <small class="text-muted" style="font-size: 0.75rem;">Angka lebih kecil akan tampil paling atas/awal.</small>
                </div>

                <!-- Input File & JavaScript Preview -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Foto Pengurus (Opsional, Max 2MB)</label>
                    <input type="file" name="foto" id="fotoPengurus" class="form-control" accept=".jpg,.jpeg,.png" onchange="previewFoto()">
                    
                    <!-- Kotak Preview Foto -->
                    <div class="mt-3 text-center d-none" id="previewContainer">
                        <img id="imgPreview" src="" alt="Preview" class="img-thumbnail rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        <div class="small text-success mt-1">Preview Foto</div>
                    </div>
                </div>

                <!-- Toggle / Switch Aktif -->
                <div class="form-check form-switch mb-4 mt-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" checked value="1">
                    <label class="form-check-label small fw-bold text-success" for="is_active">Status Aktif</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan Data
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Data Pengurus (Kanan) -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-diagram-3-fill text-primary me-2"></i>Daftar Pengurus Karang Taruna</h5>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 py-2">
                    {{ session('success') }}
                    <button type="button" class="btn-close pb-2" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Urutan</th>
                            <th>Profil</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengurus ?? [] as $item)
                        <tr>
                            <td class="fw-bold text-center">{{ $item->urutan }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="rounded-circle me-3" style="width:40px; height:40px; object-fit:cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center me-3 text-white fw-bold" style="width:40px; height:40px;">
                                            {{ substr($item->nama, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="fw-bold">{{ $item->nama }}</span>
                                </div>
                            </td>
                            <td>{{ $item->jabatan }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success rounded-pill px-3">Aktif</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('dashboard.web-profile.pengurus.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus pengurus ini?')">
                                    <a href="{{ route('dashboard.web-profile.pengurus.edit', $item->id ?? $item->pengurus_id) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="Edit">
    <i class="bi bi-pencil"></i> Edit
</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data pengurus yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Script JavaScript untuk Image Preview -->
<script>
    function previewFoto() {
        const fileInput = document.getElementById('fotoPengurus');
        const previewContainer = document.getElementById('previewContainer');
        const imgPreview = document.getElementById('imgPreview');

        const file = fileInput.files[0];
        if (file) {
            // Cek jika ukuran file lebih dari 2MB (2 * 1024 * 1024 byte)
            if(file.size > 2097152) {
                alert('Ukuran foto maksimal 2MB!');
                fileInput.value = ''; // Reset input
                previewContainer.classList.add('d-none');
                return;
            }

            // Membaca dan menampilkan gambar
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                previewContainer.classList.remove('d-none'); // Tampilkan kotak preview
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none'); // Sembunyikan jika dibatalkan
        }
    }
</script>
@endsection