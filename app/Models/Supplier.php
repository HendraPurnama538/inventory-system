<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Supplier - Master data pemasok/supplier.
 *
 * Relasi: hasMany Barang
 */
class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'suppliers';

    protected $fillable = [
        'nama_supplier',
        'telepon',
        'email',
        'alamat',
        'keterangan',
    ];

    /**
     * Relasi: satu supplier memiliki banyak barang
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'supplier_id');
    }

    /**
     * Scope: pencarian by nama atau telepon
     */
    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('nama_supplier', 'like', "%{$keyword}%")
                         ->orWhere('telepon', 'like', "%{$keyword}%")
                         ->orWhere('email', 'like', "%{$keyword}%");
        }
        return $query;
    }
}
