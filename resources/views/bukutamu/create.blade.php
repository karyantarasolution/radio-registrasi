@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .form-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 30px 15px;
        margin-top: 20px;
        width: 100%;
        min-height: calc(100vh - 80px);
    }
    .card {
        border-radius: 10px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1),
                    0 15px 12px rgba(0,0,0,0.08);
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.2);
        animation: slideUp 0.6s cubic-bezier(0.25,0.46,0.45,0.94);
        position: relative;
    }
    .card::before{
        content:'';
        position:absolute;
        top:0;left:0;right:0;
        height:4px;
        background:linear-gradient(90deg,#2980b9,#3498db,#6dd5fa);
    }
    .card-header {
    background:linear-gradient(135deg,#2c3e50 0%,#34495e 50%,#2c3e50 100%);
    color: #fff;
    padding: 25px 20px;
    text-align: center;
    position: relative;
    }

    .card-body{padding:30px 25px}
    .form-group{margin-bottom:20px;position:relative}
    .form-label{
        display:block;margin-bottom:8px;font-weight:600;
        color:#2c3e50;font-size:.95rem;padding-left:8px;position:relative;
    }
    .form-label::before{
        content:'';position:absolute;left:0;top:50%;
        transform:translateY(-50%);width:3px;height:16px;
        background:linear-gradient(45deg,#2980b9,#6dd5fa);
        border-radius:2px;
    }
    .form-control, .form-select{
        border-radius:12px;padding:14px 18px;font-size:.95rem;
        border:2px solid #e8ecf0;transition:all .3s;
        background:#fff;width:100%;
    }
    .form-control:focus, .form-select:focus{
        border-color:#3498db;
        box-shadow:0 0 0 4px rgba(52,152,219,0.1);
        outline:none;background:#fafbfc;
    }
    .btn{
        border-radius:12px;
        padding:14px 24px;
        font-weight:600;
        font-size:.95rem;
        display:inline-flex;
        align-items:center;
        gap:8px;
        cursor:pointer;
        border:none;
        transition:all .3s;
        position:relative;
        overflow:hidden;
        text-decoration:none;
    }
    .btn-success{
        background:linear-gradient(45deg,#27ae60,#2ecc71);
        color:#fff;
    }
    .btn-success:hover{background:linear-gradient(45deg,#229954,#27ae60);transform:translateY(-2px)}
    .btn-secondary{
        background:linear-gradient(45deg,#7f8c8d,#95a5a6);
        color:#fff;
    }
    .btn-secondary:hover{background:linear-gradient(45deg,#6c7b7d,#7f8c8d);transform:translateY(-2px)}
    .button-group{
        display:flex;
        justify-content:space-between;
        margin-top:30px;
        gap:15px;
    }
    @media(max-width:576px){.button-group{flex-direction:column-reverse}.btn{width:100%;justify-content:center}}
    @keyframes slideUp{from{opacity:0;transform:translateY(30px) scale(.95)}to{opacity:1;transform:translateY(0) scale(1)}}
</style>

<div class="form-wrapper">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Buku Tamu</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>⚠️ Perhatian!</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bukutamu.store') }}" method="POST" id="bukutamuForm">
                @csrf

                <div class="form-group">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" placeholder="Masukkan nama tamu" required>
                </div>

                <div class="mb-3">
                    <label for="no_telp" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" id="no_telp" class="form-control"
                        value="{{ old('no_telp', $bukutamu->no_telp ?? '') }}" placeholder="Masukkan No Telepon " required>
                </div>

                <div class="form-group">
                    <label for="nrp" class="form-label">NRP / NIK</label>
                    <input type="text" name="nrp" id="nrp"
                        class="form-control" value="{{ old('nrp') }}" placeholder="Masukkan NRP tamu">
                </div>

                <div class="form-group">
                    <label for="instansi" class="form-label">Instansi</label>
                    <input type="text" name="instansi" id="instansi"
                        class="form-control" value="{{ old('instansi') }}" placeholder="Asal instansi">
                </div>

                <div class="form-group">
                    <label for="keperluan" class="form-label">Keperluan</label>
                    <textarea name="keperluan" id="keperluan" rows="3"
                        class="form-control" placeholder="Tuliskan keperluan kunjungan">{{ old('keperluan') }}</textarea>
                </div>

                <div class="button-group">
                    <a href="{{ route('bukutamu.index') }}" class="btn btn-secondary">⬅ Kembali</a>
                    <button type="submit" class="btn btn-success" id="submitBtn">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('bukutamuForm').addEventListener('submit', function(){
    const btn = document.getElementById('submitBtn');
    btn.textContent = 'Menyimpan...';
    btn.disabled = true;
});
</script>
@endsection
