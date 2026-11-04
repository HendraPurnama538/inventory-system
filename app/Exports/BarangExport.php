<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * BarangExport - Export daftar barang ke Excel.
 */
class BarangExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}

    public function collection()
    {
        return Barang::with(['kategori', 'supplier'])
            ->when($this->filters['kategori_id'] ?? null, fn($q) => $q->where('kategori_id', $this->filters['kategori_id']))
            ->orderBy('nama_barang')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No', 'Kode Barang', 'Nama Barang', 'Kategori', 'Supplier',
            'Satuan', 'Harga Beli', 'Harga Jual', 'Stok', 'Stok Minimal', 'Status Stok',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->kode_barang,
            $row->nama_barang,
            $row->kategori->nama_kategori ?? '-',
            $row->supplier->nama_supplier ?? '-',
            $row->satuan,
            $row->harga_beli,
            $row->harga_jual,
            $row->stok,
            $row->stok_minimal,
            $row->is_stok_menipis ? 'Stok Menipis' : 'Normal',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
