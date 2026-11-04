@extends('layouts.app')
@section('title', 'Catat Barang Keluar')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barang-keluar.index') }}">Barang Keluar</a></li>
    <li class="breadcrumb-item active">Catat</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Catat Barang Keluar</h1>
        <p class="page-subtitle">Input pengeluaran/penjualan barang</p>
    </div>
    <a href="{{ route('barang-keluar.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center fade-in-up">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-arrow-up-circle-fill text-danger me-2"></i>Form Barang Keluar</div>
            <div class="card-body">
                <form method="POST" action="{{ route('barang-keluar.store') }}">
                    @csrf
                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label">Barang <span class="text-danger">*</span></label>
                            <select name="barang_id" id="barang_id"
                                    class="form-select @error('barang_id') is-invalid @enderror">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangs as $b)
                                    <option value="{{ $b->id }}"
                                            data-stok="{{ $b->stok }}"
                                            data-satuan="{{ $b->satuan }}"
                                            data-harga="{{ $b->harga_jual }}"
                                            {{ old('barang_id', request('barang_id')) == $b->id ? 'selected' : '' }}>
                                        [{{ $b->kode_barang }}] {{ $b->nama_barang }}
                                        (Stok: {{ $b->stok }} {{ $b->satuan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror

                            {{-- Stok tersedia info --}}
                            <div id="stokInfo" class="mt-1 d-none">
                                <small>Stok tersedia: <strong id="stokTersedia" class="text-primary">-</strong></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="jumlah" id="jumlah" min="1"
                                       class="form-control @error('jumlah') is-invalid @enderror"
                                       value="{{ old('jumlah', 1) }}">
                                <span class="input-group-text" id="satuanLabel">unit</span>
                            </div>
                            @error('jumlah')
                                <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>
                            @enderror
                            {{-- Peringatan stok --}}
                            <div id="stokWarning" class="d-none mt-1">
                                <small class="text-danger"><i class="bi bi-exclamation-triangle"></i>
                                    Jumlah melebihi stok tersedia!
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Harga Jual/Unit <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_jual" id="harga_jual" min="0" step="100"
                                       class="form-control @error('harga_jual') is-invalid @enderror"
                                       value="{{ old('harga_jual', 0) }}">
                            </div>
                            @error('harga_jual')<div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>@enderror
                        </div>

                        {{-- Preview Total --}}
                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background:#fff5f5; border:1px solid #fee2e2;">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Total Harga:</span>
                                    <strong id="totalPreview" class="text-danger fs-5">Rp 0</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_keluar"
                                   class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                   value="{{ old('tanggal_keluar', today()->toDateString()) }}"
                                   max="{{ today()->toDateString() }}">
                            @error('tanggal_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. Referensi</label>
                            <input type="text" name="no_referensi" class="form-control"
                                   value="{{ old('no_referensi') }}"
                                   placeholder="Contoh: SO-2024-001">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" rows="2" class="form-control"
                                      placeholder="Opsional...">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button type="submit" id="btnSubmit" class="btn btn-danger flex-grow-1">
                                <i class="bi bi-check-lg me-1"></i>Simpan Transaksi
                            </button>
                            <a href="{{ route('barang-keluar.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const barangSelect  = document.getElementById('barang_id');
    const jumlahInput   = document.getElementById('jumlah');
    const hargaInput    = document.getElementById('harga_jual');
    const totalEl       = document.getElementById('totalPreview');
    const satuanEl      = document.getElementById('satuanLabel');
    const stokInfoEl    = document.getElementById('stokInfo');
    const stokEl        = document.getElementById('stokTersedia');
    const stokWarnEl    = document.getElementById('stokWarning');
    const btnSubmit     = document.getElementById('btnSubmit');
    let maxStok = 0;

    function formatRupiah(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function validate() {
        const jumlah = parseInt(jumlahInput.value) || 0;
        const isOverStock = maxStok > 0 && jumlah > maxStok;
        stokWarnEl.classList.toggle('d-none', !isOverStock);
        btnSubmit.disabled = isOverStock;
        return !isOverStock;
    }

    function updateTotal() {
        const jumlah = parseInt(jumlahInput.value) || 0;
        const harga  = parseInt(hargaInput.value) || 0;
        totalEl.textContent = formatRupiah(jumlah * harga);
        validate();
    }

    barangSelect.addEventListener('change', function() {
        const opt     = this.options[this.selectedIndex];
        maxStok       = parseInt(opt.dataset.stok) || 0;
        const satuan  = opt.dataset.satuan || 'unit';
        const harga   = opt.dataset.harga || 0;

        satuanEl.textContent  = satuan;
        hargaInput.value      = harga;
        stokEl.textContent    = maxStok + ' ' + satuan;
        stokInfoEl.classList.toggle('d-none', !this.value);

        // Set max attribute
        jumlahInput.max = maxStok;
        updateTotal();
    });

    jumlahInput.addEventListener('input', updateTotal);
    hargaInput.addEventListener('input', updateTotal);

    if (barangSelect.value) barangSelect.dispatchEvent(new Event('change'));
    updateTotal();
</script>
@endpush
