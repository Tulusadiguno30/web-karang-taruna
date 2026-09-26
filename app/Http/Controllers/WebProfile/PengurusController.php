<?php

namespace App\Http\Controllers\WebProfile;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PengurusController extends Controller
{
    // Fungsi bantuan untuk mengecek hak akses
    private function checkAccess()
    {
        $role = strtolower(Auth::user()->role ?? '');
        if (!in_array($role, ['ketua', 'admin', 'sekertaris', 'bendahara'])) {
            abort(403, 'Anda tidak memiliki akses ke menu ini.');
        }
    }

    public function index()
    {
        $this->checkAccess();
        // Menampilkan data diurutkan berdasarkan 'urutan' angka terkecil (ASC)
        $pengurus = Pengurus::orderBy('urutan', 'asc')->get();
        return view('dashboard.web-profile.pengurus.index', compact('pengurus'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        
        $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'urutan'  => 'nullable|integer'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengurus', 'public');
        }

        Pengurus::create([
            'nama'      => $request->nama,
            'jabatan'   => $request->jabatan,
            'foto'      => $fotoPath,
            'urutan'    => $request->urutan ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return back()->with('success', 'Data pengurus berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $pengurus = Pengurus::findOrFail($id);
        
        if ($pengurus->foto) {
            Storage::disk('public')->delete($pengurus->foto);
        }
        $pengurus->delete();

        return back()->with('success', 'Data pengurus berhasil dihapus!');
    }
    // Fungsi Menampilkan Form Edit
    public function edit($id)
    {
        $pengurus = \App\Models\Pengurus::findOrFail($id);
        return view('dashboard.web-profile.pengurus.edit', compact('pengurus'));
    }

    // Fungsi Memproses Perubahan Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Boleh kosong
        ]);

        $pengurus = \App\Models\Pengurus::findOrFail($id);

        // Jika ada foto baru yang diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pengurus->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($pengurus->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pengurus->foto);
            }
            // Simpan foto baru
            $pengurus->foto = $request->file('foto')->store('pengurus', 'public');
        }

        // Simpan perubahan teks
        $pengurus->nama = $request->nama;
        $pengurus->jabatan = $request->jabatan;
        $pengurus->save();

        return redirect()->route('dashboard.web-profile.pengurus.index')
                         ->with('success', 'Data Pengurus berhasil diperbarui!');
    }
}