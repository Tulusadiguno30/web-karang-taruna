<?php

namespace App\Http\Controllers\Kas;

use App\Http\Controllers\Controller;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportKasController extends Controller
{
    public function index()
    {
        $kasMasuk = KasMasuk::with('anggota')->latest()->get();
        $kasKeluar = KasKeluar::latest()->get();

        $totalMasuk = $kasMasuk->sum('nominal');
        $totalKeluar = $kasKeluar->sum('nominal');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        return view('dashboard.kas.report.index', compact('kasMasuk', 'kasKeluar', 'totalMasuk', 'totalKeluar', 'saldoAkhir'));
    }

    public function downloadPdf()
    {
        $kasMasuk = KasMasuk::with('anggota')->latest()->get();
        $kasKeluar = KasKeluar::latest()->get();

        $totalMasuk = $kasMasuk->sum('nominal');
        $totalKeluar = $kasKeluar->sum('nominal');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        $pdf = Pdf::loadView('dashboard.kas.report.pdf', compact('kasMasuk', 'kasKeluar', 'totalMasuk', 'totalKeluar', 'saldoAkhir'));
        return $pdf->download('Laporan_Keuangan_Kartar_0210_' . date('Y-m-d') . '.pdf');
    }
}