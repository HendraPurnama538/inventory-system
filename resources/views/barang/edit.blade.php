@extends('layouts.app')
@section('title', 'Edit Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('styles')
<style>
    .img-preview { width:100%; height:180px; object-fit:cover; border-radius:10px; border:2px solid #4f46e5; }
</style>
@endpush

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Edit Barang</h1>
        <p class="page-subtitle">{{ $barang->kode_barang }} — {{ $barang->nama_barang }}</p>
    </div>
    <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-3 fade-in-up">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil me-2 text-warning"></i>Edit Informasi Barang</div>
            <div class="card-body">
                <form method="POST" action="{{ route('barang.update', $barang) }}"
                      enctype="multipart/form-data" id="formBarang">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" value="{{ $barang->kode_barang }}" disabled>
                            <div class="form-text">Kode barang tidak dapat diubah</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang"
                                   class="form-control @error('nama_barang') is-invalid @enderror"
                                   value="{{ old('nama_barang', $barang->nama_barang) }}">
                            @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id', $barang->kategori_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Supplier <span class="text-danger">*</span></label>
                            <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}" {{ old('supplier_id', $barang->supplier_id) == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="satuan" class="form-control"
                                   value="{{ old('satuan', $barang->satuan) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga Beli</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_beli" min="0"
                                       class="form-control"
                                       value="{{ old('harga_beli', $barang->harga_beli) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga Jual</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_jual" min="0"
                                       class="form-control"
                                       value="{{ old('harga_jual', $barang->harga_jual) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stok Saat Ini</label>
                            <input type="number" name="stok" min="0"
                                   class="form-control"
                                   value="{{ old('stok', $barang->stok) }}">
                            <div class="form-text text-warning">
                                <i class="bi bi-info-circle"></i> Ubah stok via transaksi masuk/keluar
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stok Minimal</label>
                            <input type="number" name="stok_minimal" min="0"
                                   class="form-control"
                                   value="{{ old('stok_minimal', $barang->stok_minimal) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" rows="2" class="form-control">{{ old('keterangan', $barang->keterangan) }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-warning flex-grow-1">
                                <i class="bi bi-save me-1"></i>Perbarui Barang
                            </button>
                            <a href="{{ route('barang.show', $barang) }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-image me-2 text-primary"></i>Gambar Barang</div>
            <div class="card-body text-center">
                <img id="imgPreview" src="{{ $barang->gambar_url }}" alt="{{ $barang->nama_barang }}"
                     class="img-preview mb-3">
                <label for="gambarInput" class="btn btn-outline-primary w-100">
                    <i class="bi bi-upload me-1"></i>Ganti Gambar
                </label>
                <input type="file" id="gambarInput" name="gambar" accept="image/*"
                       class="d-none" form="formBarang">
                <div class="form-text mt-2">JPG, PNG, WebP — Maks. 2MB</div>
                @error('gambar')
                    <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('gambarInput').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => document.getElementById('imgPreview').src = e.target.result;
        reader.readAsDataURL(file);
    });
</script>
@endpush
