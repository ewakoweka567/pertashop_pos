<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::with('produk')->get();

        return view('admin.stok', compact('stok'));
    }

    public function edit($id)
    {
        $stok = Stok::with('produk')->findOrFail($id);

        return view('admin.stok-edit', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $stok = Stok::findOrFail($id);

        $validated = $request->validate([
            'jumlah_stok' => 'required|numeric|min:0',
        ]);

        $stok->update($validated);

        return redirect()
            ->route('admin.stok')
            ->with('success', 'Stok berhasil diperbarui.');
    }
}