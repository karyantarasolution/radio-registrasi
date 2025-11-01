@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Tambah Data Karyawan</h3>

    <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>NRP</label>
            <input type="text" name="nrp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Departemen</label>
            <input type="text" name="departemen" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Upload QR Code (optional)</label>
            <input type="file" name="qr_code" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
    
</div>
@endsection
