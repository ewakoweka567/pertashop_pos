<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Stok;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | PESANAN HARI INI
        |--------------------------------------------------------------------------
        */

        $pesananHariIni = Pemesanan::whereDate(
            'tanggal_pemesanan',
            $hariIni
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PERLU KONFIRMASI
        |--------------------------------------------------------------------------
        */

        $perluKonfirmasi = Pembayaran::where(
    'status_verifikasi',
    'menunggu'
)
->whereHas('pemesanan', function ($query) {
    $query->whereIn(
        'status_pemesanan',
        [
            'menunggu_verifikasi',
            'menunggu_pembayaran',
        ]
    );
})
->count();


        /*
        |--------------------------------------------------------------------------
        | MENUNGGU PENGAMBILAN
        |--------------------------------------------------------------------------
        */

        $menungguPengambilan = Pembayaran::where(
            'status_verifikasi',
            'diterima'
        )
        ->whereHas('pemesanan', function ($query) {
            $query->where(
                'status_pemesanan',
                'menunggu_pengambilan'
            );
        })
        ->count();


        /*
        |--------------------------------------------------------------------------
        | PERINGATAN PEMBAYARAN 15 MENIT
        |--------------------------------------------------------------------------
        */

        $peringatanPembayaran = Pembayaran::with([
    'pemesanan.user',
    'pemesanan.produk',
])
->where(
    'status_verifikasi',
    'menunggu'
)
->whereHas('pemesanan', function ($query) {
    $query->whereIn(
        'status_pemesanan',
        [
            'menunggu_verifikasi',
            'menunggu_pembayaran',
        ]
    );
})
->orderByDesc('created_at')
->get();


        /*
        |--------------------------------------------------------------------------
        | PEMBAYARAN TERBARU
        |--------------------------------------------------------------------------
        |
        | Sementara kita gunakan pembayaran terbaru.
        | Penjualan POS belum disentuh karena modul kasir belum dibuat.
        |
        */

        $pembayaranTerbaru = Pembayaran::with([
            'pemesanan.user',
            'pemesanan.produk',
        ])
        ->orderByDesc('created_at')
        ->take(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | STOK BBM
        |--------------------------------------------------------------------------
        */

        $stok = Stok::with('produk')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('dashboard.admin', compact(
            'pesananHariIni',
            'perluKonfirmasi',
            'menungguPengambilan',
            'peringatanPembayaran',
            'pembayaranTerbaru',
            'stok'
        ));
    }
}