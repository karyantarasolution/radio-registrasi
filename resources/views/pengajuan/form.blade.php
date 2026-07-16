@extends('layouts.app')

@section('content')
<style>
    .form-wrapper {
        display: flex;
        justify-content: center;
        padding: 30px 15px;
        width: 100%;
    }
    .form-card {
        border-radius: 16px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        border: none;
    }
    .form-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 24px;
    }
    .form-card-body { padding: 28px; }
    #maintenanceSection { display: none; }
    #maintenanceSection.show { display: block; }
</style>

<div class="form-wrapper">
    <div class="form-card card">
        <div class="form-card-header">
            <h5 class="fw-bold mb-1"><i class="fas fa-paper-plane me-2"></i>Ajukan Pengajuan</h5>
            <small class="opacity-75">Pengajuan pembelian atau maintenance barang IT</small>
        </div>
        <div class="form-card-body">
            @if ($errors->any())
                <div class="alert alert-danger" style="border-radius:10px;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('pengajuan.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Pengajuan <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" style="border-radius:10px;" value="{{ old('judul') }}" placeholder="Contoh: Pengajuan UPS baru" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori" id="kategoriSelect" class="form-select" style="border-radius:10px;" required>
                        <option value="">-- Pilih --</option>
                        <option value="Pembelian" {{ old('kategori') == 'Pembelian' ? 'selected' : '' }}>Pembelian Barang</option>
                        <option value="Maintenance" {{ old('kategori') == 'Maintenance' ? 'selected' : '' }}>Maintenance / Perbaikan</option>
                    </select>
                </div>

                <div id="maintenanceSection" class="{{ old('kategori') == 'Maintenance' ? 'show' : '' }}">
                    <div class="alert alert-warning mb-3" style="border-radius:10px; font-size:0.85rem;">
                        <i class="fas fa-tools me-1"></i> Pilih barang yang perlu maintenance dari daftar berikut:
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Barang yang Perlu Maintenance <span class="text-danger">*</span></label>
                        <select name="gudang_barang_id" id="barangMaintenanceSelect" class="form-select" style="border-radius:10px;">
                            <option value="">-- Pilih Barang --</option>
                            @forelse($barangMaintenance as $b)
                                <option value="{{ $b->id }}"
                                    data-nama="{{ $b->nama_perangkat }}"
                                    data-kondisi="{{ $b->kondisi }}"
                                    data-stok="{{ $b->stok_tersedia }}"
                                    {{ old('gudang_barang_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_perangkat }} - {{ $b->merk }} [{{ $b->kondisi }}] (Stok: {{ $b->stok_tersedia }})
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada barang yang perlu maintenance</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_barang" id="namaBarangInput" class="form-control" style="border-radius:10px;" value="{{ old('nama_barang') }}" placeholder="Contoh: UPS APC 3KVA" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Diminta <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_diminta" class="form-control" style="border-radius:10px;" value="{{ old('jumlah_diminta', 1) }}" min="1" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                        <input type="text" name="satuan" class="form-control" style="border-radius:10px;" value="{{ old('satuan', 'unit') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Estimasi Biaya (Rp)</label>
                    <input type="number" name="estimasi_biaya" class="form-control" style="border-radius:10px;" value="{{ old('estimasi_biaya') }}" min="0" step="1000" placeholder="Contoh: 5000000">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi / Keterangan</label>
                    <textarea name="deskripsi" class="form-control" style="border-radius:10px;" rows="4" placeholder="Jelaskan alasan atau kebutuhan pengajuan...">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;">Batal</a>
                    <button type="submit" class="btn" style="background:linear-gradient(135deg, #667eea, #764ba2); color:#fff; border-radius:10px; padding:8px 24px;">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var kategoriSelect = document.getElementById('kategoriSelect');
    var maintenanceSection = document.getElementById('maintenanceSection');
    var barangSelect = document.getElementById('barangMaintenanceSelect');
    var namaBarangInput = document.getElementById('namaBarangInput');

    kategoriSelect.addEventListener('change', function() {
        if (this.value === 'Maintenance') {
            maintenanceSection.classList.add('show');
            barangSelect.required = true;
        } else {
            maintenanceSection.classList.remove('show');
            barangSelect.required = false;
            barangSelect.value = '';
        }
    });

    barangSelect.addEventListener('change', function() {
        var selected = this.options[this.selectedIndex];
        if (this.value) {
            namaBarangInput.value = selected.dataset.nama || '';
            namaBarangInput.readOnly = true;
        } else {
            namaBarangInput.readOnly = false;
        }
    });
});
</script>
@endsection
