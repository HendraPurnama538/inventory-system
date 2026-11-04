<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

/**
 * LaporanController - Export data ke PDF dan Excel.
 *
 * PDF  : Menggunakan barryvdh/laravel-dompdf
 * Excel: Menggunakan maatwebsite/excel
 */
class LaporanController extends Controller
{
    /**
     * Halaman index laporan (filter & preview)
     */
    public function index()
    {
        return view('laporan.index');
    }

    // =========================================================
    // PDF EXPORTS
    // =========================================================

    /**
     * Export daftar barang ke PDF
     */
    public function pdfBarang(Request $request)
    {
        $barangs = Barang::with(['kategori', 'supplier'])
            ->when($request->kategori_id, fn($q) => $q->where('kategori_id', $request->kategori_id))
            ->orderBy('nama_barang')
            ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.pdf-barang', compact('barangs'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-' . now()->format('Ymd-His') . '.pdf');
    }

    /**
     * Export laporan transaksi masuk ke PDF
     */
    public function pdfMasuk(Request $request)
    {
        $transaksis = BarangMasuk::with(['barang', 'user'])
            ->filterTanggal($request->dari, $request->sampai)
            ->latest()
            ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.pdf-transaksi-masuk', compact('transaksis', 'request'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-masuk-' . now()->format('Ymd-His') . '.pdf');
    }

    /**
     * Export laporan transaksi keluar ke PDF
     */
    public function pdfKeluar(Request $request)
    {
        $transaksis = BarangKeluar::with(['barang', 'user'])
            ->filterTanggal($request->dari, $request->sampai)
            ->latest()
            ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.pdf-transaksi-keluar', compact('transaksis', 'request'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-keluar-' . now()->format('Ymd-His') . '.pdf');
    }

    // =========================================================
    // EXCEL EXPORTS
    // =========================================================

    /**
     * Export daftar barang ke Excel
     */
    public function excelBarang(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\BarangExport($request->all()),
            'laporan-barang-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    /**
     * Export transaksi masuk ke Excel
     */
    public function excelMasuk(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\BarangMasukExport($request->all()),
            'laporan-barang-masuk-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    /**
     * Export transaksi keluar ke Excel
     */
    public function excelKeluar(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\BarangKeluarExport($request->all()),
            'laporan-barang-keluar-' . now()->format('Ymd-His') . '.xlsx'
        );
    }
}
