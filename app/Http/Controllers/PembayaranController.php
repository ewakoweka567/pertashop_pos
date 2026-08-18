<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Stok;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | DATA PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        $pembayaran = Pembayaran::with([
            'pemesanan.user',
            'pemesanan.produk',
        ])
        ->orderByDesc('created_at')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | MENUNGGU PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        $menungguPembayaran = Pembayaran::whereHas(
            'pemesanan',
            function ($query) {

                $query->where(
                    'status_pemesanan',
                    'menunggu_pembayaran'
                );

            }
        )->count();


        /*
        |--------------------------------------------------------------------------
        | MENUNGGU KONFIRMASI
        |--------------------------------------------------------------------------
        */

        $menungguKonfirmasi = Pembayaran::where(
            'status_verifikasi',
            'menunggu'
        )
        ->whereHas(
            'pemesanan',
            function ($query) {

                $query->where(
                    'status_pemesanan',
                    'menunggu_verifikasi'
                );

            }
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | LUNAS
        |--------------------------------------------------------------------------
        */

        $lunas = Pembayaran::where(
            'status_verifikasi',
            'diterima'
        )->count();


        return view('admin.pembayaran', compact(
            'pembayaran',
            'menungguPembayaran',
            'menungguKonfirmasi',
            'lunas'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | KONFIRMASI PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function konfirmasi($id): RedirectResponse
    {
        DB::transaction(function () use ($id) {

            $pembayaran = Pembayaran::with([
                'pemesanan'
            ])
            ->lockForUpdate()
            ->findOrFail($id);


            /*
            |--------------------------------------------------------------------------
            | PEMBAYARAN HARUS MASIH MENUNGGU
            |--------------------------------------------------------------------------
            */

            if ($pembayaran->status_verifikasi !== 'menunggu') {

                abort(
                    422,
                    'Pembayaran ini sudah diproses.'
                );

            }


            $pemesanan = $pembayaran->pemesanan;


            if (!$pemesanan) {

                abort(
                    422,
                    'Data pemesanan tidak ditemukan.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | PESANAN HARUS MENUNGGU VERIFIKASI
            |--------------------------------------------------------------------------
            */

            if (
                $pemesanan->status_pemesanan
                !== 'menunggu_verifikasi'
            ) {

                abort(
                    422,
                    'Pesanan belum berada pada tahap verifikasi pembayaran.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | PEMBAYARAN DITERIMA
            |--------------------------------------------------------------------------
            */

            $pembayaran->update([
                'status_verifikasi' => 'diterima',
                'tanggal_pembayaran' =>
                    $pembayaran->tanggal_pembayaran
                    ?? now(),
                'id_admin_verifikasi' => Auth::id(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | PESANAN MENUNGGU PENGAMBILAN
            |--------------------------------------------------------------------------
            |
            | Stok fisik BELUM dikurangi.
            | Reservasi tetap dikunci sampai customer mengambil BBM.
            |
            */

            $pemesanan->update([
                'status_pemesanan' => 'menunggu_pengambilan',
                'status_pembayaran' => 'sudah_dibayar',
            ]);

        });


        return back()->with(
            'success',
            'Pembayaran berhasil dikonfirmasi. Pesanan sekarang menunggu pengambilan BBM.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TOLAK PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function tolak($id): RedirectResponse
    {
        DB::transaction(function () use ($id) {

            $pembayaran = Pembayaran::with([
                'pemesanan'
            ])
            ->lockForUpdate()
            ->findOrFail($id);


            /*
            |--------------------------------------------------------------------------
            | PEMBAYARAN HARUS MASIH MENUNGGU
            |--------------------------------------------------------------------------
            */

            if ($pembayaran->status_verifikasi !== 'menunggu') {

                abort(
                    422,
                    'Pembayaran ini sudah diproses.'
                );

            }


            $pemesanan = $pembayaran->pemesanan;


            if (!$pemesanan) {

                abort(
                    422,
                    'Data pemesanan tidak ditemukan.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | PESANAN HARUS MENUNGGU VERIFIKASI
            |--------------------------------------------------------------------------
            */

            if (
                $pemesanan->status_pemesanan
                !== 'menunggu_verifikasi'
            ) {

                abort(
                    422,
                    'Pesanan belum berada pada tahap verifikasi pembayaran.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | KUNCI STOK
            |--------------------------------------------------------------------------
            */

            $stok = Stok::where(
                'id_produk',
                $pemesanan->id_produk
            )
            ->lockForUpdate()
            ->first();


            if (!$stok) {

                abort(
                    422,
                    'Data stok produk tidak ditemukan.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | CEK RESERVASI
            |--------------------------------------------------------------------------
            */

            if (
                $stok->stok_reservasi
                < $pemesanan->jumlah_liter
            ) {

                abort(
                    422,
                    'Jumlah reservasi stok tidak mencukupi untuk dikembalikan.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | KEMBALIKAN RESERVASI
            |--------------------------------------------------------------------------
            */

            $stok->stok_reservasi =
                $stok->stok_reservasi
                - $pemesanan->jumlah_liter;

            $stok->save();


            /*
            |--------------------------------------------------------------------------
            | PEMBAYARAN DITOLAK
            |--------------------------------------------------------------------------
            */

            $pembayaran->update([
                'status_verifikasi' => 'ditolak',
                'id_admin_verifikasi' => Auth::id(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | PESANAN DIBATALKAN
            |--------------------------------------------------------------------------
            */

            $pemesanan->update([
                'status_pemesanan' => 'dibatalkan',
                'status_pembayaran' => 'ditolak',
            ]);

        });


        return back()->with(
            'success',
            'Pembayaran ditolak dan reservasi stok berhasil dikembalikan.'
        );
    }
}