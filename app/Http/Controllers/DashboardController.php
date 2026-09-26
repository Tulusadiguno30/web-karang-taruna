<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\Proker;
use App\Models\Pengurus;
use App\Models\Galeri;
use App\Models\Aspirasi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $role = strtolower(Auth::user()->role ?? 'anggota');

        $data = match($role) {
            'ketua'      => $this->dataKetua(),
            'admin'      => $this->dataAdmin(),
            'sekretaris' => $this->dataSekretaris(),
            'bendahara'  => $this->dataBendahara(),
            default      => $this->dataAnggota(),
        };

        return view('dashboard.index', compact('data', 'role'));
    }

    private function getTransaksiTerbaru($limit = 8)
    {
        $masuk = KasMasuk::latest()->take($limit)->get()->map(function($item) {
            $item->jenis = 'masuk';
            $item->teks = $item->keterangan ?? $item->sumber ?? '-';
            $item->waktu = $item->tanggal ?? $item->created_at;
            return $item;
        });

        $keluar = KasKeluar::latest()->take($limit)->get()->map(function($item) {
            $item->jenis = 'keluar';
            $item->teks = $item->keterangan ?? $item->tujuan ?? '-';
            $item->waktu = $item->tanggal ?? $item->created_at;
            return $item;
        });

        return $masuk->concat($keluar)->sortByDesc('waktu')->take($limit);
    }

    private function dataKetua(): array 
    {
        return [
            'total_anggota' => User::where('role', 'anggota')->count(),
            'saldo_kas' => KasMasuk::sum('nominal') - KasKeluar::sum('nominal'),
            'kas_masuk_bulan' => KasMasuk::whereMonth('created_at', now()->month)->sum('nominal'),
            'kas_keluar_bulan' => KasKeluar::whereMonth('created_at', now()->month)->sum('nominal'),
            'proker_berjalan' => Proker::where('status', 'Berjalan')->count(),
            'aspirasi_baru' => Aspirasi::where('status', 'belum_dibaca')->count(),
            'transaksi' => $this->getTransaksiTerbaru(8)
        ];
    }

    private function dataAdmin(): array 
    {
        return [
            'total_user' => User::count(),
            'pengurus_aktif' => Pengurus::where('is_active', true)->count(),
            'total_galeri' => Galeri::count(),
            'proker_berjalan' => Proker::where('status', 'Berjalan')->count()
        ];
    }

    private function dataSekretaris(): array 
    {
        return [
            'kas_masuk_bulan' => KasMasuk::whereMonth('created_at', now()->month)->sum('nominal'),
            'kas_keluar_bulan' => KasKeluar::whereMonth('created_at', now()->month)->sum('nominal'),
            'saldo_kas' => KasMasuk::sum('nominal') - KasKeluar::sum('nominal'),
            'aspirasi_baru' => Aspirasi::where('status', 'belum_dibaca')->count(),
            'aspirasi_terbaru' => Aspirasi::latest()->take(5)->get()
        ];
    }

    private function dataBendahara(): array 
    {
        $masukBulan = KasMasuk::whereMonth('created_at', now()->month)->count();
        $keluarBulan = KasKeluar::whereMonth('created_at', now()->month)->count();

        return [
            'kas_masuk_bulan' => KasMasuk::whereMonth('created_at', now()->month)->sum('nominal'),
            'kas_keluar_bulan' => KasKeluar::whereMonth('created_at', now()->month)->sum('nominal'),
            'saldo_kas' => KasMasuk::sum('nominal') - KasKeluar::sum('nominal'),
            'total_transaksi' => $masukBulan + $keluarBulan,
            'transaksi' => $this->getTransaksiTerbaru(5)
        ];
    }

    private function dataAnggota(): array 
    {
        return [
            'total_masuk' => KasMasuk::sum('nominal'),
            'total_keluar' => KasKeluar::sum('nominal'),
            'saldo_kas' => KasMasuk::sum('nominal') - KasKeluar::sum('nominal')
        ];
    }
}