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
                    <h2 class="fw-bold mb-1">📖 Buku Tamu</h2>
                    <p class="mb-0">Kelola data tamu perusahaan</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('bukutamu.create') }}" class="btn btn-add btn-modern">
                        <i class="fas fa-plus me-1"></i> Tambah Tamu
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== Statistik ===== --}}
        @if(Auth::user()->name == 'ICT')
        <div class="row g-3 mb-3">
            <div class="col-6 col-md-2-4">
                <div class="stat-card">
                    <div class="stat-icon">👤</div>
                    <div class="stat-number">{{ $bukutamu->count() }}</div>
                    <div class="stat-label">Total Tamu</div>
                </div>
            </div>
            <div class="col-6 col-md-2-4">
                <div class="stat-card">
                    <div class="stat-icon">🏢</div>
                    <div class="stat-number">{{ $bukutamu->pluck('instansi')->unique()->count() }}</div>
                    <div class="stat-label">Instansi</div>
                </div>
            </div>
        </div>
        @endif

        {{-- ===== Table ===== --}}
        <div class="table-card" data-aos="fade-up">
            <div class="table-header">
                <h4 class="table-title">📋 Data Buku Tamu</h4>
                <small class="table-subtitle">Total: {{ $bukutamu->count() }} tamu</small>
            </div>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No. Telepon</th>
                            <th>NRP / NIK</th>
                            <th>Instansi</th>
                            <th>Keperluan</th>
                            <th>PIC</th>
                            <th>Departemen PIC</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bukutamu as $tamu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tamu->nama }}</td>
                            <td>{{ $tamu->no_telp ?? '-' }}</td>
                            <td>{{ $tamu->nrp }}</td>
                            <td>{{ $tamu->instansi }}</td>
                            <td>{{ $tamu->keperluan }}</td>
                            <td>{{ $tamu->pic->nama ?? '-' }}</td>
                            <td>{{ $tamu->pic->departemen ?? '-' }}</td>
                            <td>
                                <a href="{{ route('bukutamu.edit', $tamu) }}" class="btn btn-edit btn-modern">Edit</a>
                                <form action="{{ route('bukutamu.destroy', $tamu) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-modern" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">📭 Belum ada tamu</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-actions">
                <div>
                   @if(Auth::user()->name == 'ICT')
                        <a href="{{ route('bukutamu.report.preview') }}" class="btn btn-pdf btn-modern">
                            <i class="fas fa-eye me-1"></i> Lihat Laporan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
