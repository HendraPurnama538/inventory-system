@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Edit Kategori</h1>
        <p class="page-subtitle">Perbarui data kategori</p>
    </div>
    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center fade-in-up">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil me-2 text-warning"></i>Edit: {{ $kategori->nama_kategori }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('kategori.update', $kategori) }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label" for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" id="nama_kategori"
                               class="form-control @error('nama_kategori') is-invalid @enderror"
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}">
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                                  class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning flex-grow-1">
                            <i class="bi bi-save me-1"></i>Perbarui Kategori
                        </button>
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
