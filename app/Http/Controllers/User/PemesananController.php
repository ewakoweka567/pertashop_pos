<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function create(Request $request)
    {
    $stok = Stok::with('produk')
        ->whereHas('produk', function ($query) {
            $query->where('status', 'aktif');
        })
        ->get();

    return view(
        'user.pemesanan',
        [
            'stok' => $stok,
            'produkDipilih' => $request->id_produk,
            'jumlahDipilih' => $request->jumlah_liter,
            'metodeDipilih' => $request->metode_pembayaran,
        ]
    );
    }

    public function store(Request $request)
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
                'in:transfer,tunai',
            ],

            'bukti_transfer' => [
                'nullable',
                'image',
                'max:2048',
            ],
        ]);

        if (
            $request->metode_pembayaran === 'transfer'
            && !$request->hasFile('bukti_transfer')
        ) {
            return back()
                ->withErrors([
                    'bukti_transfer' =>
                        'Bukti transfer wajib dilampirkan.',
                ])
                ->withInput();
        }

        DB::transaction(function () use ($request) {

            $stok = Stok::where(
                'id_produk',
                $request->id_produk
            )
            ->lockForUpdate()
            ->firstOrFail();

            $stokTersedia =
                $stok->jumlah_stok
                - $stok->stok_reservasi;

            if ($request->jumlah_liter > $stokTersedia) {
                abort(
                    422,
                    'Stok BBM tidak mencukupi.'
                );
            }

            $hargaPerLiter =
                $stok->produk->harga_per_liter;

            $totalHarga =
                $request->jumlah_liter
                * $hargaPerLiter;

            /*
             * Kunci stok yang dipesan
             */
            $stok->increment(
                'stok_reservasi',
                $request->jumlah_liter
            );

            $statusPemesanan =
                $request->metode_pembayaran === 'transfer'
                    ? 'menunggu_verifikasi'
                    : 'menunggu_pembayaran';

            $statusPembayaran =
                $request->metode_pembayaran === 'transfer'
                    ? 'sudah_dibayar'
                    : 'belum_dibayar';

            $buktiTransfer = null;

            if ($request->hasFile('bukti_transfer')) {

                $buktiTransfer =
                    $request->file('bukti_transfer')
                        ->store(
                            'bukti-transfer',
                            'public'
                        );
            }

            $pemesanan = Pemesanan::create([

                'id_user' =>
                    Auth::id(),

                'id_produk' =>
                    $request->id_produk,

                'jumlah_liter' =>
                    $request->jumlah_liter,

                'total_harga' =>
                    $totalHarga,

                'status_pemesanan' =>
                    $statusPemesanan,

                'status_pembayaran' =>
                    $statusPembayaran,

                'tanggal_pemesanan' =>
                    now(),

            ]);

            Pembayaran::create([

                'id_pemesanan' =>
                    $pemesanan->id_pemesanan,

                'tanggal_pembayaran' =>
                    $request->metode_pembayaran === 'transfer'
                        ? now()
                        : null,

                'metode_pembayaran' =>
                    $request->metode_pembayaran,

                'total_pembayaran' =>
                    $totalHarga,

                'bukti_transfer' =>
                    $buktiTransfer,

                'status_verifikasi' =>
                    'menunggu',

                'id_admin_verifikasi' =>
                    null,

            ]);
        });

        return redirect()
    ->route('user.pemesanan')
    ->with(
        'success',
        'Pemesanan berhasil dibuat.'
    );
    }
}