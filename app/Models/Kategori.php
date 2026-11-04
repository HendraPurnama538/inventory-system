<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Kategori - Master kategori barang.
 *
 * Relasi: hasMany Barang
 * SoftDelete: data tidak benar-benar dihapus agar
 *             histori transaksi tetap terjaga.
 */
class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Relasi: satu kategori memiliki banyak barang
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }

    /**
     * Scope: pencarian by nama kategori
     */
    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('nama_kategori', 'like', "%{$keyword}%")
                         ->orWhere('deskripsi', 'like', "%{$keyword}%");
        }
        return $query;
    }
}
