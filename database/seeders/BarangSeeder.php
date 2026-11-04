<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * BarangSeeder - Data contoh barang beserta transaksi sample.
 */
class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $elektronik      = Kategori::where('nama_kategori', 'Elektronik')->first();
        $alatTulis       = Kategori::where('nama_kategori', 'Alat Tulis')->first();
        $furnitur        = Kategori::where('nama_kategori', 'Furnitur')->first();
        $perlengkapanIT  = Kategori::where('nama_kategori', 'Perlengkapan IT')->first();
        $konsumables     = Kategori::where('nama_kategori', 'Konsumables')->first();

        $supplierElektronik = Supplier::where('nama_supplier', 'PT. Maju Jaya Elektronik')->first();
        $supplierAtk        = Supplier::where('nama_supplier', 'CV. Sumber Bahagia')->first();
        $supplierFurnitur   = Supplier::where('nama_supplier', 'Toko Aneka Furnitur')->first();
        $supplierIT         = Supplier::where('nama_supplier', 'PT. Digital Nusantara')->first();

        $barangs = [
            ['nama_barang' => 'Laptop ASUS VivoBook 15',    'kategori_id' => $elektronik->id,     'supplier_id' => $supplierElektronik->id, 'satuan' => 'Unit', 'harga_beli' => 7500000, 'harga_jual' => 8500000, 'stok' => 15, 'stok_minimal' => 3],
            ['nama_barang' => 'Monitor LED 24 inch',        'kategori_id' => $elektronik->id,     'supplier_id' => $supplierElektronik->id, 'satuan' => 'Unit', 'harga_beli' => 1800000, 'harga_jual' => 2200000, 'stok' => 10, 'stok_minimal' => 2],
            ['nama_barang' => 'Keyboard Wireless Logitech', 'kategori_id' => $perlengkapanIT->id,  'supplier_id' => $supplierIT->id,         'satuan' => 'Unit', 'harga_beli' => 350000,  'harga_jual' => 450000,  'stok' => 20, 'stok_minimal' => 5],
            ['nama_barang' => 'Mouse Optical USB',          'kategori_id' => $perlengkapanIT->id,  'supplier_id' => $supplierIT->id,         'satuan' => 'Unit', 'harga_beli' => 75000,   'harga_jual' => 120000,  'stok' => 30, 'stok_minimal' => 5],
            ['nama_barang' => 'Kertas A4 80gsm (Rim)',      'kategori_id' => $konsumables->id,    'supplier_id' => $supplierAtk->id,        'satuan' => 'Rim',  'harga_beli' => 45000,   'harga_jual' => 60000,   'stok' => 100, 'stok_minimal' => 20],
            ['nama_barang' => 'Pulpen Ballpoint Hitam',     'kategori_id' => $alatTulis->id,      'supplier_id' => $supplierAtk->id,        'satuan' => 'Lusin', 'harga_beli' => 18000,  'harga_jual' => 25000,   'stok' => 50, 'stok_minimal' => 10],
            ['nama_barang' => 'Spidol Whiteboard (Set)',    'kategori_id' => $alatTulis->id,      'supplier_id' => $supplierAtk->id,        'satuan' => 'Set',  'harga_beli' => 32000,   'harga_jual' => 45000,   'stok' => 4,  'stok_minimal' => 5],  // Stok menipis!
            ['nama_barang' => 'Kursi Kantor Ergonomis',     'kategori_id' => $furnitur->id,       'supplier_id' => $supplierFurnitur->id,   'satuan' => 'Unit', 'harga_beli' => 1200000, 'harga_jual' => 1600000, 'stok' => 8,  'stok_minimal' => 2],
            ['nama_barang' => 'Meja Kerja 120x60',          'kategori_id' => $furnitur->id,       'supplier_id' => $supplierFurnitur->id,   'satuan' => 'Unit', 'harga_beli' => 850000,  'harga_jual' => 1100000, 'stok' => 2,  'stok_minimal' => 2],  // Stok menipis!
            ['nama_barang' => 'Tinta Printer Epson L3150',  'kategori_id' => $konsumables->id,    'supplier_id' => $supplierIT->id,         'satuan' => 'Botol', 'harga_beli' => 75000,  'harga_jual' => 95000,   'stok' => 3,  'stok_minimal' => 5],  // Stok menipis!
            ['nama_barang' => 'Flashdisk 64GB USB 3.0',    'kategori_id' => $perlengkapanIT->id,  'supplier_id' => $supplierIT->id,         'satuan' => 'Unit', 'harga_beli' => 95000,   'harga_jual' => 130000,  'stok' => 25, 'stok_minimal' => 5],
            ['nama_barang' => 'Kabel HDMI 2 Meter',        'kategori_id' => $perlengkapanIT->id,  'supplier_id' => $supplierIT->id,         'satuan' => 'Unit', 'harga_beli' => 45000,   'harga_jual' => 65000,   'stok' => 15, 'stok_minimal' => 5],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang); // kode_barang auto-generate via Model boot()
        }

        $this->command->info('✅ Barang seeder selesai (' . count($barangs) . ' data).');

        // ── Buat transaksi sample ─────────────────────────────────
        $this->buatTransaksiSample();
    }

    private function buatTransaksiSample(): void
    {
        $admin  = User::first();
        $barangs = Barang::all();

        // Generate transaksi masuk untuk 14 hari terakhir
        for ($i = 13; $i >= 0; $i--) {
            $barang = $barangs->random();
            $jumlah = rand(2, 20);

            BarangMasuk::create([
                'barang_id'     => $barang->id,
                'user_id'       => $admin->id,
                'jumlah'        => $jumlah,
                'harga_beli'    => $barang->harga_beli,
                'total_harga'   => $jumlah * $barang->harga_beli,
                'tanggal_masuk' => now()->subDays($i)->toDateString(),
                'no_referensi'  => 'PO-' . now()->subDays($i)->format('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                'keterangan'    => 'Pembelian rutin',
            ]);
        }

        // Generate transaksi keluar untuk 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $barang = $barangs->random();
            $jumlah = rand(1, 5);

            BarangKeluar::create([
                'barang_id'      => $barang->id,
                'user_id'        => $admin->id,
                'jumlah'         => $jumlah,
                'harga_jual'     => $barang->harga_jual,
                'total_harga'    => $jumlah * $barang->harga_jual,
                'tanggal_keluar' => now()->subDays($i)->toDateString(),
                'no_referensi'   => 'SO-' . now()->subDays($i)->format('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                'keterangan'     => 'Pengeluaran operasional',
            ]);
        }

        $this->command->info('✅ Transaksi sample selesai (14 masuk + 7 keluar).');
    }
}
