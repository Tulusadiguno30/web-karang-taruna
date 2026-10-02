<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalRonda;
use App\Models\WargaRonda;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class JadwalRondaController extends Controller
{
    // 1. Menampilkan Halaman Menu
    public function index()
    {
        $riwayatJadwal = JadwalRonda::select('periode')->distinct()->orderBy('created_at', 'desc')->get();
        return view('dashboard.jadwal-ronda.index', compact('riwayatJadwal'));
    }

    // 2. Membuat Jadwal Berurutan Tetap (Tidak Diacak)
    public function generate(Request $request)
    {
        $request->validate([
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);

        // Ambil hari Sabtu saja
        $tanggalSabtu = [];
        $currentDate = $mulai->copy();
        
        while ($currentDate <= $selesai) {
            if ($currentDate->isSaturday()) {
                $tanggalSabtu[] = $currentDate->format('Y-m-d');
            }
            $currentDate->addDay();
        }

        // Batasi 12 hari Sabtu agar PDF rapi dan presisi muat di A4
        $tanggalSabtu = array_slice($tanggalSabtu, 0, 12);

        if (empty($tanggalSabtu)) {
            return back()->with('error', 'Tidak ada hari Sabtu pada rentang tanggal tersebut.');
        }

        // Ambil data warga secara BERURUTAN (ID Ascending)
        $warga = WargaRonda::where('status_aktif', true)->orderBy('id', 'asc')->get();

        if ($warga->isEmpty()) {
            return back()->with('error', 'Data warga kosong. Pastikan Seeder sudah dijalankan.');
        }

        $periode = $mulai->translatedFormat('F') . ' - ' . $selesai->translatedFormat('F Y');
        
        // Hapus data periode lama jika sudah ada
        JadwalRonda::where('periode', $periode)->delete();

        // Kunci pasti 8 orang per kelompok agar pas dengan 12 grup (96 / 8 = 12)
        $wargaChunks = $warga->chunk(8)->values();
        
        foreach ($tanggalSabtu as $index => $tanggal) {
            if (isset($wargaChunks[$index])) {
                foreach ($wargaChunks[$index] as $w) {
                    JadwalRonda::create([
                        'periode'       => $periode,
                        'tanggal_ronda' => $tanggal,
                        'warga_id'      => $w->id,
                    ]);
                }
            }
        }

        return back()->with('success', 'Jadwal Ronda berhasil dibuat dengan urutan tetap!');
    }

    // 3. Menghapus Jadwal
    public function destroyPeriode($periode)
    {
        JadwalRonda::where('periode', $periode)->delete();
        return back()->with('success', 'Jadwal periode ' . $periode . ' berhasil dihapus!');
    }

    // 4. Cetak PDF
    public function cetakPdf($periode)
    {
        $jadwal = JadwalRonda::with('warga')
            ->where('periode', $periode)
            ->orderBy('tanggal_ronda')
            ->get()
            ->groupBy('tanggal_ronda');

        $pdf = Pdf::loadView('dashboard.jadwal-ronda.pdf', compact('jadwal', 'periode'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Jadwal-Ronda-' . $periode . '.pdf');
    }
}