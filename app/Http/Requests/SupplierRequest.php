<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * SupplierRequest - Validasi input form tambah/edit supplier.
 */
class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_supplier' => ['required', 'string', 'max:150'],
            'telepon'       => ['nullable', 'string', 'max:20'],
            'email'         => ['nullable', 'email', 'max:100'],
            'alamat'        => ['nullable', 'string', 'max:500'],
            'keterangan'    => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
        ];
    }
}
