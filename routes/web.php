<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Inventaris Barang
|--------------------------------------------------------------------------
|
| Struktur routing:
| - Guest routes  : Login/logout (tanpa auth)
| - Auth routes   : Semua fitur utama (dilindungi middleware auth)
|
*/

// ── Redirect root ke dashboard ────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('dashboard'));

// ── Guest Routes (hanya untuk belum login) ────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// ── Authenticated Routes (harus login) ───────────────────────────────────
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data: Kategori
    Route::resource('kategori', KategoriController::class)
        ->except(['show']);

    // Master Data: Supplier
    Route::resource('supplier', SupplierController::class)
        ->except(['show']);

    // Master Data: Barang
    Route::resource('barang', BarangController::class);

    // Transaksi: Barang Masuk
    Route::resource('barang-masuk', BarangMasukController::class)
        ->only(['index', 'create', 'store', 'show']);

    // Transaksi: Barang Keluar
    Route::resource('barang-keluar', BarangKeluarController::class)
        ->only(['index', 'create', 'store', 'show']);

    // Laporan & Export
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');

        // PDF
        Route::get('/pdf/barang', [LaporanController::class, 'pdfBarang'])->name('pdf.barang');
        Route::get('/pdf/masuk', [LaporanController::class, 'pdfMasuk'])->name('pdf.masuk');
        Route::get('/pdf/keluar', [LaporanController::class, 'pdfKeluar'])->name('pdf.keluar');

        // Excel
        Route::get('/excel/barang', [LaporanController::class, 'excelBarang'])->name('excel.barang');
        Route::get('/excel/masuk', [LaporanController::class, 'excelMasuk'])->name('excel.masuk');
        Route::get('/excel/keluar', [LaporanController::class, 'excelKeluar'])->name('excel.keluar');
    });

    // Profil Admin
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

    // AJAX: Ambil data stok barang (untuk form barang keluar)
    Route::get('/api/barang/{barang}/stok', function (\App\Models\Barang $barang) {
        return response()->json([
            'stok'       => $barang->stok,
            'satuan'     => $barang->satuan,
            'harga_jual' => $barang->harga_jual,
            'harga_beli' => $barang->harga_beli,
        ]);
    })->name('api.barang.stok');
});
