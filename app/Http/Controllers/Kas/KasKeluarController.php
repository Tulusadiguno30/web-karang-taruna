<?php

namespace App\Http\Controllers\Kas;

use App\Http\Controllers\Controller;
use App\Models\KasKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KasKeluarController extends Controller
{
    public function index()
    {
        $kasKeluars = KasKeluar::latest()->get();
        return view('dashboard.kas.keluar.index', compact('kasKeluars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'bukti_nota' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('bukti_nota')) {
            $path = $request->file('bukti_nota')->store('kas-keluar', 'public');
        }

        KasKeluar::create([
            'user_id'    => auth()->id(),
            'keterangan' => $request->keterangan,
            'nominal'    => $request->nominal,
            'tanggal'    => $request->tanggal,
            'bukti_nota' => $path,
        ]);

        return redirect()->route('dashboard.kas.keluar.index')->with('success', 'Pengeluaran kas berhasil dicatat!');
    }

    public function destroy($id)
    {
        $kas = KasKeluar::findOrFail($id);
        if ($kas->bukti_nota) {
            Storage::disk('public')->delete($kas->bukti_nota);
        }
        $kas->delete();

        return redirect()->route('dashboard.kas.keluar.index')->with('success', 'Data kas keluar berhasil dihapus!');
    }
}