<?php

namespace App\Http\Requests;

use App\Models\Barang;
use Illuminate\Foundation\Http\FormRequest;

/**
 * BarangKeluarRequest - Validasi input transaksi barang keluar.
 *
 * Validasi stok mencukupi dilakukan di rule 'jumlah'
 * menggunakan custom closure untuk pesan error yang informatif.
 */
class BarangKeluarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_referensi'   => ['nullable', 'string', 'max:50'],
            'barang_id'      => ['required', 'exists:barangs,id'],
            'jumlah'         => [
                'required',
                'integer',
                'min:1',
                // Custom rule: cek stok mencukupi
                function ($attribute, $value, $fail) {
                    $barang = Barang::find($this->barang_id);
                    if ($barang && $value > $barang->stok) {
                        $fail("Stok tidak mencukupi. Stok tersedia: {$barang->stok} {$barang->satuan}.");
                    }
                },
            ],
            'harga_jual'     => ['required', 'numeric', 'min:0'],
            'tanggal_keluar' => ['required', 'date', 'before_or_equal:today'],
            'keterangan'     => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'barang_id.required'         => 'Barang wajib dipilih.',
            'barang_id.exists'           => 'Barang tidak ditemukan.',
            'jumlah.required'            => 'Jumlah wajib diisi.',
            'jumlah.min'                 => 'Jumlah minimal 1.',
            'harga_jual.required'        => 'Harga jual wajib diisi.',
            'tanggal_keluar.required'    => 'Tanggal keluar wajib diisi.',
            'tanggal_keluar.before_or_equal' => 'Tanggal keluar tidak boleh melebihi hari ini.',
        ];
    }
}
