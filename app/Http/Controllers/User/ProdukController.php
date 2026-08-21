<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Stok;

class ProdukController extends Controller
{
    public function index()
    {
        $stok = Stok::with('produk')
            ->whereHas('produk', function ($query) {
                $query->where('status', 'aktif');
            })
            ->get();

        return view('user.produk-stok', compact('stok'));
    }
}