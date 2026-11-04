<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * BarangMasukRequest - Validasi input transaksi barang masuk.
 */
class BarangMasukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_referensi'  => ['nullable', 'string', 'max:50'],
            'barang_id'     => ['required', 'exists:barangs,id'],
            'jumlah'        => ['required', 'integer', 'min:1'],
            'harga_beli'    => ['required', 'numeric', 'min:0'],
            'tanggal_masuk' => ['required', 'date', 'before_or_equal:today'],
            'keterangan'    => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'barang_id.required'        => 'Barang wajib dipilih.',
            'barang_id.exists'          => 'Barang tidak ditemukan.',
            'jumlah.required'           => 'Jumlah wajib diisi.',
            'jumlah.min'                => 'Jumlah minimal 1.',
            'harga_beli.required'       => 'Harga beli wajib diisi.',
            'tanggal_masuk.required'    => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.before_or_equal' => 'Tanggal masuk tidak boleh melebihi hari ini.',
        ];
    }
}
