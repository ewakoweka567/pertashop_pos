<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Produk;

class PenjualanPos extends Model
{
    protected $table = 'penjualan_pos';

    protected $primaryKey = 'id_penjualan';

    protected $fillable = [
        'id_kasir',
        'id_produk',
        'jumlah_liter',
        'total_harga',
        'tanggal_penjualan',
        'metode_pembayaran',
    ];

    protected $casts = [
        'jumlah_liter' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'tanggal_penjualan' => 'datetime',
    ];

    public function kasir()
    {
        return $this->belongsTo(
            User::class,
            'id_kasir',
            'id_user'
        );
    }

    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'id_produk',
            'id_produk'
        );
    }
}