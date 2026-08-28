<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Stok;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PengambilanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PESANAN MENUNGGU PENGAMBILAN
    |--------------------------------------------------------------------------
    |
    | Dipakai oleh Admin dan Kasir.
    |
    */

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
        ->orderByDesc('tanggal_pemesanan')
        ->get();

        return view(
            'pengambilan.index',
            compact('pesanan')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KONFIRMASI PENGAMBILAN
    |--------------------------------------------------------------------------
    */

    public function konfirmasi($id): RedirectResponse
    {
        DB::transaction(function () use ($id) {

            /*
            |--------------------------------------------------------------------------
            | KUNCI PEMESANAN
            |--------------------------------------------------------------------------
            */

            $pemesanan = Pemesanan::with([
                'pembayaran'
            ])
            ->lockForUpdate()
            ->findOrFail($id);


            /*
            |--------------------------------------------------------------------------
            | CEK STATUS
            |--------------------------------------------------------------------------
            */

            if (
                $pemesanan->status_pemesanan
                !== 'menunggu_pengambilan'
            ) {
                abort(
                    422,
                    'Pesanan ini tidak berada pada tahap menunggu pengambilan.'
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
                    'Stok reservasi tidak mencukupi untuk pengambilan ini.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | CEK STOK FISIK
            |--------------------------------------------------------------------------
            */

            if (
                $stok->jumlah_stok
                < $pemesanan->jumlah_liter
            ) {
                abort(
                    422,
                    'Stok fisik tidak mencukupi.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | KURANGI STOK FISIK
            |--------------------------------------------------------------------------
            */

            $stok->jumlah_stok =
                $stok->jumlah_stok
                - $pemesanan->jumlah_liter;


            /*
            |--------------------------------------------------------------------------
            | LEPAS RESERVASI
            |--------------------------------------------------------------------------
            */

            $stok->stok_reservasi =
                $stok->stok_reservasi
                - $pemesanan->jumlah_liter;


            $stok->save();


            /*
            |--------------------------------------------------------------------------
            | SELESAIKAN PEMESANAN
            |--------------------------------------------------------------------------
            |
            | Pesanan tetap menjadi data PEMESANAN.
            |
            | Tidak dibuat menjadi PenjualanPos karena transaksi ini
            | berasal dari pelanggan yang melakukan pemesanan.
            |
            */

            $pemesanan->update([
                'status_pemesanan' => 'selesai',
                'status_pembayaran' => 'sudah_dibayar',
            ]);
        });


        return back()->with(
            'success',
            'Pengambilan BBM berhasil dikonfirmasi dan pesanan telah diselesaikan.'
        );
    }
}