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
        top: -50%; right: -10%;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
        pointer-events: none;
    }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-20px)} }
    .stat-card {
        background:#fff;
        border-radius:12px;
        padding:15px;
        text-align:center;
        box-shadow:0 4px 10px rgba(0,0,0,0.05);
    }
    .stat-icon { font-size:1.5rem; margin-bottom:4px; }
    .stat-number { font-size:1.4rem; font-weight:bold; }
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
    }
    .table-title { font-size:1.3rem; font-weight:bold; margin:0; }
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
    .badge-maintenance { padding:5px 10px; border-radius:8px; font-size:0.8rem; font-weight:600; background:#ffc107; color:#333; }
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
    .btn-back { background: linear-gradient(45deg, #7f8c8d, #95a5a6); }
</style>

<div class="page-container">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1"><i class="fas fa-tools me-2"></i>Barang Maintenance</h2>
                    <p class="mb-0">Daftar perangkat yang sedang dalam proses maintenance (disetujui pimpinan)</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('gudang-barang.index') }}" class="btn btn-modern btn-back">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Gudang
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-number" style="color:#667eea;">{{ $stats['total'] }}</div>
                    <div class="stat-label">Jenis Barang di Maintenance</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">🔧</div>
                    <div class="stat-number" style="color:#e67e22;">{{ $stats['total_unit_maintenance'] }}</div>
                    <div class="stat-label">Total Unit di Maintenance</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-number" style="color:#28a745;">{{ $stats['total_stok_tersedia'] }}</div>
                    <div class="stat-label">Stok Tersedia</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-number" style="color:#6c757d;">{{ $stats['total_stok'] }}</div>
                    <div class="stat-label">Stok Total</div>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <div>
                    <h4 class="table-title">Daftar Barang Maintenance</h4>
                    <small>Total: {{ $items->count() }} jenis barang</small>
                </div>
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
                            <th>Unit di Maintenance</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $b)
                        @php $unitMaintenance = $b->stok_total - $b->stok_tersedia; @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $b->nama_perangkat }}</td>
                            <td>{{ $b->merk ?? '-' }}</td>
                            <td>{{ $b->kategori }}</td>
                            <td>{{ $b->stok_total }}</td>
                            <td>{{ $b->stok_tersedia }}</td>
                            <td>
                                <span class="badge-maintenance">{{ $unitMaintenance }} unit</span>
                            </td>
                            <td><small>{{ $b->keterangan ?? '-' }}</small></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-muted py-4">
                                <div style="font-size:2rem;">✅</div>
                                Tidak ada barang yang sedang di-maintenance
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
