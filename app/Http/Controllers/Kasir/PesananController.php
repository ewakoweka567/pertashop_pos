<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pemesanan::with([
            'user',
            'produk',
            'pembayaran',
        ])
        ->where(
            'status_pemesanan',
            'menunggu_pengambilan'
        )
        ->orderByDesc(
            'tanggal_pemesanan'
        )
        ->get();

        return view(
            'kasir.pesanan',
            compact('pesanan')
        );
    }
}