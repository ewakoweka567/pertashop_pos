<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | PESANAN TERAKHIR USER
        |--------------------------------------------------------------------------
        */

        $pesananTerakhir = Pemesanan::with([
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
        ->first();


        /*
        |--------------------------------------------------------------------------
        | PESANAN TERBARU USER
        |--------------------------------------------------------------------------
        */

        $pesananTerbaru = Pemesanan::with([
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
        ->take(5)
        ->get();


        return view(
            'dashboard.user',
            compact(
                'pesananTerakhir',
                'pesananTerbaru'
            )
        );
    }
}