<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

/**
 * KategoriSeeder - Data contoh kategori barang.
 */
class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Elektronik',       'deskripsi' => 'Perangkat elektronik dan komputer'],
            ['nama_kategori' => 'Alat Tulis',       'deskripsi' => 'Perlengkapan alat tulis kantor'],
            ['nama_kategori' => 'Furnitur',         'deskripsi' => 'Meja, kursi, lemari kantor'],
            ['nama_kategori' => 'Perlengkapan IT',  'deskripsi' => 'Kabel, router, aksesoris IT'],
            ['nama_kategori' => 'Konsumables',      'deskripsi' => 'Tinta, kertas, bahan habis pakai'],
            ['nama_kategori' => 'Peralatan Kebersihan', 'deskripsi' => 'Sabun, alat kebersihan kantor'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::updateOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                $kategori
            );
        }

        $this->command->info('✅ Kategori seeder selesai (' . count($kategoris) . ' data).');
    }
}
