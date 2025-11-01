@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Edit Data Karyawan</h3>

    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $karyawan->nama }}" required>
        </div>

        <div class="mb-3">
            <label>NRP</label>
            <input type="text" name="nrp" class="form-control" value="{{ $karyawan->nrp }}" required>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ $karyawan->jabatan }}" required>
        </div>

        <div class="mb-3">
            <label>Departemen</label>
            <input type="text" name="departemen" class="form-control" value="{{ $karyawan->departemen }}" required>
        </div>

        <div class="mb-3">
            <label>QR Code (Upload Baru Jika Ingin Ganti)</label><br>
            @if($karyawan->qr_code)
                <img src="{{ asset($karyawan->qr_code) }}" width="100" class="mb-2"><br>
            @endif
            <input type="file" name="qr_code" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
