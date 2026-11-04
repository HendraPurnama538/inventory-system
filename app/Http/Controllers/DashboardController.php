<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * DashboardController - Menampilkan statistik dan grafik utama.
 *
 * Data yang ditampilkan:
 * - Jumlah barang, kategori, supplier
 * - Total nilai stok (harga beli × stok)
 * - Transaksi masuk & keluar hari ini
 * - Barang stok menipis
 * - Data grafik 7 hari terakhir (Chart.js)
 */
class DashboardController extends Controller
{
    public function index()
    {
        // ── Statistik Utama ──────────────────────────────────
        $totalBarang    = Barang::count();
        $totalKategori  = Kategori::count();
        $totalSupplier  = Supplier::count();
        $totalNilaiStok = Barang::selectRaw('SUM(harga_beli * stok) as total')
                                ->value('total') ?? 0;

        // ── Transaksi Hari Ini ───────────────────────────────
        $masukHariIni  = BarangMasuk::whereDate('tanggal_masuk', today())->sum('jumlah');
        $keluarHariIni = BarangKeluar::whereDate('tanggal_keluar', today())->sum('jumlah');

        // ── Stok Menipis ─────────────────────────────────────
        $stokMenipis = Barang::with(['kategori', 'supplier'])
            ->stokMenipis()
            ->orderBy('stok')
            ->limit(10)
            ->get();

        // ── Data Grafik: 7 Hari Terakhir ────────────────────
        $labels       = [];
        $dataMasuk    = [];
        $dataKeluar   = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal    = now()->subDays($i)->toDateString();
            $labels[]   = now()->subDays($i)->locale('id')->isoFormat('D MMM');

            $dataMasuk[]  = BarangMasuk::whereDate('tanggal_masuk', $tanggal)
                                       ->sum('jumlah');
            $dataKeluar[] = BarangKeluar::whereDate('tanggal_keluar', $tanggal)
                                        ->sum('jumlah');
        }

        // ── Distribusi Barang per Kategori (Pie Chart) ───────
        $distribusiKategori = Kategori::withCount('barangs')
            ->having('barangs_count', '>', 0)
            ->get();

        // ── Transaksi Terbaru ────────────────────────────────
        $transaksiTerbaru = collect()
            ->merge(
                BarangMasuk::with('barang', 'user')
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn($t) => array_merge($t->toArray(), ['tipe' => 'masuk', 'tanggal' => $t->tanggal_masuk]))
            )
            ->merge(
                BarangKeluar::with('barang', 'user')
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn($t) => array_merge($t->toArray(), ['tipe' => 'keluar', 'tanggal' => $t->tanggal_keluar]))
            )
            ->sortByDesc('tanggal')
            ->take(8);

        return view('dashboard.index', compact(
            'totalBarang',
            'totalKategori',
            'totalSupplier',
            'totalNilaiStok',
            'masukHariIni',
            'keluarHariIni',
            'stokMenipis',
            'labels',
            'dataMasuk',
            'dataKeluar',
            'distribusiKategori',
            'transaksiTerbaru',
        ));
    }
}
