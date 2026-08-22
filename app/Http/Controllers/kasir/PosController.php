<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\PenjualanPos;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN POS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $stok = Stok::with('produk')
            ->whereHas('produk', function ($query) {
                $query->where('status', 'aktif');
            })
            ->get();

        return view(
            'kasir.pos',
            compact('stok')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN TRANSAKSI POS
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_produk' => [
                'required',
                'exists:produk_bbm,id_produk',
            ],

            'jumlah_liter' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'metode_pembayaran' => [
                'required',
                'in:tunai,transfer,qris',
            ],
        ]);


        $penjualan = null;


        DB::transaction(function () use (
            $request,
            &$penjualan
        ) {

            /*
            |--------------------------------------------------------------------------
            | KUNCI STOK
            |--------------------------------------------------------------------------
            */

            $stok = Stok::where(
                'id_produk',
                $request->id_produk
            )
            ->lockForUpdate()
            ->firstOrFail();


            /*
            |--------------------------------------------------------------------------
            | HITUNG STOK YANG BENAR-BENAR BOLEH DIJUAL
            |--------------------------------------------------------------------------
            */

            $stokTersedia =
                $stok->jumlah_stok
                - $stok->stok_reservasi;


            if (
                $request->jumlah_liter
                > $stokTersedia
            ) {

                abort(
                    422,
                    'Stok produk tidak mencukupi untuk transaksi ini.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | PRODUK
            |--------------------------------------------------------------------------
            */

            $produk = $stok->produk;


            if (!$produk) {

                abort(
                    422,
                    'Data produk tidak ditemukan.'
                );
            }


            if ($produk->status !== 'aktif') {

                abort(
                    422,
                    'Produk sedang tidak aktif.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | HITUNG TOTAL
            |--------------------------------------------------------------------------
            */

            $totalHarga =
                $request->jumlah_liter
                * $produk->harga_per_liter;


            /*
            |--------------------------------------------------------------------------
            | KURANGI STOK FISIK
            |--------------------------------------------------------------------------
            |
            | Transaksi POS langsung adalah penjualan langsung,
            | jadi stok fisik langsung berkurang.
            |
            | Stok reservasi TIDAK disentuh.
            |
            */

            $stok->jumlah_stok =
                $stok->jumlah_stok
                - $request->jumlah_liter;


            $stok->save();


            /*
            |--------------------------------------------------------------------------
            | SIMPAN PENJUALAN
            |--------------------------------------------------------------------------
            */

            $penjualan = PenjualanPos::create([

                'id_kasir' =>
                    Auth::id(),

                'id_produk' =>
                    $produk->id_produk,

                'jumlah_liter' =>
                    $request->jumlah_liter,

                'total_harga' =>
                    $totalHarga,

                'tanggal_penjualan' =>
                    now(),

                'metode_pembayaran' =>
                    $request->metode_pembayaran,

            ]);
        });


        return redirect()
            ->route(
                'kasir.pos',
                [
                    'sukses' =>
                        $penjualan->id_penjualan,
                ]
            );
    }
    public function cetakStruk($id)
{
    $penjualan = PenjualanPos::with([
        'produk',
        'kasir',
    ])->findOrFail($id);

    return view(
        'kasir.struk',
        compact('penjualan')
    );
}
}