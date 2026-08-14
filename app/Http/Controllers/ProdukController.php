<?php

namespace App\Http\Controllers;

use App\Models\Produk;
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

        Produk::create($validated);

        return redirect()
            ->route('admin.produk')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
}