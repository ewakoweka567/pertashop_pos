<?php

namespace App\Http\Controllers;

use App\Models\PenjualanPos;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index()
    {
        $transaksi = PenjualanPos::with([
            'kasir',
            'produk'
        ])
        ->orderByDesc('tanggal_penjualan')
        ->get();

        $totalPenjualan = $transaksi->sum('total_harga');
        $totalTransaksi = $transaksi->count();
        $totalLiter = $transaksi->sum('jumlah_liter');

        /*
        |--------------------------------------------------------------------------
        | DIAGRAM HARIAN
        |--------------------------------------------------------------------------
        | Penjualan berdasarkan jam pada hari ini
        */

        $penjualanHarian = PenjualanPos::select(
                DB::raw('HOUR(tanggal_penjualan) as jam'),
                DB::raw('SUM(total_harga) as total')
            )
            ->whereDate('tanggal_penjualan', now()->toDateString())
            ->groupBy(DB::raw('HOUR(tanggal_penjualan)'))
            ->pluck('total', 'jam');


        /*
        |--------------------------------------------------------------------------
        | DIAGRAM BULANAN
        |--------------------------------------------------------------------------
        | Penjualan berdasarkan tanggal dalam bulan berjalan
        */

        $penjualanBulanan = PenjualanPos::select(
                DB::raw('DAY(tanggal_penjualan) as hari'),
                DB::raw('SUM(total_harga) as total')
            )
            ->whereYear('tanggal_penjualan', now()->year)
            ->whereMonth('tanggal_penjualan', now()->month)
            ->groupBy(DB::raw('DAY(tanggal_penjualan)'))
            ->pluck('total', 'hari');


        /*
        |--------------------------------------------------------------------------
        | DIAGRAM TAHUNAN
        |--------------------------------------------------------------------------
        | Penjualan berdasarkan bulan dalam tahun berjalan
        */

        $penjualanTahunan = PenjualanPos::select(
                DB::raw('MONTH(tanggal_penjualan) as bulan'),
                DB::raw('SUM(total_harga) as total')
            )
            ->whereYear('tanggal_penjualan', now()->year)
            ->groupBy(DB::raw('MONTH(tanggal_penjualan)'))
            ->pluck('total', 'bulan');


        return view('admin.riwayat', compact(
            'transaksi',
            'totalPenjualan',
            'totalTransaksi',
            'totalLiter',
            'penjualanHarian',
            'penjualanBulanan',
            'penjualanTahunan'
        ));
    }
}