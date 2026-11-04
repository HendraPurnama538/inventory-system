<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_barang_masuks_table
 * Tabel transaksi barang masuk (pembelian/penerimaan).
 * Setiap transaksi masuk akan menambah stok barang.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('no_referensi', 50)->nullable();  // Nomor nota/PO
            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->restrictOnDelete();
            $table->foreignId('user_id')                     // Admin yang input
                ->constrained('users')
                ->restrictOnDelete();
            $table->integer('jumlah');
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->date('tanggal_masuk');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
