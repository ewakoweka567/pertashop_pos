<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_user')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('id_produk')
                  ->constrained('produk_bbm')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->decimal('jumlah_liter', 10, 2);
            $table->decimal('total_harga', 12, 2);

            $table->enum('status_pemesanan', [
                'menunggu_pembayaran',
                'menunggu_verifikasi',
                'diproses',
                'selesai',
                'dibatalkan'
            ])->default('menunggu_pembayaran');

            $table->timestamp('tanggal_pemesanan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};