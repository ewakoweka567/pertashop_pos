<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}