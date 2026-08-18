<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with('pemesanan')
            ->latest('created_at')
            ->get();

        $menungguPembayaran = Pembayaran::where('status_verifikasi', 'menunggu')
            ->where('metode_pembayaran', 'tunai')
            ->count();

        $menungguKonfirmasi = Pembayaran::where('status_verifikasi', 'menunggu')
            ->where('metode_pembayaran', 'transfer')
            ->count();

        $lunas = Pembayaran::where('status_verifikasi', 'diterima')
            ->count();

        return view('admin.pembayaran', compact(
            'pembayaran',
            'menungguPembayaran',
            'menungguKonfirmasi',
            'lunas'
        ));
    }

    public function konfirmasi($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->status_verifikasi !== 'menunggu') {
            return redirect()
                ->route('admin.pembayaran')
                ->with('error', 'Pembayaran ini sudah diproses.');
        }

        $pembayaran->update([
            'status_verifikasi' => 'diterima',
            'tanggal_pembayaran' => now(),
            'id_admin_verifikasi' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.pembayaran')
            ->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
}