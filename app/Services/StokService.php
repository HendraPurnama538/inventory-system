<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\DB;

/**
 * StokService - Service layer untuk logika bisnis stok.
 *
 * Memisahkan logika stok dari controller agar:
 * 1. Controller tetap tipis (thin controller)
 * 2. Logika dapat diuji secara unit terpisah
 * 3. Dapat dipakai ulang di banyak tempat
 */
class StokService
{
    /**
     * Proses transaksi barang masuk:
     * - Simpan record barang masuk
     * - Tambah stok barang
     *
     * @throws \Exception jika DB transaction gagal
     */
    public function masuk(array $data): BarangMasuk
    {
        return DB::transaction(function () use ($data) {
            // Hitung total harga otomatis
            $data['total_harga'] = $data['jumlah'] * $data['harga_beli'];

            $transaksi = BarangMasuk::create($data);

            // Update stok: tambah jumlah yang masuk
            Barang::where('id', $data['barang_id'])
                  ->increment('stok', $data['jumlah']);

            return $transaksi;
        });
    }

    /**
     * Proses transaksi barang keluar:
     * - Validasi stok mencukupi
     * - Simpan record barang keluar
     * - Kurangi stok barang
     *
     * @throws \Exception jika stok tidak mencukupi
     */
    public function keluar(array $data): BarangKeluar
    {
        return DB::transaction(function () use ($data) {
            $barang = Barang::lockForUpdate()->findOrFail($data['barang_id']);

            // Guard: stok tidak boleh negatif
            if ($barang->stok < $data['jumlah']) {
                throw new \Exception(
                    "Stok tidak mencukupi. Stok tersedia: {$barang->stok} {$barang->satuan}."
                );
            }

            // Hitung total harga otomatis
            $data['total_harga'] = $data['jumlah'] * $data['harga_jual'];

            $transaksi = BarangKeluar::create($data);

            // Update stok: kurangi jumlah yang keluar
            $barang->decrement('stok', $data['jumlah']);

            return $transaksi;
        });
    }
}
