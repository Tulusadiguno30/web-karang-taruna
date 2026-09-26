<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('dashboard.master.role.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:50|unique:roles,nama_role',
        ]);

        Role::create([
            'nama_role' => strtolower($request->nama_role),
        ]);

        return redirect()->route('dashboard.master.role.index')->with('success', 'Role berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (in_array($role->nama_role, ['ketua', 'admin', 'sekretaris', 'bendahara', 'anggota'])) {
            return back()->withErrors(['error' => 'Role utama sistem tidak boleh dihapus.']);
        }

        $role->delete();
        return redirect()->route('dashboard.master.role.index')->with('success', 'Role berhasil dihapus!');
    }
}