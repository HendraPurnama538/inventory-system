<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User - Admin yang mengakses sistem inventaris.
 * Extends Authenticatable untuk fitur login Laravel.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Relasi: satu user memiliki banyak transaksi masuk
     */
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    /**
     * Relasi: satu user memiliki banyak transaksi keluar
     */
    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }

    /**
     * Accessor: URL avatar (fallback ke default jika kosong)
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(storage_path('app/public/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/default-avatar.png');
    }
}
