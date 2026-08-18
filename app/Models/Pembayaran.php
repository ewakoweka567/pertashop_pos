<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pemesanan;
use App\Models\User;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_pemesanan',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'total_pembayaran',
        'bukti_transfer',
        'status_verifikasi',
        'id_admin_verifikasi',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
        'total_pembayaran' => 'decimal:2',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(
            Pemesanan::class,
            'id_pemesanan',
            'id_pemesanan'
        );
    }

    public function adminVerifikasi()
    {
        return $this->belongsTo(
            User::class,
            'id_admin_verifikasi',
            'id_user'
        );
    }
}