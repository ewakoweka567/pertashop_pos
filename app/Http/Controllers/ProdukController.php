<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();

        return view('admin.produk', compact('produk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga_per_liter' => 'required|numeric|min:0',
        'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $produk = Produk::create($validated);

        Stok::create([
        'id_produk' => $produk->id_produk,
        'jumlah_stok' => 0,
        ]);

         return redirect()
        ->route('admin.produk')
        ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        return view('admin.produk-edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
    $produk = Produk::findOrFail($id);

    $validated = $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga_per_liter' => 'required|numeric|min:0',
        'status' => 'required|in:aktif,tidak_aktif',
    ]);

    $produk->update($validated);

    return redirect()
        ->route('admin.produk')
        ->with('success', 'Produk berhasil diperbarui.');
    }
}