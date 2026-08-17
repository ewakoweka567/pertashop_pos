<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\PenjualanPos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {   
        /*
        |--------------------------------------------------------------------------
        | FILTER RIWAYAT
        |--------------------------------------------------------------------------
        */

        $dari = $request->filled('dari')
            ? Carbon::parse($request->dari)->startOfDay()
            : null;

        $sampai = $request->filled('sampai')
            ? Carbon::parse($request->sampai)->endOfDay()
            : null;

        $search = trim($request->search ?? '');


        /*
        |--------------------------------------------------------------------------
        | PEMESANAN ONLINE
        |--------------------------------------------------------------------------
        |
        | Kita ambil pemesanan yang sudah selesai sebagai transaksi penjualan.
        |
        */

        $pesananQuery = Pemesanan::with([
            'user',
            'produk',
            'pembayaran'
        ])
        ->where('status_pemesanan', 'selesai');


        if ($dari) {
            $pesananQuery->where(
                'tanggal_pemesanan',
                '>=',
                $dari
            );
        }

        if ($sampai) {
            $pesananQuery->where(
                'tanggal_pemesanan',
                '<=',
                $sampai
            );
        }


        if ($search !== '') {

            $pesananQuery->where(function ($query) use ($search) {

                $query->where(
                    'id_pemesanan',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('user', function ($q) use ($search) {

                    $q->where(
                        'nama',
                        'like',
                        "%{$search}%"
                    );

                })

                ->orWhereHas('produk', function ($q) use ($search) {

                    $q->where(
                        'nama_produk',
                        'like',
                        "%{$search}%"
                    );

                });

            });
        }


        $pesanan = $pesananQuery
            ->orderByDesc('tanggal_pemesanan')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PENJUALAN POS
        |--------------------------------------------------------------------------
        */

        $posQuery = PenjualanPos::with([
            'kasir',
            'produk'
        ]);


        if ($dari) {
            $posQuery->where(
                'tanggal_penjualan',
                '>=',
                $dari
            );
        }

        if ($sampai) {
            $posQuery->where(
                'tanggal_penjualan',
                '<=',
                $sampai
            );
        }


        if ($search !== '') {

            $posQuery->where(function ($query) use ($search) {

                $query->where(
                    'id_penjualan',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('kasir', function ($q) use ($search) {

                    $q->where(
                        'nama',
                        'like',
                        "%{$search}%"
                    );

                })

                ->orWhereHas('produk', function ($q) use ($search) {

                    $q->where(
                        'nama_produk',
                        'like',
                        "%{$search}%"
                    );

                });

            });
        }


        $pos = $posQuery
            ->orderByDesc('tanggal_penjualan')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI DATA RIWAYAT
        |--------------------------------------------------------------------------
        */

        $riwayatOnline = $pesanan->map(function ($item) {

            return [
                'id' => 'PM' . str_pad(
                    $item->id_pemesanan,
                    3,
                    '0',
                    STR_PAD_LEFT
                ),

                'jenis' => 'Pemesanan',

                'pelaku' => $item->user->nama ?? '-',

                'produk' => $item->produk->nama_produk ?? '-',

                'jumlah_liter' => $item->jumlah_liter,

                'total_harga' => $item->total_harga,

                'metode' => $item->pembayaran->metode_pembayaran
                    ?? '-',

                'status' => $item->status_pemesanan,

                'tanggal' => $item->tanggal_pemesanan,
            ];

        });


        $riwayatPos = $pos->map(function ($item) {

            return [
                'id' => 'TRX' . str_pad(
                    $item->id_penjualan,
                    3,
                    '0',
                    STR_PAD_LEFT
                ),

                'jenis' => 'POS',

                'pelaku' => $item->kasir->nama ?? '-',

                'produk' => $item->produk->nama_produk ?? '-',

                'jumlah_liter' => $item->jumlah_liter,

                'total_harga' => $item->total_harga,

                'metode' => $item->metode_pembayaran,

                'status' => 'Selesai',

                'tanggal' => $item->tanggal_penjualan,
            ];

        });


        /*
        |--------------------------------------------------------------------------
        | GABUNGKAN SEMUA RIWAYAT
        |--------------------------------------------------------------------------
        */

        $riwayat = $riwayatOnline
            ->concat($riwayatPos)
            ->sortByDesc('tanggal')
            ->values();


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalPenjualan = $riwayat->sum('total_harga');

        $totalTransaksi = $riwayat->count();

        $totalLiter = $riwayat->sum('jumlah_liter');


        /*
        |--------------------------------------------------------------------------
        | DIAGRAM
        |--------------------------------------------------------------------------
        */

        $chartYear = (int) $request->get(
            'chartYear',
            now()->year
        );

        $chartMonth = (int) $request->get(
            'chartMonth',
            now()->month
        );

        $chartDate = $request->get(
            'chartDate',
            now()->toDateString()
        );


        /*
        |--------------------------------------------------------------------------
        | DIAGRAM HARIAN
        |--------------------------------------------------------------------------
        */

        $harianPos = PenjualanPos::select(
            DB::raw('HOUR(tanggal_penjualan) as jam'),
            DB::raw('SUM(total_harga) as total')
        )
        ->whereDate(
            'tanggal_penjualan',
            $chartDate
        )
        ->groupBy(
            DB::raw('HOUR(tanggal_penjualan)')
        )
        ->pluck('total', 'jam');


        $harianOnline = Pemesanan::select(
            DB::raw('HOUR(tanggal_pemesanan) as jam'),
            DB::raw('SUM(total_harga) as total')
        )
        ->where('status_pemesanan', 'selesai')
        ->whereDate(
            'tanggal_pemesanan',
            $chartDate
        )
        ->groupBy(
            DB::raw('HOUR(tanggal_pemesanan)')
        )
        ->pluck('total', 'jam');


        $penjualanHarian = $this->gabungkanStatistik(
            $harianPos,
            $harianOnline
        );


        /*
        |--------------------------------------------------------------------------
        | DIAGRAM BULANAN
        |--------------------------------------------------------------------------
        */

        $bulananPos = PenjualanPos::select(
            DB::raw('DAY(tanggal_penjualan) as hari'),
            DB::raw('SUM(total_harga) as total')
        )
        ->whereYear(
            'tanggal_penjualan',
            $chartYear
        )
        ->whereMonth(
            'tanggal_penjualan',
            $chartMonth
        )
        ->groupBy(
            DB::raw('DAY(tanggal_penjualan)')
        )
        ->pluck('total', 'hari');


        $bulananOnline = Pemesanan::select(
            DB::raw('DAY(tanggal_pemesanan) as hari'),
            DB::raw('SUM(total_harga) as total')
        )
        ->where(
            'status_pemesanan',
            'selesai'
        )
        ->whereYear(
            'tanggal_pemesanan',
            $chartYear
        )
        ->whereMonth(
            'tanggal_pemesanan',
            $chartMonth
        )
        ->groupBy(
            DB::raw('DAY(tanggal_pemesanan)')
        )
        ->pluck('total', 'hari');


        $penjualanBulanan = $this->gabungkanStatistik(
            $bulananPos,
            $bulananOnline
        );


        /*
        |--------------------------------------------------------------------------
        | DIAGRAM TAHUNAN
        |--------------------------------------------------------------------------
        */

        $tahunanPos = PenjualanPos::select(
            DB::raw('MONTH(tanggal_penjualan) as bulan'),
            DB::raw('SUM(total_harga) as total')
        )
        ->whereYear(
            'tanggal_penjualan',
            $chartYear
        )
        ->groupBy(
            DB::raw('MONTH(tanggal_penjualan)')
        )
        ->pluck('total', 'bulan');


        $tahunanOnline = Pemesanan::select(
            DB::raw('MONTH(tanggal_pemesanan) as bulan'),
            DB::raw('SUM(total_harga) as total')
        )
        ->where(
            'status_pemesanan',
            'selesai'
        )
        ->whereYear(
            'tanggal_pemesanan',
            $chartYear
        )
        ->groupBy(
            DB::raw('MONTH(tanggal_pemesanan)')
        )
        ->pluck('total', 'bulan');


        $penjualanTahunan = $this->gabungkanStatistik(
            $tahunanPos,
            $tahunanOnline
        );


        return view('admin.riwayat', compact(
            'riwayat',
            'totalPenjualan',
            'totalTransaksi',
            'totalLiter',
            'penjualanHarian',
            'penjualanBulanan',
            'penjualanTahunan',
            'chartYear',
            'chartMonth',
            'chartDate',
            'dari',
            'sampai',
            'search'
        ));
    }

    public function cetak(Request $request)
{
    $request->validate([
        'dari' => ['required', 'date'],
        'sampai' => ['required', 'date', 'after_or_equal:dari'],
    ]);

    $dari = Carbon::parse($request->dari)->startOfDay();
    $sampai = Carbon::parse($request->sampai)->endOfDay();


    $pesanan = Pemesanan::with([
        'user',
        'produk',
        'pembayaran'
    ])
    ->where('status_pemesanan', 'selesai')
    ->whereBetween(
        'tanggal_pemesanan',
        [$dari, $sampai]
    )
    ->orderBy('tanggal_pemesanan')
    ->get();


    $pos = PenjualanPos::with([
        'kasir',
        'produk'
    ])
    ->whereBetween(
        'tanggal_penjualan',
        [$dari, $sampai]
    )
    ->orderBy('tanggal_penjualan')
    ->get();


    $riwayatOnline = $pesanan->map(function ($item) {

        return [
            'id' => 'PM' . str_pad(
                $item->id_pemesanan,
                3,
                '0',
                STR_PAD_LEFT
            ),

            'jenis' => 'Pemesanan',

            'pelaku' => $item->user->nama ?? '-',

            'produk' => $item->produk->nama_produk ?? '-',

            'jumlah_liter' => $item->jumlah_liter,

            'total_harga' => $item->total_harga,

            'metode' => $item->pembayaran->metode_pembayaran ?? '-',

            'status' => $item->status_pemesanan,

            'tanggal' => $item->tanggal_pemesanan,
        ];
    });


    $riwayatPos = $pos->map(function ($item) {

        return [
            'id' => 'TRX' . str_pad(
                $item->id_penjualan,
                3,
                '0',
                STR_PAD_LEFT
            ),

            'jenis' => 'POS',

            'pelaku' => $item->kasir->nama ?? '-',

            'produk' => $item->produk->nama_produk ?? '-',

            'jumlah_liter' => $item->jumlah_liter,

            'total_harga' => $item->total_harga,

            'metode' => $item->metode_pembayaran,

            'status' => 'Selesai',

            'tanggal' => $item->tanggal_penjualan,
        ];
    });


    $riwayat = $riwayatOnline
        ->concat($riwayatPos)
        ->sortBy('tanggal')
        ->values();


    $totalPenjualan = $riwayat->sum('total_harga');
    $totalTransaksi = $riwayat->count();
    $totalLiter = $riwayat->sum('jumlah_liter');


    return view('admin.laporan-print', compact(
        'riwayat',
        'totalPenjualan',
        'totalTransaksi',
        'totalLiter',
        'dari',
        'sampai'
    ));
}


    /*
    |--------------------------------------------------------------------------
    | GABUNG STATISTIK POS + PEMESANAN
    |--------------------------------------------------------------------------
    */

    private function gabungkanStatistik(
        Collection $pos,
        Collection $online
    ): Collection {

        $hasil = collect();

        foreach ($pos as $key => $value) {
            $hasil->put(
                $key,
                (float) $value
            );
        }

        foreach ($online as $key => $value) {

            $hasil->put(
                $key,
                ($hasil->get($key, 0))
                + (float) $value
            );

        }

        return $hasil;
    }
}