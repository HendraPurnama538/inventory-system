<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_kategoris_table
 * Tabel master kategori barang dengan soft delete
 * agar data historis transaksi tetap terjaga.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Data tidak benar-benar terhapus
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
