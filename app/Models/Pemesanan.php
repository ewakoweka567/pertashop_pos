<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'id_user',
        'id_produk',
        'jumlah_liter',
        'total_harga',
        'status_pemesanan',
        'tanggal_pemesanan',
    ];
}