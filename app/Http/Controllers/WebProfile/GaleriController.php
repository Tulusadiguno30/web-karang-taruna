<?php

namespace App\Http\Controllers\WebProfile;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
  public function index()
{
    $galeris = \App\Models\Galeri::latest()->get();
    return view('dashboard.web-profile.galeri.index', compact('galeris'));
}

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto'      => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $path = $request->file('foto')->store('galeri', 'public');

        Galeri::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto'      => $path,
        ]);

        return redirect()->route('dashboard.web-profile.galeri.index')->with('success', 'Foto kegiatan berhasil ditambahkan ke galeri!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        if ($galeri->foto) {
            Storage::disk('public')->delete($galeri->foto);
        }
        $galeri->delete();

        return redirect()->route('dashboard.web-profile.galeri.index')->with('success', 'Foto galeri berhasil dihapus!');
    }
    public function edit($id)
    {
        // Sesuaikan 'id' dengan primary key tabel galeri kamu jika bukan 'id'
        $galeri = Galeri::findOrFail($id); 
        return view('dashboard.web-profile.galeri.edit', compact('galeri'));
    }

    // 2. Fungsi Memproses Perubahan Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'kategori'   => 'required|string',
            'event_date' => 'nullable|date',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Foto boleh kosong jika tidak ingin ganti
        ]);

        $galeri = Galeri::findOrFail($id);

        // Jika user mengunggah foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage agar memori tidak penuh
            if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
                Storage::disk('public')->delete($galeri->foto);
            }
            
            // Simpan foto baru
            $galeri->foto = $request->file('foto')->store('galeri', 'public');
        }

        // Update data teks
        $galeri->judul      = $request->judul;
        $galeri->kategori   = $request->kategori;
        $galeri->event_date = $request->event_date;
        $galeri->save();

        return redirect()->route('dashboard.web-profile.galeri.index')
                         ->with('success', 'Data Galeri berhasil diperbarui!');
    }
}