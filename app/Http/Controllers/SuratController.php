<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    // 1. Menampilkan Halaman Utama Menu Surat
    public function index()
    {
        // Mengambil riwayat surat terbaru untuk ditampilkan di tabel bawah
        $riwayatSurat = Surat::latest()->get();
        return view('dashboard.surat.index', compact('riwayatSurat'));
    }

    // Fungsi Internal: Membuat Nomor Surat Otomatis (Cth: 001/KT-0210/X/2026)
    private function generateNomorSurat($jenis_kode)
    {
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        
        $tahun = date('Y');
        $bulan = $bulanRomawi[date('n')];
        
        // Cari urutan surat terakhir di tahun ini
        $lastSurat = Surat::whereYear('created_at', $tahun)->orderBy('id', 'desc')->first();
        
        $urutan = 1;
        if ($lastSurat) {
            // Memecah "001/KT-0210..." untuk mengambil angka "001"
            $lastNomor = explode('/', $lastSurat->nomor_surat)[0];
            $urutan = (int)$lastNomor + 1;
        }

        // Format: 001/KODE/BulanRomawi/Tahun
        $nomorUrut = str_pad($urutan, 3, '0', STR_PAD_LEFT);
        return "{$nomorUrut}/{$jenis_kode}/{$bulan}/{$tahun}";
    }

    // 2. Fungsi Cetak Surat Pengantar KTP / KK
    public function cetakKtp(Request $request)
    {
        $request->validate([
            'nama_warga' => 'required',
            'nik' => 'required|numeric',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'pekerjaan' => 'required',
            'agama' => 'required',
            'keperluan' => 'required'
        ]);

        $nomorSurat = $this->generateNomorSurat('RT02-RW10/KTP');
        $pengurus = Auth::user()->name ?? 'Pengurus KARTAR';

        // Simpan ke riwayat database
        Surat::create([
            'nomor_surat' => $nomorSurat,
            'jenis_surat' => 'Pengantar KTP/KK',
            'judul_atau_nama' => $request->nama_warga . ' (' . $request->keperluan . ')',
            'dicetak_oleh' => $pengurus
        ]);

        $data = $request->all();
        $data['nomor_surat'] = $nomorSurat;

        // Cetak PDF
        $pdf = Pdf::loadView('dashboard.surat.template_ktp', compact('data'))
                  ->setPaper('a4', 'portrait');
                  
        return $pdf->stream('Surat_Pengantar_KTP_' . str_replace(' ', '_', $request->nama_warga) . '.pdf');
    }

    // 3. Fungsi Cetak Surat Edaran / Pemberitahuan
    public function cetakEdaran(Request $request)
    {
        $request->validate([
            'perihal' => 'required',
            'kepada' => 'required',
            'isi_pembuka' => 'required',
            'hari_tanggal' => 'required',
            'waktu' => 'required',
            'tempat' => 'required',
            'isi_penutup' => 'required'
        ]);

        $nomorSurat = $this->generateNomorSurat('RT02-RW10/EDR');
        $pengurus = Auth::user()->name ?? 'Pengurus KARTAR';

        Surat::create([
            'nomor_surat' => $nomorSurat,
            'jenis_surat' => 'Edaran/Pemberitahuan',
            'judul_atau_nama' => 'Perihal: ' . $request->perihal,
            'dicetak_oleh' => $pengurus
        ]);

        $data = $request->all();
        $data['nomor_surat'] = $nomorSurat;

        $pdf = Pdf::loadView('dashboard.surat.template_edaran', compact('data'))
                  ->setPaper('a4', 'portrait');
                  
        return $pdf->stream('Surat_Edaran_' . date('Ymd') . '.pdf');
    }

    // 4. Fungsi Cetak Surat Umum (Bebas)
    public function cetakUmum(Request $request)
    {
        $request->validate([
            'perihal' => 'required',
            'tujuan' => 'required',
            'isi_surat' => 'required'
        ]);

        $nomorSurat = $this->generateNomorSurat('RT02-RW10/UMM');
        $pengurus = Auth::user()->name ?? 'Pengurus KARTAR';

        Surat::create([
            'nomor_surat' => $nomorSurat,
            'jenis_surat' => 'Surat Umum',
            'judul_atau_nama' => 'Tujuan: ' . $request->tujuan,
            'dicetak_oleh' => $pengurus
        ]);

        $data = $request->all();
        $data['nomor_surat'] = $nomorSurat;
        
        // Mempertahankan baris baru (enter) yang diketik user di textarea
        $data['isi_surat'] = nl2br(e($request->isi_surat));

        $pdf = Pdf::loadView('dashboard.surat.template_umum', compact('data'))
                  ->setPaper('a4', 'portrait');
                  
        return $pdf->stream('Surat_Umum_' . date('Ymd') . '.pdf');
    }

    // 5. Hapus Riwayat Surat
    public function destroy($id)
    {
        Surat::findOrFail($id)->delete();
        return back()->with('success', 'Riwayat surat berhasil dihapus dari arsip!');
    }
}