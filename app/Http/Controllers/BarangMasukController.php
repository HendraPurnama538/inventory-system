<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangMasukRequest;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Services\StokService;
use Illuminate\Http\Request;

/**
 * BarangMasukController - Menangani transaksi penerimaan barang.
 *
 * Menggunakan StokService untuk memastikan stok
 * diupdate dalam DB transaction yang aman.
 */
class BarangMasukController extends Controller
{
    public function __construct(private StokService $stokService) {}

    public function index(Request $request)
    {
        $transaksis = BarangMasuk::with(['barang', 'user'])
            ->search($request->search)
            ->filterTanggal($request->dari, $request->sampai)
            ->when($request->barang_id, fn($q) => $q->where('barang_id', $request->barang_id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $barangs = Barang::orderBy('nama_barang')->get();

        return view('barang-masuk.index', compact('transaksis', 'barangs'));
    }

    public function create()
    {
        $barangs = Barang::with('satuan')->orderBy('nama_barang')->get();

        return view('barang-masuk.create', compact('barangs'));
    }

    public function store(BarangMasukRequest $request)
    {
        try {
            $this->stokService->masuk(array_merge(
                $request->validated(),
                ['user_id' => auth()->id()]
            ));

            return redirect()->route('barang-masuk.index')
                ->with('success', 'Transaksi barang masuk berhasil disimpan. Stok diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function show(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load(['barang.kategori', 'barang.supplier', 'user']);

        return view('barang-masuk.show', compact('barangMasuk'));
    }
}
