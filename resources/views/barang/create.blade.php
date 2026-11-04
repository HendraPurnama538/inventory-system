@extends('layouts.app')
@section('title', 'Tambah Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@push('styles')
<style>
    .img-preview { width:100%; height:180px; object-fit:cover; border-radius:10px; border:2px dashed #e2e8f0; }
    .img-preview.has-img { border-style:solid; border-color:#4f46e5; }
</style>
@endpush

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Tambah Barang</h1>
        <p class="page-subtitle">Daftarkan barang baru ke inventaris</p>
    </div>
    <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-3 fade-in-up">

    {{-- Form Kiri --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-box-seam me-2 text-primary"></i>Informasi Barang</div>
            <div class="card-body">
                <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data" id="formBarang">
                    @csrf
                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang"
                                   class="form-control @error('nama_barang') is-invalid @enderror"
                                   value="{{ old('nama_barang') }}"
                                   placeholder="Contoh: Laptop ASUS VivoBook 15">
                            @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Kode barang akan dibuat otomatis (BRG-YYYYMM-XXXX)</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id"
                                    class="form-select @error('kategori_id') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Supplier <span class="text-danger">*</span></label>
                            <select name="supplier_id"
                                    class="form-select @error('supplier_id') is-invalid @enderror">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}" {{ old('supplier_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="satuan"
                                   class="form-control @error('satuan') is-invalid @enderror"
                                   value="{{ old('satuan') }}"
                                   placeholder="pcs / kg / lusin / rim">
                            @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Harga Beli <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_beli" min="0" step="100"
                                       class="form-control @error('harga_beli') is-invalid @enderror"
                                       value="{{ old('harga_beli', 0) }}">
                            </div>
                            @error('harga_beli')<div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Harga Jual <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_jual" min="0" step="100"
                                       class="form-control @error('harga_jual') is-invalid @enderror"
                                       value="{{ old('harga_jual', 0) }}">
                            </div>
                            @error('harga_jual')<div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" name="stok" min="0"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', 0) }}">
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Stok Minimal <span class="text-danger">*</span>
                                <i class="bi bi-info-circle text-muted" title="Alert stok menipis jika stok ≤ nilai ini"></i>
                            </label>
                            <input type="number" name="stok_minimal" min="0"
                                   class="form-control @error('stok_minimal') is-invalid @enderror"
                                   value="{{ old('stok_minimal', 5) }}">
                            @error('stok_minimal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" rows="2"
                                      class="form-control">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-check-lg me-1"></i>Simpan Barang
                            </button>
                            <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Upload Gambar --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-image me-2 text-primary"></i>Gambar Barang</div>
            <div class="card-body text-center">
                <img id="imgPreview" src="{{ asset('images/no-image.png') }}"
                     alt="Preview" class="img-preview mb-3">

                <label for="gambarInput" class="btn btn-outline-primary w-100">
                    <i class="bi bi-upload me-1"></i>Pilih Gambar
                </label>
                <input type="file" id="gambarInput" name="gambar" accept="image/*"
                       class="d-none @error('gambar') is-invalid @enderror"
                       form="formBarang">
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
    // Preview gambar sebelum upload
    document.getElementById('gambarInput').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('imgPreview');
            img.src = e.target.result;
            img.classList.add('has-img');
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
