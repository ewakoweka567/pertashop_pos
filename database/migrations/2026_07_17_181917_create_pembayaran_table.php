<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {

            $table->id('id_pembayaran');

            $table->foreignId('id_pemesanan')
                ->unique()
                ->constrained('pemesanan', 'id_pemesanan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->dateTime('tanggal_pembayaran')
                ->nullable();

            $table->enum('metode_pembayaran', [
                'transfer',
                'tunai'
            ])->default('tunai');

            $table->decimal('total_pembayaran', 12, 2);

            $table->string('bukti_transfer')
                ->nullable();

            $table->enum('status_verifikasi', [
                'menunggu',
                'diterima',
                'ditolak'
            ])->default('menunggu');

            $table->foreignId('id_admin_verifikasi')
                ->nullable()
                ->constrained('users', 'id_user')
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