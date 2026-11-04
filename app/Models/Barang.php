<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Barang - Master data barang inventaris.
 *
 * Fitur khusus:
 * - Kode barang di-generate otomatis via boot() event 'creating'
 * - Format: BRG-YYYYMM-XXXX (contoh: BRG-202608-0001)
 * - Accessor gambar URL untuk tampilan
 */
class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'supplier_id',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimal',
        'gambar',
        'keterangan',
    ];

    protected $casts = [
        'harga_beli'  => 'decimal:2',
        'harga_jual'  => 'decimal:2',
        'stok'        => 'integer',
        'stok_minimal' => 'integer',
    ];

    /**
     * Auto-generate kode barang saat data baru dibuat.
     * Format: BRG-YYYYMM-XXXX (XXXX = nomor urut 4 digit per bulan)
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($barang) {
            if (empty($barang->kode_barang)) {
                $prefix   = 'BRG-' . now()->format('Ym') . '-';
                $lastCode = static::where('kode_barang', 'like', $prefix . '%')
                    ->orderByDesc('kode_barang')
                    ->value('kode_barang');

                $nextNumber = $lastCode
                    ? (int) substr($lastCode, -4) + 1
                    : 1;

                $barang->kode_barang = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // =========================================================
    // RELASI
    // =========================================================

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }

    // =========================================================
    // ACCESSOR
    // =========================================================

    /**
     * URL gambar barang — fallback ke placeholder jika kosong.
     */
    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar && file_exists(storage_path('app/public/' . $this->gambar))) {
            return asset('storage/' . $this->gambar);
        }
        return asset('images/no-image.png');
    }

    /**
     * Cek apakah stok menipis (stok ≤ stok_minimal)
     */
    public function getIsStokMenipisAttribute(): bool
    {
        return $this->stok <= $this->stok_minimal;
    }

    // =========================================================
    // SCOPES
    // =========================================================

    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('nama_barang', 'like', "%{$keyword}%")
                  ->orWhere('kode_barang', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }

    public function scopeFilterKategori($query, $kategoriId)
    {
        if ($kategoriId) {
            return $query->where('kategori_id', $kategoriId);
        }
        return $query;
    }

    public function scopeFilterSupplier($query, $supplierId)
    {
        if ($supplierId) {
            return $query->where('supplier_id', $supplierId);
        }
        return $query;
    }

    public function scopeStokMenipis($query)
    {
        return $query->whereColumn('stok', '<=', 'stok_minimal');
    }
}
