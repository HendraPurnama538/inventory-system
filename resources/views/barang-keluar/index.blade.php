@extends('layouts.app')
@section('title', 'Barang Keluar')
@section('breadcrumb')
    <li class="breadcrumb-item active">Barang Keluar</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Transaksi Barang Keluar</h1>
        <p class="page-subtitle">Riwayat pengeluaran barang</p>
    </div>
    <a href="{{ route('barang-keluar.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-lg me-1"></i>Catat Barang Keluar
    </a>
</div>

<div class="card mb-3 fade-in-up">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <input type="text" name="search" class="form-control" style="max-width:200px;"
                   placeholder="Cari no. referensi..." value="{{ request('search') }}">
            <select name="barang_id" class="form-select" style="width:auto;">
                <option value="">Semua Barang</option>
                @foreach($barangs as $b)
                    <option value="{{ $b->id }}" {{ request('barang_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_barang }}</option>
                @endforeach
            </select>
            <input type="date" name="dari" class="form-control" style="width:auto;" value="{{ request('dari') }}">
            <span class="text-muted">s/d</span>
            <input type="date" name="sampai" class="form-control" style="width:auto;" value="{{ request('sampai') }}">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            @if(request()->hasAny(['search','barang_id','dari','sampai']))
                <a href="{{ route('barang-keluar.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                        <th class="ps-4">No</th>
                        <th>No. Referensi</th>
                        <th>Barang</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Harga Jual</th>
                        <th class="text-end">Total</th>
                        <th>Tanggal</th>
                        <th>Admin</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $item)
                    <tr>
                        <td class="ps-4">{{ $transaksis->firstItem() + $loop->index }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $item->no_referensi ?? '-' }}</span></td>
                        <td>
                            <div class="fw-semibold" style="font-size:.875rem;">{{ $item->barang->nama_barang ?? '-' }}</div>
                            <div class="text-muted" style="font-size:.75rem;">{{ $item->barang->kode_barang ?? '' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger">-{{ $item->jumlah }} {{ $item->barang->satuan ?? '' }}</span>
                        </td>
                        <td class="text-end" style="font-size:.85rem;">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-end fw-semibold" style="font-size:.85rem;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td style="font-size:.85rem;">{{ $item->tanggal_keluar->locale('id')->isoFormat('D MMM Y') }}</td>
                        <td style="font-size:.85rem;">{{ $item->user->name ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('barang-keluar.show', $item) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada transaksi barang keluar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transaksis->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">{{ $transaksis->firstItem() }}-{{ $transaksis->lastItem() }} dari {{ $transaksis->total() }}</small>
        {{ $transaksis->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
