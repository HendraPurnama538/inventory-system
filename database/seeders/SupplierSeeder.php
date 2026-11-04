<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

/**
 * SupplierSeeder - Data contoh supplier.
 */
class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'nama_supplier' => 'PT. Maju Jaya Elektronik',
                'telepon'       => '021-55123456',
                'email'         => 'info@majujaya.com',
                'alamat'        => 'Jl. Industri No. 10, Jakarta Barat',
                'keterangan'    => 'Supplier utama elektronik dan komputer',
            ],
            [
                'nama_supplier' => 'CV. Sumber Bahagia',
                'telepon'       => '0274-889012',
                'email'         => 'cv.sumberb@gmail.com',
                'alamat'        => 'Jl. Malioboro No. 45, Yogyakarta',
                'keterangan'    => 'Supplier alat tulis dan perlengkapan kantor',
            ],
            [
                'nama_supplier' => 'Toko Aneka Furnitur',
                'telepon'       => '031-77654321',
                'email'         => 'anekafurnitur@yahoo.com',
                'alamat'        => 'Jl. Darmo No. 22, Surabaya',
                'keterangan'    => 'Supplier furnitur dan perabot kantor',
            ],
            [
                'nama_supplier' => 'PT. Digital Nusantara',
                'telepon'       => '022-91234567',
                'email'         => 'sales@digitalnusantara.co.id',
                'alamat'        => 'Jl. IT Del No. 1, Bandung',
                'keterangan'    => 'Supplier perangkat IT dan networking',
            ],
            [
                'nama_supplier' => 'UD. Bersih Selalu',
                'telepon'       => '0341-442211',
                'email'         => 'ud.bersih@gmail.com',
                'alamat'        => 'Jl. Veteran No. 15, Malang',
                'keterangan'    => 'Supplier perlengkapan kebersihan',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::updateOrCreate(
                ['nama_supplier' => $supplier['nama_supplier']],
                $supplier
            );
        }

        $this->command->info('✅ Supplier seeder selesai (' . count($suppliers) . ' data).');
    }
}
