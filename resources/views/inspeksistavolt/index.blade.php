@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }

    /* ===== Header ===== */
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
        pointer-events: none;
    }
    @keyframes float {
        0%,100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* ===== Statistik ===== */
    .stats-container { margin-bottom: 20px; }
    @media (min-width: 768px) {
        .col-md-2-4 {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }
    .stat-card {
        background:#fff;
        border-radius:12px;
        padding:15px;
        text-align:center;
        box-shadow:0 4px 10px rgba(0,0,0,0.05);
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }
    .stat-icon { font-size:1.5rem; margin-bottom:4px; }
    .stat-number { font-size:1.4rem; font-weight:bold; color:#667feaff; }
    .stat-label { font-size:0.8rem; font-weight:500; color:#6c757d; }

    /* ===== Table ===== */
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

    /* ===== Buttons ===== */
    .btn-modern {
        border:none;
        padding:7px 14px;
        border-radius:8px;
        font-size:0.8rem;
        font-weight:600;
        transition:all .2s;
    }
    .btn-modern:hover { opacity:.9; }
    .btn-add    { background: linear-gradient(135deg,#43e97b,#38f9d7); color:#fff; }
    .btn-fltr   { background: linear-gradient(135deg,#43e97b,#38f9d7); color:#fff; }
    .btn-riset  { background: linear-gradient(135deg,#ff6b6b,#ee5a5a); color:#fff; }
    .btn-excel  { background: linear-gradient(135deg,#43cea2,#185a9d); color:#fff; }
    .btn-pdf    { background: linear-gradient(135deg,#ff6b6b,#ee5a5a); color:#fff; }
    .btn-edit   { background: linear-gradient(135deg,#51cf66,#2ecc71); color:#fff; }
    .btn-delete { background: linear-gradient(135deg,#ffa94d,#ff922b); color:#fff; }
    .btn-detail { background: linear-gradient(135deg,#54a0ff,#2e86de); color:#fff; }

    .table-actions {
        background:#f8f9fa;
        padding:15px 25px;
        border-top:1px solid #e9ecef;
        display:flex;
        justify-content:space-between;
        align-items:center;
    }
</style>

<div class="page-container">
    <div class="container-fluid">
        {{-- ===== Header ===== --}}
        <div class="page-header" data-aos="fade-down">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">🔌 Inspeksi Stavolt</h2>
                    <p class="mb-0">Kelola data hasil inspeksi perangkat Stavolt</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('inspeksistavolt.create') }}" class="btn btn-add btn-modern">
                        <i class="fas fa-plus me-1"></i> Tambah Inspeksi
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== Statistik ===== --}}
        <div class="row g-3 mb-3">
            <div class="col-6 col-md-2-4">
                <div class="stat-card">
                    <div class="stat-icon">⚡</div>
                    <div class="stat-number">{{ $data->count() }}</div>
                    <div class="stat-label">Total Inspeksi</div>
                </div>
            </div>
            <div class="col-6 col-md-2-4">
                <div class="stat-card">
                    <div class="stat-icon">📍</div>
                    <div class="stat-number">{{ $data->pluck('lokasi')->unique()->count() }}</div>
                    <div class="stat-label">Lokasi Berbeda</div>
                </div>
            </div>
        </div>


{{-- ===== FILTER TANGGAL / BULAN / TAHUN ===== --}}
<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-danger mb-0">🔍 Filter Data Inspeksi</h6>
            <small class="text-muted">Sesuaikan pencarian data</small>
        </div>

        <form method="GET" action="{{ route('inspeksistavolt.index') }}" class="row g-3 align-items-end">

            {{-- Filter Tanggal --}}
            <div class="col-md-4">
                <label class="fw-semibold">📅 Tanggal</label>
                <input type="date" name="tanggal"
                       class="form-control rounded-3"
                       value="{{ request('tanggal') }}">
            </div>

            {{-- Filter Bulan --}}
            <div class="col-md-3">
                <label class="fw-semibold">🗓️ Bulan</label>
                <select name="bulan" class="form-select rounded-3">
                    <option value="">Semua Bulan</option>
                    @for($i=1;$i<=12;$i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$i,1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Filter Tahun --}}
            <div class="col-md-3">
                <label class="fw-semibold">📆 Tahun</label>
                <select name="tahun" class="form-select rounded-3">
                    <option value="">Semua Tahun</option>
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Tombol --}}
            <div class="col-md-2 d-grid gap-2">
                <button type="submit" class="btn btn-fltr fw-bold rounded-3">
                    Filter
                </button>
                <a href="{{ route('inspeksistavolt.index') }}" class="btn btn-riset fw-bold rounded-3">
                    Reset
                </a>
            </div>

        </form>
    </div>
</div>


        {{-- ===== Table ===== --}}
        <div class="table-card" data-aos="fade-up">
            <div class="table-header">
                <h4 class="table-title">📋 Data Inspeksi Stavolt</h4>
                <small class="table-subtitle">Total: {{ $data->count() }} data</small>
            </div>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Aset</th>
                            <th>Merek</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nomor_aset }}</td>
                            <td>{{ $row->merek }}</td>
                            <td>{{ $row->lokasi }}</td>
                            <td>{{ optional($row->tanggal_inspeksi)->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('inspeksistavolt.edit', $row->id) }}" class="btn btn-edit btn-modern">Edit</a>
                                <a href="{{ route('inspeksistavolt.report', $row->id) }}"
                                    class="btn btn-pdf btn-modern" target="_blank">
                                    PDF
                                </a>
                                <form action="{{ route('inspeksistavolt.destroy', $row->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-modern" onclick="return confirm('Yakin hapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">📭 Belum ada data inspeksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-actions">
                <div>
                    <a href="{{ route('inspeksistavolt.export.excel') }}" class="btn btn-excel btn-modern">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
