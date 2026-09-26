<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = User::with('role')->latest()->get();
        return view('dashboard.master.anggota.index', compact('anggotas'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('dashboard.master.anggota.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp'         => 'required|string|max:20',
            'role_id'       => 'required|exists:roles,role_id',
            'password'      => 'required|min:8',
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp'         => $request->no_hp,
            'role_id'       => $request->role_id,
            'password'      => Hash::make($request->password),
        ]);

        return redirect()->route('dashboard.master.anggota.index')->with('success', 'Data anggota berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user->delete();
        return redirect()->route('dashboard.master.anggota.index')->with('success', 'Data anggota berhasil dihapus!');
    }
}