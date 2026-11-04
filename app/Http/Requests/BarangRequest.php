<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * BarangRequest - Validasi input form tambah/edit barang.
 *
 * Catatan: kode_barang tidak perlu divalidasi karena
 * di-generate otomatis via Model boot() event 'creating'.
 */
class BarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_barang'  => ['required', 'string', 'max:200'],
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'supplier_id'  => ['required', 'exists:suppliers,id'],
            'satuan'       => ['required', 'string', 'max:50'],
            'harga_beli'   => ['required', 'numeric', 'min:0'],
            'harga_jual'   => ['required', 'numeric', 'min:0'],
            'stok'         => ['required', 'integer', 'min:0'],
            'stok_minimal' => ['required', 'integer', 'min:0'],
            'gambar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'keterangan'   => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_barang.required'  => 'Nama barang wajib diisi.',
            'kategori_id.required'  => 'Kategori wajib dipilih.',
            'kategori_id.exists'    => 'Kategori tidak valid.',
            'supplier_id.required'  => 'Supplier wajib dipilih.',
            'supplier_id.exists'    => 'Supplier tidak valid.',
            'satuan.required'       => 'Satuan wajib diisi.',
            'harga_beli.required'   => 'Harga beli wajib diisi.',
            'harga_beli.numeric'    => 'Harga beli harus berupa angka.',
            'harga_jual.required'   => 'Harga jual wajib diisi.',
            'harga_jual.numeric'    => 'Harga jual harus berupa angka.',
            'stok.required'         => 'Stok awal wajib diisi.',
            'stok.integer'          => 'Stok harus berupa bilangan bulat.',
            'stok_minimal.required' => 'Stok minimal wajib diisi.',
            'gambar.image'          => 'File harus berupa gambar.',
            'gambar.mimes'          => 'Format gambar: jpg, jpeg, png, webp.',
            'gambar.max'            => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
