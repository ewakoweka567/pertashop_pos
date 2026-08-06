<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan_pos', function (Blueprint $table) {
            $table->id('id_penjualan');

            $table->foreignId('id_kasir')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('id_produk')
              ->constrained('produk_bbm')
              ->cascadeOnUpdate()
              ->restrictOnDelete();

            $table->decimal('jumlah_liter', 8, 2);

            $table->decimal('total_harga', 12, 2);

            $table->timestamp('tanggal_penjualan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_pos');
    }
};