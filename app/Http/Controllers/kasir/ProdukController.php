<?php

namespace App\Http\Controllers\Kasir;

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

        $stok->each(function ($item) {

            $item->stok_tersedia = max(
                $item->jumlah_stok
                - ($item->stok_reservasi ?? 0),
                0
            );

        });

        return view(
            'kasir.produk-stok',
            compact('stok')
        );
    }
}