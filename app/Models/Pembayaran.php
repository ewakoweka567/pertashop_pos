<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_pemesanan',
        'tanggal_pembayaran',
        'total_pembayaran',
        'bukti_transfer',
        'status_verifikasi',
        'id_admin_verifikasi',
    ];
}