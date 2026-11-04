<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder - Orkestrasi semua seeder.
 *
 * Urutan penting karena ada foreign key:
 * 1. User (tidak ada FK)
 * 2. Kategori (tidak ada FK)
 * 3. Supplier (tidak ada FK)
 * 4. Barang (FK ke kategori & supplier)
 * 5. Barang Masuk/Keluar (FK ke barang & user) → di dalam BarangSeeder
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            SupplierSeeder::class,
            BarangSeeder::class,
        ]);

        $this->command->info('🎉 Semua seeder berhasil dijalankan!');
        $this->command->info('📧 Login: admin@inventaris.com | 🔑 Password: password123');
    }
}
