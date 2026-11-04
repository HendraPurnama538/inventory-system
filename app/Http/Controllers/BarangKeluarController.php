<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangKeluarRequest;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Services\StokService;
use Illuminate\Http\Request;

/**
 * BarangKeluarController - Menangani transaksi pengeluaran barang.
 *
 * Menggunakan StokService yang akan memvalidasi stok
 * mencukupi sebelum menyimpan transaksi.
 */
class BarangKeluarController extends Controller
{
    public function __construct(private StokService $stokService) {}

    public function index(Request $request)
    {
        $transaksis = BarangKeluar::with(['barang', 'user'])
            ->search($request->search)
            ->filterTanggal($request->dari, $request->sampai)
            ->when($request->barang_id, fn($q) => $q->where('barang_id', $request->barang_id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $barangs = Barang::orderBy('nama_barang')->get();

        return view('barang-keluar.index', compact('transaksis', 'barangs'));
    }

    public function create()
    {
        $barangs = Barang::where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view('barang-keluar.create', compact('barangs'));
    }

    public function store(BarangKeluarRequest $request)
    {
        try {
            $this->stokService->keluar(array_merge(
                $request->validated(),
                ['user_id' => auth()->id()]
            ));

            return redirect()->route('barang-keluar.index')
                ->with('success', 'Transaksi barang keluar berhasil disimpan. Stok diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(BarangKeluar $barangKeluar)
    {
        $barangKeluar->load(['barang.kategori', 'barang.supplier', 'user']);

        return view('barang-keluar.show', compact('barangKeluar'));
    }
}
