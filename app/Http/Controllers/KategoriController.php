<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;

/**
 * KategoriController - Resource Controller CRUD Kategori.
 *
 * Routes yang dihandle:
 *   GET    /kategori          → index()
 *   GET    /kategori/create   → create()
 *   POST   /kategori          → store()
 *   GET    /kategori/{id}/edit → edit()
 *   PUT    /kategori/{id}     → update()
 *   DELETE /kategori/{id}     → destroy()
 */
class KategoriController extends Controller
{
    /**
     * Tampilkan daftar semua kategori dengan pencarian & pagination.
     */
    public function index(Request $request)
    {
        $kategoris = Kategori::search($request->search)
            ->orderBy($request->get('sort', 'nama_kategori'), $request->get('order', 'asc'))
            ->paginate(10)
            ->withQueryString(); // Pertahankan parameter saat pindah halaman

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Tampilkan form tambah kategori.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(KategoriRequest $request)
    {
        Kategori::create($request->validated());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kategori.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update data kategori.
     */
    public function update(KategoriRequest $request, Kategori $kategori)
    {
        $kategori->update($request->validated());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori (soft delete).
     * Cek terlebih dahulu apakah ada barang yang terkait.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->barangs()->exists()) {
            return back()->with('error',
                "Kategori '{$kategori->nama_kategori}' tidak dapat dihapus karena masih memiliki data barang."
            );
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
