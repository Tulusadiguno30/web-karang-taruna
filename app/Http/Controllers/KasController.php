<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth; // <-- Pastikan baris ini ada

class KasController extends Controller
{
    // Menampilkan Halaman Kas Masuk
    public function kasMasuk()
    {
        $anggota = Anggota::orderBy('nama', 'asc')->get();
        $kasMasuk = KasMasuk::with('anggota')->latest()->get();

        return view('dashboard.kas.masuk', compact('anggota', 'kasMasuk'));
    }

    // Menyimpan Transaksi Kas Masuk
    public function storeKasMasuk(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'anggota_id' => 'nullable|exists:anggotas,id',
            'keterangan' => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:0',
        ]);

        KasMasuk::create([
            'tanggal'    => $request->tanggal,
            'anggota_id' => $request->anggota_id,
            'keterangan' => $request->keterangan,
            'nominal'    => $request->nominal,
            'user_id'    => Auth::id(), // <-- ID Pengurus yang sedang login dicatat di sini
        ]);

        return redirect()->back()->with('success', 'Transaksi kas masuk berhasil disimpan!');
    }

    // Menghapus Transaksi Kas Masuk / Keluar
    public function destroy($id)
    {
        $kasMasuk = KasMasuk::find($id);
        if ($kasMasuk) {
            $kasMasuk->delete();
            return redirect()->back()->with('success', 'Data kas masuk berhasil dihapus!');
        }

        $kasKeluar = KasKeluar::find($id);
        if ($kasKeluar) {
            $kasKeluar->delete();
            return redirect()->back()->with('success', 'Data kas keluar berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan!');
    }
}