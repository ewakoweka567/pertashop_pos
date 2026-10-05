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
    | RIWAYAT TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function riwayat()
    {
        $transaksi = PenjualanPos::with([
            'produk',
            'kasir',
        ])
        ->where('id_kasir', Auth::id())
        ->latest('tanggal_penjualan')
        ->paginate(10);

        return view(
            'kasir.riwayat',
            compact('transaksi')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN TRANSAKSI POS
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI INPUT
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'id_produk' => [
                'required',
                'exists:produk_bbm,id_produk',
            ],

            'jumlah_liter' => [
                'nullable',
                'numeric',
                'gt:0',
            ],

            'total_harga' => [
                'nullable',
                'numeric',
                'gt:0',
            ],

            'metode_pembayaran' => [
                'required',
                'in:tunai,transfer,qris',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | MINIMAL SALAH SATU HARUS DIISI
        |--------------------------------------------------------------------------
        */

        if (
            !$request->filled('jumlah_liter') &&
            !$request->filled('total_harga')
        ) {

            return back()
                ->withErrors([
                    'jumlah_liter' =>
                        'Isi jumlah liter atau total harga.'
                ])
                ->withInput();
        }


        $penjualan = null;


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI DATABASE
        |--------------------------------------------------------------------------
        */

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
            | HITUNG STOK TERSEDIA
            |--------------------------------------------------------------------------
            */

            $stokTersedia =
                $stok->jumlah_stok
                - $stok->stok_reservasi;


            /*
            |--------------------------------------------------------------------------
            | AMBIL PRODUK
            |--------------------------------------------------------------------------
            */

            $produk = $stok->produk;


            if (!$produk) {

                abort(
                    422,
                    'Data produk tidak ditemukan.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | CEK PRODUK AKTIF
            |--------------------------------------------------------------------------
            */

            if ($produk->status !== 'aktif') {

                abort(
                    422,
                    'Produk sedang tidak aktif.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | HITUNG LITER DAN TOTAL HARGA
            |--------------------------------------------------------------------------
            |
            | Jika kasir memasukkan liter:
            | liter → harga
            |
            | Jika kasir memasukkan harga:
            | harga → liter
            |
            */

            if ($request->filled('jumlah_liter')) {

                /*
                | Kasir memasukkan jumlah liter
                */

                $jumlahLiter =
                    (float) $request->jumlah_liter;

                $totalHarga =
                    $jumlahLiter
                    * $produk->harga_per_liter;

            } else {

                /*
                | Kasir memasukkan total harga
                */

                $totalHarga =
                    (float) $request->total_harga;

                $jumlahLiter =
                    $totalHarga
                    / $produk->harga_per_liter;
            }


            /*
            |--------------------------------------------------------------------------
            | CEK STOK
            |--------------------------------------------------------------------------
            */

            if ($jumlahLiter > $stokTersedia) {

                abort(
                    422,
                    'Stok produk tidak mencukupi untuk transaksi ini.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | KURANGI STOK FISIK
            |--------------------------------------------------------------------------
            */

            $stok->jumlah_stok =
                $stok->jumlah_stok
                - $jumlahLiter;

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
                    $jumlahLiter,

                'total_harga' =>
                    $totalHarga,

                'tanggal_penjualan' =>
                    now(),

                'metode_pembayaran' =>
                    $request->metode_pembayaran,

            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE POS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'kasir.pos',
                [
                    'sukses' =>
                        $penjualan->id_penjualan,
                ]
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CETAK STRUK
    |--------------------------------------------------------------------------
    */

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