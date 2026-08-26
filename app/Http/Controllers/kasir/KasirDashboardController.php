<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\PenjualanPos;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class KasirDashboardController extends Controller
{
    public function index()
    {
        $idKasir = Auth::id();

        // Jumlah transaksi POS hari ini
        $transaksiHariIni = PenjualanPos::where('id_kasir', $idKasir)
            ->whereDate('tanggal_penjualan', today())
            ->count();

        // Total penjualan hari ini
        $penjualanHariIni = PenjualanPos::where('id_kasir', $idKasir)
            ->whereDate('tanggal_penjualan', today())
            ->sum('total_harga');

        // Total liter terjual hari ini
        $literTerjualHariIni = PenjualanPos::where('id_kasir', $idKasir)
            ->whereDate('tanggal_penjualan', today())
            ->sum('jumlah_liter');

        // Pesanan yang menunggu pengambilan
        $pesananPerluDiproses = Pemesanan::with([
            'user',
            'produk'
        ])
            ->where('status_pemesanan', 'menunggu_pengambilan')
            ->latest('tanggal_pemesanan')
            ->take(5)
            ->get();

        return view('dashboard.kasir', compact(
            'transaksiHariIni',
            'penjualanHariIni',
            'pesananPerluDiproses'
        ));
    }
}