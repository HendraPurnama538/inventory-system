<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model BarangKeluar - Transaksi pengeluaran/penjualan barang.
 *
 * Validasi stok mencukupi dilakukan di BarangKeluarRequest
 * sebelum data ini dibuat. Pengurangan stok dilakukan
 * di StokService setelah record berhasil disimpan.
 */
class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluars';

    protected $fillable = [
        'no_referensi',
        'barang_id',
        'user_id',
        'jumlah',
        'harga_jual',
        'total_harga',
        'tanggal_keluar',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
        'harga_jual'     => 'decimal:2',
        'total_harga'    => 'decimal:2',
        'jumlah'         => 'integer',
    ];

    // =========================================================
    // RELASI
    // =========================================================

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // =========================================================
    // SCOPES
    // =========================================================

    public function scopeFilterTanggal($query, $dari, $sampai)
    {
        if ($dari && $sampai) {
            return $query->whereBetween('tanggal_keluar', [$dari, $sampai]);
        }
        return $query;
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('no_referensi', 'like', "%{$keyword}%")
                ->orWhereHas('barang', fn($q) => $q->where('nama_barang', 'like', "%{$keyword}%"));
        }
        return $query;
    }
}
