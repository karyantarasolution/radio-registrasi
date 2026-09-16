@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    .form-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        max-width: 780px;
        margin: 0 auto;
        overflow: hidden;
    }
    .form-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 15px 25px;
    }
    .form-body { padding: 25px; }
    .form-label { font-weight: 600; }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="form-card">
            <div class="form-header">
                <h4 class="fw-bold mb-0">{{ isset($maintenance) ? 'Edit Maintenance' : 'Buat Maintenance Baru' }}</h4>
            </div>
            <div class="form-body">
                <form method="POST" action="{{ isset($maintenance) ? route('maintenance.update', $maintenance->id) : route('maintenance.store') }}">
                    @csrf
                    @if(isset($maintenance)) @method('PUT') @endif

                    @if(!isset($maintenance) && $inventarisDipinjam->count() > 0)
                    <div class="alert alert-info">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="dariPeminjaman">
                            <label class="form-check-label" for="dariPeminjaman">
                                Perangkat ini sedang saya pinjam (dari daftar peminjaman saya)
                            </label>
                        </div>
                    </div>
                    @endif

                    <div class="mb-3" id="groupBarang">
                        <label class="form-label">Perangkat <span class="text-danger">*</span></label>
                        <select name="gudang_barang_id" id="gudangBarangId" class="form-select" required>
                            <option value="">-- Pilih Perangkat --</option>
                            @foreach($gudangBarangs as $gb)
                                <option value="{{ $gb->id }}" {{ old('gudang_barang_id', isset($maintenance) ? $maintenance->gudang_barang_id : '') == $gb->id ? 'selected' : '' }}>
                                    {{ $gb->nama_perangkat }} ({{ $gb->kode_qr }}) - Stok: {{ $gb->stok_tersedia }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="groupInventaris" style="display:none;">
                        <label class="form-label">Pilih dari Peminjaman Saya</label>
                        <select name="inventaris_id" id="inventarisId" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach($inventarisDipinjam as $inv)
                                <option value="{{ $inv->id }}">{{ $inv->gudangBarang->nama_perangkat ?? $inv->barang }} - {{ $inv->tanggal ?? '' }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih unit peminjaman yang rusak agar riwayatnya tercatat.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kerusakan <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_kerusakan" class="form-control" value="{{ old('jenis_kerusakan', $maintenance->jenis_kerusakan ?? '') }}" placeholder="cth: tidak mau start, rusak layar" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Kerusakan</label>
                        <textarea name="deskripsi_kerusakan" class="form-control" rows="3">{{ old('deskripsi_kerusakan', $maintenance->deskripsi_kerusakan ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Petugas / Teknisi</label>
                        <input type="text" name="petugas" class="form-control" value="{{ old('petugas', $maintenance->petugas ?? '') }}" placeholder="Nama teknisi (kosongkan jika belum)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk Maintenance <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', isset($maintenance) ? $maintenance->tanggal_masuk->format('Y-m-d') : now()->toDateString()) }}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-modern" style="background:linear-gradient(135deg,#ea6666,#f71414);color:#fff;border:none;padding:8px 24px;border-radius:8px;font-weight:600;">
                            {{ isset($maintenance) ? 'Simpan Perubahan' : 'Simpan Maintenance' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const cb = document.getElementById('dariPeminjaman');
        if (!cb) return;
        cb.addEventListener('change', function() {
            document.getElementById('groupBarang').style.display = this.checked ? 'none' : 'block';
            document.getElementById('groupInventaris').style.display = this.checked ? 'block' : 'none';
            if (this.checked) document.getElementById('gudangBarangId').required = false;
            else document.getElementById('gudangBarangId').required = true;
        });
    })();
</script>
@endsection