<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Barang Masuk</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 11px; color: #333; margin: 0; padding: 20px; }
    .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #10b981; padding-bottom: 12px; }
    .header h1 { font-size: 16px; margin: 0 0 4px; color: #065f46; }
    .header p  { margin: 0; font-size: 10px; color: #666; }
    .meta { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 10px; color: #555; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background: #10b981; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; }
    td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; }
    tr:nth-child(even) { background: #f0fdf4; }
    .text-right { text-align: right; }
    tfoot td { font-weight: bold; background: #d1fae5; }
    .footer { margin-top: 20px; font-size: 9px; color: #aaa; text-align: right; }
</style>
</head>
<body>

<div class="header">
    <h1>LAPORAN BARANG MASUK</h1>
    <p>Sistem Inventaris Barang &mdash; Dicetak: {{ now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</p>
</div>

@if(isset($request) && ($request->dari || $request->sampai))
<div class="meta">
    <span>Periode: {{ $request->dari ?? '—' }} s/d {{ $request->sampai ?? '—' }}</span>
    <span>Total: {{ $transaksis->count() }} transaksi</span>
</div>
@endif

<table>
    <thead>
        <tr>
            <th style="width:30px">No</th>
            <th style="width:90px">No. Referensi</th>
            <th style="width:75px">Tanggal</th>
            <th>Nama Barang</th>
            <th class="text-right" style="width:50px">Jumlah</th>
            <th style="width:40px">Satuan</th>
            <th class="text-right" style="width:80px">Harga Beli</th>
            <th class="text-right" style="width:90px">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksis as $i => $t)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $t->no_referensi ?? '-' }}</td>
            <td>{{ $t->tanggal_masuk->format('d/m/Y') }}</td>
            <td>{{ $t->barang->nama_barang ?? '-' }}</td>
            <td class="text-right">{{ $t->jumlah }}</td>
            <td>{{ $t->barang->satuan ?? '' }}</td>
            <td class="text-right">{{ number_format($t->harga_beli, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($t->total_harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right">TOTAL</td>
            <td class="text-right">{{ $transaksis->sum('jumlah') }}</td>
            <td></td>
            <td></td>
            <td class="text-right">Rp {{ number_format($transaksis->sum('total_harga'), 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>

<div class="footer">Laporan dihasilkan otomatis oleh Sistem Inventaris</div>

</body>
</html>
