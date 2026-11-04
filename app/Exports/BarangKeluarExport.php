<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangKeluarExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}

    public function collection()
    {
        return BarangKeluar::with(['barang', 'user'])
            ->filterTanggal($this->filters['dari'] ?? null, $this->filters['sampai'] ?? null)
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No', 'No. Referensi', 'Tanggal Keluar', 'Kode Barang', 'Nama Barang',
            'Jumlah', 'Satuan', 'Harga Jual', 'Total Harga', 'Admin', 'Keterangan',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->no_referensi ?? '-',
            $row->tanggal_keluar->format('d/m/Y'),
            $row->barang->kode_barang ?? '-',
            $row->barang->nama_barang ?? '-',
            $row->jumlah,
            $row->barang->satuan ?? '-',
            $row->harga_jual,
            $row->total_harga,
            $row->user->name ?? '-',
            $row->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
