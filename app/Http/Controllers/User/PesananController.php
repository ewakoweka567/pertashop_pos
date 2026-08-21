<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pemesanan::with([
            'produk',
            'pembayaran',
        ])
        ->where(
            'id_user',
            Auth::id()
        )
        ->orderByDesc(
            'tanggal_pemesanan'
        )
        ->get();

        return view(
            'user.pesanan',
            compact('pesanan')
        );
    }
}