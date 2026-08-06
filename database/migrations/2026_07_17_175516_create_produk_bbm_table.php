<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_bbm', function (Blueprint $table) {
            $table->id();

            $table->string('nama_produk');
            $table->decimal('harga_per_liter', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_bbm');
    }
};