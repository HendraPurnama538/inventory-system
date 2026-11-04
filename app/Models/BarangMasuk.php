<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model BarangMasuk - Transaksi penerimaan/pembelian barang.
 *
 * Setiap kali record ini dibuat (event 'created'),
 * stok barang akan otomatis bertambah via StokService.
 */
class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuks';

    protected $fillable = [
        'no_referensi',
        'barang_id',
        'user_id',
        'jumlah',
        'harga_beli',
        'total_harga',
        'tanggal_masuk',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'harga_beli'    => 'decimal:2',
        'total_harga'   => 'decimal:2',
        'jumlah'        => 'integer',
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
            return $query->whereBetween('tanggal_masuk', [$dari, $sampai]);
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
