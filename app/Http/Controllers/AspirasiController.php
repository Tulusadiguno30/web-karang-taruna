<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index()
    {
        $aspirasis = Aspirasi::latest()->get();
        return view('dashboard.aspirasi.index', compact('aspirasis'));
    }

    public function updateStatus(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update(['status' => $request->status]);

        return redirect()->route('dashboard.aspirasi.index')->with('success', 'Status aspirasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Aspirasi::destroy($id);
        return redirect()->route('dashboard.aspirasi.index')->with('success', 'Pesan aspirasi berhasil dihapus!');
    }
}