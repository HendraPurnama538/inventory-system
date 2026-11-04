@extends('layouts.app')
@section('title', 'Supplier')
@section('breadcrumb')
    <li class="breadcrumb-item active">Supplier</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Manajemen Supplier</h1>
        <p class="page-subtitle">Kelola data supplier/pemasok barang</p>
    </div>
    <a href="{{ route('supplier.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Supplier
    </a>
</div>

<div class="card fade-in-up">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" class="form-control" style="max-width:280px;"
                   placeholder="Cari nama, email, telepon..." value="{{ request('search') }}">
            <select name="sort" class="form-select" style="width:auto;">
                <option value="nama_supplier" {{ request('sort') === 'nama_supplier' ? 'selected' : '' }}>Nama</option>
                <option value="created_at"    {{ request('sort') === 'created_at' ? 'selected' : '' }}>Tgl Dibuat</option>
            </select>
            <select name="order" class="form-select" style="width:auto;">
                <option value="asc"  {{ request('order') === 'asc'  ? 'selected' : '' }}>A-Z</option>
                <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Z-A</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            @if(request('search'))
                <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:50px">No</th>
                        <th>Nama Supplier</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th class="text-center">Barang</th>
                        <th class="text-center" style="width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $item)
                    <tr>
                        <td class="ps-4">{{ $suppliers->firstItem() + $loop->index }}</td>
                        <td><div class="fw-semibold">{{ $item->nama_supplier }}</div></td>
                        <td style="font-size:.85rem;">{{ $item->telepon ?? '-' }}</td>
                        <td style="font-size:.85rem;">{{ $item->email ?? '-' }}</td>
                        <td class="text-muted" style="font-size:.85rem;">
                            {{ $item->alamat ? \Str::limit($item->alamat, 40) : '-' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info-subtle text-info">{{ $item->barangs->count() }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('supplier.edit', $item) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('supplier.destroy', $item) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus supplier {{ $item->nama_supplier }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada data supplier
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($suppliers->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">
            Menampilkan {{ $suppliers->firstItem() }}-{{ $suppliers->lastItem() }} dari {{ $suppliers->total() }} data
        </small>
        {{ $suppliers->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
