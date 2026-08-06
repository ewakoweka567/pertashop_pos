<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_pemesanan')
                  ->unique()
                  ->constrained('pemesanan')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->dateTime('tanggal_pembayaran');

            $table->enum('metode_pembayaran',[
            'transfer',
            'qris',
            'tunai'
            ])->default('transfer');

            $table->decimal('total_pembayaran', 12, 2);

            $table->string('bukti_transfer');

            $table->enum('status_verifikasi', [
                'menunggu',
                'diterima',
                'ditolak'
            ])->default('menunggu');

            $table->foreignId('id_admin_verifikasi')
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};