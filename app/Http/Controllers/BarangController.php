<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangRequest;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * BarangController - Resource Controller CRUD Barang.
 *
 * Fitur khusus:
 * - Upload & resize gambar barang
 * - Kode barang auto-generate via Model boot()
 * - Filter by kategori & supplier
 */
class BarangController extends Controller
{
    public function index(Request $request)
    {
        $barangs = Barang::with(['kategori', 'supplier'])
            ->search($request->search)
            ->filterKategori($request->kategori_id)
            ->filterSupplier($request->supplier_id)
            ->orderBy($request->get('sort', 'nama_barang'), $request->get('order', 'asc'))
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('barang.index', compact('barangs', 'kategoris', 'suppliers'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('barang.create', compact('kategoris', 'suppliers'));
    }

    public function store(BarangRequest $request)
    {
        $data = $request->validated();

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'supplier']);

        $riwayatMasuk = $barang->barangMasuks()
            ->with('user')
            ->latest('tanggal_masuk')
            ->limit(10)
            ->get();

        $riwayatKeluar = $barang->barangKeluars()
            ->with('user')
            ->latest('tanggal_keluar')
            ->limit(10)
            ->get();

        return view('barang.show', compact('barang', 'riwayatMasuk', 'riwayatKeluar'));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('barang.edit', compact('barang', 'kategoris', 'suppliers'));
    }

    public function update(BarangRequest $request, Barang $barang)
    {
        $data = $request->validated();

        // Handle ganti gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $data['gambar'] = $request->file('gambar')
                ->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        // Cek apakah ada transaksi terkait
        if ($barang->barangMasuks()->exists() || $barang->barangKeluars()->exists()) {
            return back()->with('error',
                "Barang '{$barang->nama_barang}' tidak dapat dihapus karena memiliki riwayat transaksi."
            );
        }

        // Hapus gambar dari storage
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
