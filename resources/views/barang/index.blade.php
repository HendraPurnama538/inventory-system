@extends('layouts.app')
@section('title', 'Data Barang')
@section('breadcrumb')
    <li class="breadcrumb-item active">Data Barang</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Data Barang</h1>
        <p class="page-subtitle">Kelola seluruh data barang inventaris</p>
    </div>
    <a href="{{ route('barang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Barang
    </a>
</div>

{{-- Filter --}}
<div class="card mb-3 fade-in-up">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <input type="text" name="search" class="form-control" style="max-width:220px;"
                   placeholder="Cari nama/kode barang..." value="{{ request('search') }}">
            <select name="kategori_id" class="form-select" style="width:auto;">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
            <select name="supplier_id" class="form-select" style="width:auto;">
                <option value="">Semua Supplier</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>
                        {{ $sup->nama_supplier }}
                    </option>
                @endforeach
            </select>
            <select name="sort" class="form-select" style="width:auto;">
                <option value="nama_barang"  {{ request('sort') === 'nama_barang'  ? 'selected' : '' }}>Nama</option>
                <option value="stok"         {{ request('sort') === 'stok'         ? 'selected' : '' }}>Stok</option>
                <option value="harga_jual"   {{ request('sort') === 'harga_jual'   ? 'selected' : '' }}>Harga</option>
                <option value="created_at"   {{ request('sort') === 'created_at'   ? 'selected' : '' }}>Terbaru</option>
            </select>
            <select name="order" class="form-select" style="width:auto;">
                <option value="asc"  {{ request('order') === 'asc'  ? 'selected' : '' }}>↑ Naik</option>
                <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>↓ Turun</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            @if(request()->hasAny(['search','kategori_id','supplier_id']))
                <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i> Reset
                </a>
            @endif
        </form>
    </div>
</div>

<div class="card fade-in-up">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:50px">No</th>
                        <th style="width:80px">Gambar</th>
                        <th>Kode / Nama</th>
                        <th>Kategori</th>
                        <th>Supplier</th>
                        <th class="text-end">Harga Jual</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center" style="width:130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $item)
                    <tr>
                        <td class="ps-4">{{ $barangs->firstItem() + $loop->index }}</td>
                        <td>
                            <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_barang }}"
                                 width="48" height="48"
                                 class="rounded object-fit-cover"
                                 style="border:1px solid #e2e8f0;">
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $item->nama_barang }}</div>
                            <div class="text-muted" style="font-size:.75rem;">{{ $item->kode_barang }}</div>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary">
                                {{ $item->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td style="font-size:.85rem;">{{ $item->supplier->nama_supplier ?? '-' }}</td>
                        <td class="text-end fw-semibold" style="font-size:.85rem;">
                            Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if($item->is_stok_menipis)
                                <span class="badge bg-danger">{{ $item->stok }} <small>{{ $item->satuan }}</small></span>
                                <div style="font-size:.7rem;" class="text-danger">
                                    <i class="bi bi-exclamation-triangle"></i> Menipis
                                </div>
                            @else
                                <span class="badge bg-success">{{ $item->stok }} <small>{{ $item->satuan }}</small></span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('barang.show', $item) }}"
                               class="btn btn-sm btn-outline-info me-1" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('barang.edit', $item) }}"
                               class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('barang.destroy', $item) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus barang {{ $item->nama_barang }}?\nData yang memiliki transaksi tidak dapat dihapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
                            Belum ada data barang
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($barangs->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">
            Menampilkan {{ $barangs->firstItem() }}-{{ $barangs->lastItem() }} dari {{ $barangs->total() }} data
        </small>
        {{ $barangs->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
