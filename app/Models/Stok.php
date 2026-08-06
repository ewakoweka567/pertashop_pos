<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok_bbm';

    protected $primaryKey = 'id_stok';

    protected $fillable = [
        'id_produk',
        'jumlah_stok'
    ];
}