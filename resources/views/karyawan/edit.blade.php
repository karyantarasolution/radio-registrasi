@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-danger mb-1">Edit Data Karyawan</h4>
                <small class="text-muted">Form edit data karyawan ICT</small>
            </div>
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary fw-bold">
                Kembali
            </a>
        </div>
    </div>

    {{-- Card Form --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                 <h5 class="mb-4 fw-bold text-danger">Form Input Data Karyawan IT</h5>
                 
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text" name="nama"
                            class="form-control form-control-sm rounded-3 shadow-sm"
                            value="{{ old('nama', $karyawan->nama) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">NRP</label>
                        <input type="text" name="nrp"
                            class="form-control form-control-sm rounded-3 shadow-sm"
                            value="{{ old('nrp', $karyawan->nrp) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Jabatan</label>
                        <input type="text" name="jabatan"
                            class="form-control form-control-sm rounded-3 shadow-sm"
                            value="{{ old('jabatan', $karyawan->jabatan) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Departemen</label>
                        <input type="text" name="departemen"
                            class="form-control form-control-sm rounded-3 shadow-sm"
                            value="{{ old('departemen', $karyawan->departemen) }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">
                            Upload QR Code (Kosongkan Jika Tidak Diganti)
                        </label>

                        @if($karyawan->qr_code)
                            <div class="mb-2">
                                <img src="{{ asset('storage/qr_codes/' . $karyawan->qr_code) }}"
                                     width="80" class="img-thumbnail rounded shadow-sm">
                            </div>
                        @endif

                        <input type="file" name="qr_code"
                            class="form-control form-control-sm rounded-3 shadow-sm"
                            accept="image/*">
                        <small class="text-muted">Format gambar (JPG, PNG)</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success fw-bold me-2">
                        Perbaharui
                    </button>
                    <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary fw-bold">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

{{-- STYLE MODERN --}}
<style>
.form-control, .form-select {
    transition: all 0.2s ease-in-out;
}

.form-control:focus {
    border-color: #e74c3c;
    box-shadow: 0 0 0 0.15rem rgba(231, 76, 60, 0.25);
}

.card {
    animation: fadeInUp 0.4s ease;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
