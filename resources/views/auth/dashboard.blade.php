@extends('layouts.sidebar')

@section('title', 'User Role - KARTAR 0210')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4 pb-2 border-bottom">
        <h2 class="fw-bold">Manajemen User Role</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold text-primary mb-4"><i class="bi bi-person-badge me-2"></i>Hak Akses & Role Pengguna</h5>
        
        <p class="text-muted">
            Halaman ini digunakan untuk melihat atau mengatur role dari setiap anggota Karang Taruna.
        </p>

        <!-- Pesan Sementara (Bisa kamu ganti dengan tabel role nanti) -->
        <div class="alert alert-info border-0 shadow-sm rounded-3 mt-2">
            <i class="bi bi-info-circle-fill me-2"></i> 
            <strong>Info:</strong> Fitur manajemen Role sedang dalam tahap penyesuaian tampilan.
        </div>
        
        <!-- Nanti tabel atau form role-nya bisa kamu masukkan di sini -->
        
    </div>
@endsection