<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_barangs_table
 * Tabel master data barang dengan relasi ke kategori & supplier.
 * Kode barang di-generate otomatis via Model event.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 30)->unique();   // Auto: BRG-YYYYMM-XXXX
            $table->string('nama_barang', 200);
            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->restrictOnDelete();
            $table->foreignId('supplier_id')
                ->constrained('suppliers')
                ->restrictOnDelete();
            $table->string('satuan', 50);                  // pcs, kg, liter, dll
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->integer('stok_minimal')->default(5);   // Alert jika stok ≤ ini
            $table->string('gambar')->nullable();           // Path file gambar
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
