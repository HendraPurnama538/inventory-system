<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * KategoriRequest - Validasi input form tambah/edit kategori.
 */
class KategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sudah diproteksi auth middleware
    }

    public function rules(): array
    {
        return [
            'nama_kategori' => ['required', 'string', 'max:100'],
            'deskripsi'     => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ];
    }
}
