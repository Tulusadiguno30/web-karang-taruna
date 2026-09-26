<?php

namespace App\Http\Controllers\WebProfile;

use App\Http\Controllers\Controller;
use App\Models\Proker;
use Illuminate\Http\Request;

class ProkerController extends Controller
{
    public function index()
    {
        $prokers = Proker::latest()->get();
        return view('dashboard.web-profile.proker.index', compact('prokers'));
    }

  public function store(Request $request)
{
    $request->validate([
        'nama_proker'         => 'required|string|max:255',
        'deskripsi'           => 'required|string',
        'status'              => 'required|string',
        'tanggal_pelaksanaan' => 'required|date',
    ]);

    \App\Models\Proker::create([
        'nama_proker'         => $request->nama_proker,
        'deskripsi'           => $request->deskripsi,
        'status'              => strtolower($request->status), // Ubah jadi huruf kecil karena tipe ENUM di database huruf kecil
        'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
    ]);

    return redirect()->back()->with('success', 'Program kerja berhasil ditambahkan!');
}
    public function destroy($id)
    {
        $proker = Proker::findOrFail($id);
        $proker->delete();

        return redirect()->route('dashboard.web-profile.proker.index')->with('success', 'Program kerja berhasil dihapus!');
    }
    // 1. Fungsi Menampilkan Form Edit
    public function edit($id)
    {
        $proker = \App\Models\Proker::findOrFail($id);
        return view('dashboard.web-profile.proker.edit', compact('proker'));
    }

    // 2. Fungsi Memproses Perubahan Data
    public function update(Request $request, $id)
    {
        // Validasi disesuaikan dengan nama input dari form
        $request->validate([
            'nama_proker'         => 'required|string|max:255',
            'deskripsi'           => 'required|string',
            'tanggal_pelaksanaan' => 'required|date',
            'status'              => 'required|in:rencana,berjalan,selesai',
        ]);

        $proker = \App\Models\Proker::findOrFail($id);
        
        // Simpan perubahan ke database
        $proker->nama_proker = $request->nama_proker;
        $proker->deskripsi = $request->deskripsi;
        $proker->tanggal_pelaksanaan = $request->tanggal_pelaksanaan;
        $proker->status = $request->status;
        $proker->save();

        return redirect()->route('dashboard.web-profile.proker.index')
                         ->with('success', 'Program Kerja berhasil diperbarui!');
    }
}