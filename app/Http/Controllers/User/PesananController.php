<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR PESANAN USER
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | DETAIL PESANAN USER
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $pesanan = Pemesanan::with([
            'produk',
            'pembayaran',
        ])
        ->where(
            'id_pemesanan',
            $id
        )
        ->where(
            'id_user',
            Auth::id()
        )
        ->firstOrFail();

        return view(
            'user.pesanan-detail',
            compact('pesanan')
        );
    }
}