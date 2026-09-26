<?php

namespace App\Http\Controllers\Kas;

use App\Http\Controllers\Controller;
use App\Models\KasMasuk;
use App\Models\Anggota; // Pastikan baris ini HANYA ada 1 kali
use Illuminate\Http\Request;

class KasMasukController extends Controller
{
    public function index()
    {
        $kasMasuks = KasMasuk::with('anggota')->latest()->get();
        $anggotas = Anggota::orderBy('nama', 'asc')->get();

        return view('dashboard.kas.masuk.index', compact('kasMasuks', 'anggotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'nominal'    => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'required|string',
            'bukti_nota' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('bukti_nota')) {
            $path = $request->file('bukti_nota')->store('bukti_nota', 'public');
        }

        KasMasuk::create([
            'anggota_id' => $request->anggota_id,
            'nominal'    => $request->nominal,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
            'bukti_nota' => $path,
        ]);

        return redirect()->back()->with('success', 'Kas masuk berhasil dicatat!');
    }

    public function destroy($id)
    {
        $kas = KasMasuk::findOrFail($id);
        $kas->delete();

        return redirect()->back()->with('success', 'Data kas masuk berhasil dihapus!');
    }
}