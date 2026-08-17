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
        'status_pembayaran',
        'tanggal_pemesanan',
    ];

    protected $casts = [
        'jumlah_liter' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'tanggal_pemesanan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
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

    public function pembayaran()
    {
        return $this->hasOne(
            Pembayaran::class,
            'id_pemesanan',
            'id_pemesanan'
        );
    }
}