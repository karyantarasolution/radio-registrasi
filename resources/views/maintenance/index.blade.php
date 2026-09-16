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
        margin-bottom: 20px;
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
        pointer-events: none;
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
        height:100%;
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
    .filter-card { background:#fff; border-radius:16px; padding:15px 20px; box-shadow:0 4px 10px rgba(0,0,0,0.05); margin-bottom:20px; }
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
    .btn-edit   { background: linear-gradient(135deg,#51cf66,#2ecc71); color:#fff; }
    .btn-delete { background: linear-gradient(135deg,#ffa94d,#ff922b); color:#fff; }
    .btn-detail { background: linear-gradient(135deg, #667eea, #764ba2); color:#fff; }
    .badge-status { padding:5px 10px; border-radius:8px; font-size:0.8rem; font-weight:600; }
</style>

<div class="page-container">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">Maintenance Perangkat</h2>
                    <p class="mb-0">Pencatatan perbaikan &amp; kerusakan perangkat IT</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    @if(!Auth::user()->isPimpinan())
                        <a href="{{ route('maintenance.create') }}" class="btn btn-add btn-modern">
                            <i class="fas fa-plus me-1"></i> Buat Maintenance
                        </a>
                    @endif
                    @if(Auth::user()->isAdmin() || Auth::user()->isPimpinan())
                        <a href="{{ route('maintenance.report') }}" target="_blank" class="btn btn-detail btn-modern">
                            <i class="fas fa-file-pdf me-1"></i> Cetak Laporan
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-6 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-number">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-number text-warning">{{ $stats['menunggu'] }}</div>
                    <div class="stat-label">Menunggu</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon">🔧</div>
                    <div class="stat-number text-primary">{{ $stats['diproses'] }}</div>
                    <div class="stat-label">Diproses</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-number text-success">{{ $stats['selesai'] }}</div>
                    <div class="stat-label">Selesai</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon">🚫</div>
                    <div class="stat-number text-danger">{{ $stats['dibatalkan'] }}</div>
                    <div class="stat-label">Dibatalkan</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon">💡<br></div>
                    <div class="stat-number" style="font-size:0.95rem; color:#6c757d;">Sisa unit<br>dibawah pemakaian</div>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('maintenance.index') }}" class="filter-card">
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small mb-1 fw-semibold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach(['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'] as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small mb-1 fw-semibold">Perangkat</label>
                    <select name="gudang_barang_id" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach($gudangBarangs as $gb)
                            <option value="{{ $gb->id }}" {{ request('gudang_barang_id') == $gb->id ? 'selected' : '' }}>{{ $gb->nama_perangkat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small mb-1 fw-semibold">Cari (No / Kerusakan / Petugas)</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="MT-..., kerusakan, petugas...">
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1 fw-semibold">Tgl Awal</label>
                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1 fw-semibold">Tgl Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control form-control-sm">
                </div>
                <div class="col-auto">
                    <button class="btn btn-modern btn-detail" type="submit"><i class="fas fa-filter"></i> Filter</button>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-modern" style="background:#6c757d;">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-card">
            <div class="table-header">
                <div>
                    <h4 class="table-title">Daftar Maintenance</h4>
                    <small class="table-subtitle">Menampilkan {{ $maintenances->count() }} tiket</small>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Maintenance</th>
                            <th>Perangkat</th>
                            <th>Jenis Kerusakan</th>
                            <th>Petugas</th>
                            <th>Status</th>
                            <th>Tgl Masuk</th>
                            <th>Diajukan Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances as $item)
                        @php
                            $color = match($item->status) {
                                'Menunggu' => ['#ffc107', '#333'],
                                'Diproses' => ['#007bff', '#fff'],
                                'Selesai' => ['#28a745', '#fff'],
                                default => ['#6c757d', '#fff'],
                            };
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><code>{{ $item->nomor_maintenance }}</code></td>
                            <td>
                                {{ $item->gudangBarang->nama_perangkat ?? '-' }}
                                <br><small class="text-muted">{{ $item->gudangBarang->kode_qr ?? '' }}</small>
                                @if($item->inventaris_id)
                                    <br><span class="badge bg-info text-white" style="font-size:0.65rem;">dari peminjaman</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($item->jenis_kerusakan, 40) }}</td>
                            <td>{{ $item->petugas ?? '-' }}</td>
                            <td>
                                <span class="badge-status" style="background:{{ $color[0] }}; color:{{ $color[1] }};">{{ $item->status }}</span>
                            </td>
                            <td>{{ $item->tanggal_masuk->format('d-m-Y') }}</td>
                            <td>{{ $item->createdBy->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('maintenance.show', $item->id) }}" class="btn btn-detail btn-modern">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-muted py-4">Belum ada data maintenance.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection