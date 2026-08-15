<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::orderBy('id_user', 'desc')->get();

        return view('admin.pengguna', compact('pengguna'));
    }

    public function edit($id)
    {
        $pengguna = User::findOrFail($id);

        return view('admin.pengguna-edit', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id . ',id_user',
            'no_hp' => 'required|string|max:15',
            'role' => 'required|in:admin,kasir,user',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $pengguna->update($validated);

        return redirect()
            ->route('admin.pengguna')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }
}