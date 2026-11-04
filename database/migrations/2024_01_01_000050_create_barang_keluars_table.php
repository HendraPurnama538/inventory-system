<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_barang_keluars_table
 * Tabel transaksi barang keluar (penjualan/pengeluaran).
 * Setiap transaksi keluar akan mengurangi stok barang.
 * Validasi stok dilakukan di level Service/Controller.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('no_referensi', 50)->nullable();  // Nomor nota/SO
            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->restrictOnDelete();
            $table->foreignId('user_id')                     // Admin yang input
                ->constrained('users')
                ->restrictOnDelete();
            $table->integer('jumlah');
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->date('tanggal_keluar');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
