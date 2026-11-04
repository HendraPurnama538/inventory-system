@extends('layouts.app')
@section('title', 'Kategori')
@section('breadcrumb')
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Manajemen Kategori</h1>
        <p class="page-subtitle">Kelola kategori barang inventaris</p>
    </div>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
    </a>
</div>

<div class="card fade-in-up">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" class="form-control" style="max-width:260px;"
                   placeholder="Cari nama kategori..." value="{{ request('search') }}">
            <select name="sort" class="form-select" style="width:auto;">
                <option value="nama_kategori" {{ request('sort') === 'nama_kategori' ? 'selected' : '' }}>Nama</option>
                <option value="created_at"    {{ request('sort') === 'created_at' ? 'selected' : '' }}>Tgl Dibuat</option>
            </select>
            <select name="order" class="form-select" style="width:auto;">
                <option value="asc"  {{ request('order') === 'asc'  ? 'selected' : '' }}>A-Z</option>
                <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Z-A</option>
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:50px">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Jumlah Barang</th>
                        <th class="text-center" style="width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $item)
                    <tr>
                        <td class="ps-4">{{ $kategoris->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold">{{ $item->nama_kategori }}</div>
                        </td>
                        <td class="text-muted" style="font-size:.85rem;">{{ $item->deskripsi ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary">
                                {{ $item->barangs->count() }} barang
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('kategori.edit', $item) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('kategori.destroy', $item) }}"
                                  class="d-inline" onsubmit="return confirm('Hapus kategori {{ $item->nama_kategori }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada data kategori
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($kategoris->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">
            Menampilkan {{ $kategoris->firstItem() }}-{{ $kategoris->lastItem() }} dari {{ $kategoris->total() }} data
        </small>
        {{ $kategoris->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
