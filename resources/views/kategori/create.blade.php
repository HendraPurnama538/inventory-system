@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Tambah Kategori</h1>
        <p class="page-subtitle">Buat kategori barang baru</p>
    </div>
    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center fade-in-up">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-tag me-2 text-primary"></i>Form Kategori</div>
            <div class="card-body">
                <form method="POST" action="{{ route('kategori.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" id="nama_kategori"
                               class="form-control @error('nama_kategori') is-invalid @enderror"
                               value="{{ old('nama_kategori') }}"
                               placeholder="Contoh: Elektronik">
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Opsional, deskripsi singkat kategori...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-check-lg me-1"></i>Simpan Kategori
                        </button>
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
