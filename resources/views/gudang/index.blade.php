@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }

    .page-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%,100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .stat-card {
        background:#fff;
        border-radius:12px;
        padding:15px;
        text-align:center;
        box-shadow:0 4px 10px rgba(0,0,0,0.05);
    }
    .stat-icon { font-size:1.5rem; margin-bottom:4px; }
    .stat-number { font-size:1.4rem; font-weight:bold; color:#667feaff; }
    .stat-label { font-size:0.8rem; font-weight:500; color:#6c757d; }

    .table-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .table-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 15px 25px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .table-title { font-size:1.3rem; font-weight:bold; margin:0; }
    .table-subtitle { font-size:0.8rem; font-weight:500; }

    .table-custom { width:100%; border-collapse:collapse; }
    .table-custom thead { background:#f8f9fa; }
    .table-custom th {
        padding:12px;
        font-weight:600;
        text-align:center;
        border-bottom:2px solid #dee2e6;
    }
    .table-custom td {
        padding:10px;
        text-align:center;
        border-top:1px solid #f1f1f1;
        font-size:14px;
    }
    .table-custom tbody tr:hover { background:#f8f9fa; }

    .btn-modern {
        border:none;
        padding:7px 14px;
        border-radius:8px;
        font-size:0.8rem;
        font-weight:600;
        transition:all .2s;
        color:#fff;
        text-decoration:none;
        display:inline-block;
    }
    .btn-modern:hover { opacity:.9; }
    .btn-add    { background: linear-gradient(135deg,#43e97b,#38f9d7); color:#fff; }
    .btn-pdf    { background: linear-gradient(135deg,#ff6b6b,#ee5a5a); color:#fff; }
    .btn-edit   { background: linear-gradient(135deg,#51cf66,#2ecc71); color:#fff; }
    .btn-delete { background: linear-gradient(135deg,#ffa94d,#ff922b); color:#fff; }

    .badge-kondisi { padding:5px 10px; border-radius:8px; font-size:0.8rem; font-weight:600; }
</style>

<div class="page-container">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">Gudang IT</h2>
                    <p class="mb-0">Master stok perangkat IT untuk peminjaman</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    @if(Auth::user()->name == 'ICT')
                        <a href="{{ route('gudang-barang.create') }}" class="btn btn-add btn-modern">
                            <i class="fas fa-plus me-1"></i> Tambah Barang
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-number">{{ $stats['total_jenis'] }}</div>
                    <div class="stat-label">Jenis Barang</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-number">{{ $stats['stok_tersedia'] }}</div>
                    <div class="stat-label">Stok Tersedia</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon text-warning">🔧</div>
                    <div class="stat-number">{{ $stats['maintenance'] }}</div>
                    <div class="stat-label">Perlu Maintenance</div>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <div>
                    <h4 class="table-title">Daftar Stok Gudang</h4>
                    <small class="table-subtitle">Total: {{ $barang->count() }} jenis barang</small>
                </div>
                @if(Auth::user()->name == 'ICT')
                    <a href="{{ route('gudang.laporan') }}" class="btn-modern btn-pdf">
                        <i class="fas fa-file-alt me-1"></i> Lihat Laporan
                    </a>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Perangkat</th>
                            <th>Merek</th>
                            <th>Kategori</th>
                            <th>Stok Total</th>
                            <th>Stok Tersedia</th>
                            <th>Kondisi</th>
                            <th>Tgl Masuk</th>
                            @if(Auth::user()->name == 'ICT')<th>Aksi</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->nama_perangkat }}</td>
                            <td>{{ $b->merk ?? '-' }}</td>
                            <td>{{ $b->kategori }}</td>
                            <td>{{ $b->stok_total }}</td>
                            <td>{{ $b->stok_tersedia }}</td>
                            <td>
                                @php
                                    $kColor = match($b->kondisi) {
                                        'Baik' => '#28a745',
                                        'Perlu Maintenance' => '#ffc107',
                                        default => '#dc3545',
                                    };
                                    $kText = $b->kondisi === 'Perlu Maintenance' ? '#333' : '#fff';
                                @endphp
                                <span class="badge-kondisi" style="background:{{ $kColor }}; color:{{ $kText }};">{{ $b->kondisi }}</span>
                            </td>
                            <td>{{ $b->tanggal_masuk->format('d-m-Y') }}</td>
                            @if(Auth::user()->name == 'ICT')
                            <td>
                                <a href="{{ route('gudang-barang.edit', $b->id) }}" class="btn btn-edit btn-modern">Edit</a>
                                <form action="{{ route('gudang-barang.destroy', $b->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-modern" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr><td colspan="{{ Auth::user()->name == 'ICT' ? 9 : 8 }}" class="text-muted py-4">Belum ada data gudang</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
