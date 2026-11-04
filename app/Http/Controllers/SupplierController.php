<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

/**
 * SupplierController - Resource Controller CRUD Supplier.
 */
class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::search($request->search)
            ->orderBy($request->get('sort', 'nama_supplier'), $request->get('order', 'asc'))
            ->paginate(10)
            ->withQueryString();

        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(SupplierRequest $request)
    {
        Supplier::create($request->validated());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->barangs()->exists()) {
            return back()->with('error',
                "Supplier '{$supplier->nama_supplier}' tidak dapat dihapus karena masih memiliki data barang."
            );
        }

        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
