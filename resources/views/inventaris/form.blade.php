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
    .select-wrapper {
    position: relative;
    }

    .select-wrapper::after {
        content: '▼';
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #7f8c8d;
        font-size: 0.75rem;
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
            <h4>{{ isset($inventaris) ? 'Edit Inventaris' : 'Tambah Inventaris' }}</h4>
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

            <form
                action="{{ isset($inventaris) ? route('inventaris.update', $inventaris->id) : route('inventaris.store') }}"
                method="POST"
                id="inventarisForm"
            >
                @csrf
                @if(isset($inventaris))
                    @method('PUT')
                @endif

                @if(!isset($inventaris) && isset($user) && $user->isKaryawan())
                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly disabled>
                        <input type="hidden" name="nama" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">NRP</label>
                        <input type="text" class="form-control" value="{{ $user->nrp }}" readonly disabled>
                        <input type="hidden" name="nrp" value="{{ $user->nrp }}">
                    </div>
                @else
                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control"
                            value="{{ old('nama', $inventaris->nama ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NRP</label>
                        <input type="text" name="nrp" class="form-control"
                            value="{{ old('nrp', $inventaris->nrp ?? '') }}" required>
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Pilih Barang dari Gudang IT</label>
                    <div class="select-wrapper">
                        <select name="gudang_barang_id" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($gudangBarang ?? [] as $gb)
                                <option value="{{ $gb->id }}"
                                    @selected(old('gudang_barang_id', $inventaris->gudang_barang_id ?? '') == $gb->id)>
                                    {{ $gb->nama_perangkat }} ({{ $gb->kategori }}) — stok: {{ $gb->stok_tersedia }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <small class="text-muted d-block mt-1">Hanya barang dengan stok tersedia yang ditampilkan.</small>
                </div>

                @if(isset($inventaris))
                <div class="form-group">
                    <label class="form-label">Nama Perangkat (otomatis)</label>
                    <input type="text" class="form-control" value="{{ $inventaris->nama_perangkat }}" readonly disabled>
                </div>
                <div class="form-group">
                    <label class="form-label">No Asset (otomatis)</label>
                    <input type="text" class="form-control" value="{{ $inventaris->no_asset }}" readonly disabled>
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Status Peminjaman</label>
                    <input type="text" class="form-control"
                        value="{{ old('status_peminjaman', $inventaris->status_peminjaman ?? 'Pending') }}"
                        readonly disabled>
                    <small class="text-muted d-block mt-1">
                        Status diatur otomatis: Pending saat pengajuan, Belum Dikembalikan setelah disetujui admin.
                    </small>
                </div>


                <div class="form-group">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_peminjaman" class="form-control"
                        value="{{ old('tanggal_peminjaman', $inventaris->tanggal_peminjaman ?? '') }}" required>
                </div>

                <div class="button-group">
                    <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">⬅ Kembali</a>
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        {{ isset($inventaris) ? 'Update Data' : 'Simpan Data' }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('inventarisForm').addEventListener('submit', function(){
    const btn = document.getElementById('submitBtn');
    btn.textContent = 'Menyimpan...';
    btn.disabled = true;
});
</script>
@endsection
