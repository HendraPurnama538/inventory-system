<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Data Barang</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 11px; color: #333; margin: 0; padding: 20px; }
    .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4f46e5; padding-bottom: 12px; }
    .header h1 { font-size: 16px; margin: 0 0 4px; color: #1e1b4b; }
    .header p  { margin: 0; font-size: 10px; color: #666; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background: #4f46e5; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; }
    td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; }
    tr:nth-child(even) { background: #f9fafb; }
    .badge-warning { background: #fef3c7; color: #92400e; padding: 2px 6px; border-radius: 4px; font-size: 9px; }
    .badge-ok      { background: #d1fae5; color: #065f46; padding: 2px 6px; border-radius: 4px; font-size: 9px; }
    .footer { margin-top: 20px; font-size: 9px; color: #aaa; text-align: right; }
    .text-right { text-align: right; }
</style>
</head>
<body>

<div class="header">
    <h1>LAPORAN DATA BARANG</h1>
    <p>Sistem Inventaris Barang &mdash; Dicetak: {{ now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th style="width:30px">No</th>
            <th style="width:100px">Kode</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th style="width:40px">Satuan</th>
            <th class="text-right" style="width:80px">Harga Beli</th>
            <th class="text-right" style="width:80px">Harga Jual</th>
            <th class="text-right" style="width:50px">Stok</th>
            <th style="width:60px">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangs as $i => $b)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $b->kode_barang }}</td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $b->supplier->nama_supplier ?? '-' }}</td>
            <td>{{ $b->satuan }}</td>
            <td class="text-right">{{ number_format($b->harga_beli, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($b->harga_jual, 0, ',', '.') }}</td>
            <td class="text-right">{{ $b->stok }}</td>
            <td>
                @if($b->is_stok_menipis)
                    <span class="badge-warning">Menipis</span>
                @else
                    <span class="badge-ok">Normal</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Total: {{ $barangs->count() }} barang &mdash; Laporan dihasilkan otomatis oleh Sistem Inventaris
</div>

</body>
</html>
