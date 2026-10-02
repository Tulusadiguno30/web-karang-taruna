<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\Kas\KasKeluarController;
use App\Http\Controllers\Kas\ReportKasController;
use App\Http\Controllers\WebProfile\GaleriController;
use App\Http\Controllers\WebProfile\ProkerController;
use App\Http\Controllers\WebProfile\PengurusController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalRondaController;

// ==========================================
// 1. Landing Page Publik
// ==========================================
Route::get('/', [PublicController::class, 'index'])->name('public.index');
Route::post('/aspirasi/kirim', [PublicController::class, 'storeAspirasi'])->name('public.aspirasi.store');
Route::get('/struktur-organisasi', [PublicController::class, 'struktur'])->name('public.struktur');
// ==========================================
// 2. Auth Routes
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// 3. Dashboard Internal Pengurus
// ==========================================
Route::middleware(['auth'])->prefix('dashboard')->as('dashboard.')->group(function () {

    // --- Dashboard Utama ---
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/admin-home', function () {
        return redirect()->route('dashboard.index');
    })->name('admin.dashboard');

    // --- Data Anggota & Role ---
    Route::resource('anggota', AnggotaController::class);
    Route::get('role', function() {
        return view('auth.dashboard');
    })->name('role.index');
    Route::get('anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');

    // --- Modul Kas Keuangan ---
    Route::prefix('kas')->as('kas.')->group(function () {
        Route::get('report', [ReportKasController::class, 'index'])->name('report.index');
        Route::get('report/pdf', [ReportKasController::class, 'downloadPdf'])->name('report.pdf');

        Route::get('masuk', [KasController::class, 'kasMasuk'])->name('masuk.index');
        Route::post('masuk', [KasController::class, 'storeKasMasuk'])->name('masuk.store');

        Route::resource('keluar', KasKeluarController::class)->names([
            'index' => 'keluar.index'
        ])->except(['create', 'edit', 'show', 'update']);

        Route::delete('{id}', [KasController::class, 'destroy'])->name('destroy');
    });

    // --- Modul Web Profile (Proker, Galeri, Pengurus) ---
    Route::prefix('web-profile')->as('web-profile.')->group(function () {
        // 1. Proker
        Route::resource('proker', ProkerController::class)->except(['create', 'edit', 'show']);
        Route::patch('proker/{id}/status', [ProkerController::class, 'updateStatus'])->name('proker.updateStatus');
        Route::get('proker/{id}/edit', [ProkerController::class, 'edit'])->name('proker.edit');
        Route::put('proker/{id}', [ProkerController::class, 'update'])->name('proker.update');
        // 2. Galeri
        Route::resource('galeri', GaleriController::class)->except(['create', 'edit', 'show', 'update']);
        // Hapus 'edit' dan 'update' dari dalam kurung except
        Route::resource('galeri', GaleriController::class)->except(['create', 'show']);
       
        // 3. Struktur Organisasi / Pengurus
        Route::get('pengurus', [PengurusController::class, 'index'])->name('pengurus.index');
        Route::post('pengurus', [PengurusController::class, 'store'])->name('pengurus.store');
        Route::delete('pengurus/{id}', [PengurusController::class, 'destroy'])->name('pengurus.destroy');
        Route::get('pengurus/{id}/edit', [PengurusController::class, 'edit'])->name('pengurus.edit');
        Route::put('pengurus/{id}', [PengurusController::class, 'update'])->name('pengurus.update');
    });

    // --- Modul Aspirasi Warga (Internal Pengurus) ---
    Route::resource('aspirasi', AspirasiController::class)->only(['index', 'destroy']);
    Route::patch('aspirasi/{id}/status', [AspirasiController::class, 'updateStatus'])->name('aspirasi.updateStatus');
    Route::get('/struktur-organisasi', [PublicController::class, 'struktur'])->name('public.struktur');
    // Menu Jadwal Ronda
        Route::get('jadwal-ronda', [\App\Http\Controllers\JadwalRondaController::class, 'index'])->name('jadwal-ronda.index');
        Route::post('jadwal-ronda/generate', [\App\Http\Controllers\JadwalRondaController::class, 'generate'])->name('jadwal-ronda.generate');
        Route::delete('jadwal-ronda/hapus/{periode}', [\App\Http\Controllers\JadwalRondaController::class, 'destroyPeriode'])->name('jadwal-ronda.destroy-periode');
        Route::get('jadwal-ronda/pdf/{periode}', [\App\Http\Controllers\JadwalRondaController::class, 'cetakPdf'])->name('jadwal-ronda.pdf');
    // 4. Modul Layanan Surat Otomatis
    // ==========================================
    Route::prefix('surat')->as('surat.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SuratController::class, 'index'])->name('index');
        
        // Rute untuk cetak PDF berdasarkan jenis
        Route::post('/cetak/umum', [\App\Http\Controllers\SuratController::class, 'cetakUmum'])->name('cetak.umum');
        Route::post('/cetak/edaran', [\App\Http\Controllers\SuratController::class, 'cetakEdaran'])->name('cetak.edaran');
        Route::post('/cetak/ktp', [\App\Http\Controllers\SuratController::class, 'cetakKtp'])->name('cetak.ktp');
        
        // Hapus riwayat surat
        Route::delete('/{id}', [\App\Http\Controllers\SuratController::class, 'destroy'])->name('destroy');
    });
  });