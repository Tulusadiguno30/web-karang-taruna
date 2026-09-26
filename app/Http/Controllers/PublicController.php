<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Pengurus; // Tambahkan ini!
use App\Models\Galeri;
use App\Models\Proker;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\Aspirasi;

class PublicController extends Controller
{
    public function index()
    {
        // 1. Daftar urutan jabatan persis seperti di form (image_0c753c.png)
        $urutanJabatan = [
            'Pembina',
            'Ketua',
            'Wakil Ketua',
            'Sekretaris',
            'Bendahara',
            'PDD (Publikasi, Dekorasi & Dokumentasi)',
            'Humas',
            'Sie Konsumsi',
            'Sie Perlengkapan',
            'Sie Keamanan',
            'Korlap',
            'Sie Kebersihan'
        ];

        // 2. Tarik data, urutkan, lalu saring HANYA 1 ORANG PER JABATAN
        $officers = \App\Models\Pengurus::where('is_active', 1)
            ->whereIn('jabatan', $urutanJabatan) // Ambil yang jabatannya ada di daftar atas
            ->orderByRaw("FIELD(jabatan, '" . implode("','", $urutanJabatan) . "')") // Urutkan hierarkinya
            ->orderBy('id', 'asc') // Prioritaskan orang yang paling pertama diinput
            ->get()
            ->unique('jabatan'); // INI KUNCINYA: Otomatis membuang duplikat jabatan, menyisakan 1 perwakilan saja!

        // Total anggota untuk profil (misal dari tabel anggotas)
        $totalAnggota = \App\Models\Anggota::count(); 

        // 3. Data Galeri & Proker
        $galleries = \App\Models\Galeri::latest()->take(6)->get();
        $programs = \App\Models\Proker::latest()->take(6)->get();

        // 4. Data Keuangan
        $totalIn = \App\Models\KasMasuk::sum('nominal');
        $totalOut = \App\Models\KasKeluar::sum('nominal');
        $balance = $totalIn - $totalOut;

        return view('welcome', compact('officers', 'totalAnggota', 'galleries', 'programs', 'totalIn', 'totalOut', 'balance'));
    }
    public function struktur()
    {
        // Ambil semua pengurus aktif
        $officers = \App\Models\Pengurus::where('is_active', 1)
            ->orderByRaw("FIELD(jabatan, 'Pembina', 'Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'PDD (Publikasi, Dekorasi & Dokumentasi)', 'Humas', 'Sie Konsumsi', 'Sie Perlengkapan', 'Sie Keamanan', 'Korlap', 'Sie Kebersihan', 'Anggota')")
            ->get();
            
        // Panggil file resources/views/public/struktur.blade.php
        return view('public.struktur', compact('officers'));
    }
   public function storeAspirasi(Request $request)
    {
        // Validasi inputan dari form
        $request->validate([
            'nama'  => 'required|string|max:255',
            'rt_rw' => 'required|string|max:50',
            'no_wa' => 'required|string|max:20',
            'pesan' => 'required|string',
        ]);

        // Gabungkan RT/RW dan No WA untuk dimasukkan ke kolom 'kontak'
        $kontakGabungan = 'RT: ' . $request->rt_rw . ' | WA: ' . $request->no_wa;

        // Simpan data ke tabel aspirasis sesuai nama kolom di database
        \App\Models\Aspirasi::create([
            'nama_pengirim' => $request->nama,
            'kontak'        => $kontakGabungan,
            'pesan'         => $request->pesan,
            'status'        => 'belum_dibaca', // Set status default
        ]);

        // Kembalikan ke halaman depan dengan pesan sukses
        return redirect()->route('public.index')->with('success', 'Terima kasih! Aspirasi atau masukan Anda berhasil dikirim kepada pengurus.');
    }
}