<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::latest()->get();
        return view('dashboard.anggota.index', compact('anggotas'));
    }

   public function store(Request $request)
{
    $request->validate([
        'nama'          => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P', // <-- Pastikan aturannya 'in:L,P'
        'email'         => 'required|email|unique:anggotas,email',
        'kontak'        => 'required|string|max:20',
        'role'          => 'required|string',
        'keahlian'      => 'nullable|string|max:255',
    ]);

    // Proses simpan data...
        Anggota::create($request->all());

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Anggota::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Anggota berhasil dihapus!');
    }
    // Fungsi Menampilkan Form Edit
    public function edit($id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        return view('dashboard.anggota.edit', compact('anggota'));
    }

    // Fungsi Memproses Perubahan Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'email'         => 'nullable|email|unique:anggotas,email,' . $id, // Email unique, kecuali milik sendiri
            'gmail'         => 'nullable|email',
            'no_tlpn'       => 'nullable|string|max:20',
            'role'          => 'required|string',
            'keahlian'      => 'nullable|string|max:255',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        $anggota = \App\Models\Anggota::findOrFail($id);

        // Jika upload foto baru
        if ($request->hasFile('foto')) {
            if ($anggota->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($anggota->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($anggota->foto);
            }
            $anggota->foto = $request->file('foto')->store('anggota', 'public');
        }

        // Simpan data
        $anggota->nama = $request->nama;
        $anggota->jenis_kelamin = $request->jenis_kelamin;
        $anggota->email = $request->email;
        $anggota->gmail = $request->gmail;
        $anggota->no_tlpn = $request->no_tlpn;
        $anggota->role = $request->role;
        $anggota->keahlian = $request->keahlian;
        $anggota->save();

        return redirect()->route('dashboard.anggota.index') // Sesuaikan nama route index kamu
                         ->with('success', 'Data Anggota berhasil diperbarui!');
    }
}