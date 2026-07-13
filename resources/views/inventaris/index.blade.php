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
    }
    .btn-modern:hover { opacity:.9; }
    .btn-add    { background: linear-gradient(135deg,#43e97b,#38f9d7); color:#fff; }
    .btn-pdf    { background: linear-gradient(135deg,#ff6b6b,#ee5a5a); color:#fff; }
    .btn-edit   { background: linear-gradient(135deg,#51cf66,#2ecc71); color:#fff; }
    .btn-delete { background: linear-gradient(135deg,#ffa94d,#ff922b); color:#fff; }

    .table-actions {
        background:#f8f9fa;
        padding:15px 25px;
        border-top:1px solid #e9ecef;
        display:flex;
        justify-content:space-between;
        align-items:center;
    }

    .badge-status {
        padding:6px 12px;
        border-radius:10px;
        color:white;
        font-weight:600;
        font-size:0.85rem;
    }

    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }
    .filter-form select {
        border-radius: 8px;
        border: none;
        padding: 6px 10px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .verify-select {
        border-radius: 6px;
        border: 1px solid #dee2e6;
        padding: 4px 8px;
        font-size: 0.75rem;
        max-width: 110px;
    }
</style>

<div class="page-container">
    <div class="container-fluid">

        {{-- ===== Header ===== --}}
        <div class="page-header" data-aos="fade-down">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">📦 Inventaris Perangkat IT</h2>
                    <p class="mb-0">Kelola data peminjaman dan pengembalian perangkat IT</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('inventaris.create') }}" class="btn btn-add btn-modern">
                        <i class="fas fa-plus me-1"></i> Tambah Inventaris
                    </a>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- ===== Statistik ===== --}}
        <div class="row g-3 mb-3">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-number">{{ $chartStats['total'] }}</div>
                    <div class="stat-label">Total Data</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon text-warning">⏳</div>
                    <div class="stat-number">{{ $chartStats['pending'] }}</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon text-success">✅</div>
                    <div class="stat-number">{{ $chartStats['dikembalikan'] }}</div>
                    <div class="stat-label">Sudah Dikembalikan</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon text-danger">🔴</div>
                    <div class="stat-number">{{ $chartStats['belum'] }}</div>
                    <div class="stat-label">Belum Dikembalikan</div>
                </div>
            </div>
        </div>

        {{-- ===== Table ===== --}}
        <div class="table-card" data-aos="fade-up">
            <div class="table-header">
                <div>
                    <h4 class="table-title">📋 Data Inventaris</h4>
                    <small class="table-subtitle">
                        Total: {{ $inventaris->count() }} data
                        @if(Auth::user()->name == 'ICT' && $pendingCount > 0)
                            · {{ $pendingCount }} menunggu verifikasi
                        @endif
                    </small>
                </div>

                <form method="GET" action="{{ route('inventaris.index') }}" class="filter-form">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">Semua Peminjaman</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Belum Dikembalikan" {{ request('status') == 'Belum Dikembalikan' ? 'selected' : '' }}>Belum Dikembalikan</option>
                        <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                    <select name="verifikasi" onchange="this.form.submit()">
                        <option value="">Semua Verifikasi</option>
                        <option value="Pending" {{ request('verifikasi') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Disetujui" {{ request('verifikasi') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('verifikasi') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NRP</th>
                            <th>Nama Perangkat</th>
                            <th>No Asset</th>
                            <th>Status Peminjaman</th>
                            <th>Status Verifikasi</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventaris as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nrp }}</td>
                            <td>{{ $item->nama_perangkat }}</td>
                            <td>{{ $item->no_asset }}</td>
                            <td>
                                @php
                                    $pinjamColor = match($item->status_peminjaman) {
                                        'Dikembalikan' => '#28a745',
                                        'Belum Dikembalikan' => '#dc3545',
                                        default => '#ffc107',
                                    };
                                    $pinjamText = $item->status_peminjaman === 'Pending' ? '#333' : '#fff';
                                @endphp
                                <span class="badge-status" style="background:{{ $pinjamColor }}; color:{{ $pinjamText }};">
                                    {{ $item->status_peminjaman }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $verifColor = match($item->status_verifikasi ?? 'Pending') {
                                        'Disetujui' => '#28a745',
                                        'Ditolak' => '#dc3545',
                                        default => '#ffc107',
                                    };
                                    $verifTextColor = ($item->status_verifikasi ?? 'Pending') === 'Pending' ? '#333' : '#fff';
                                @endphp
                                <span class="badge-status" style="background:{{ $verifColor }}; color:{{ $verifTextColor }};">
                                    {{ $item->status_verifikasi ?? 'Pending' }}
                                </span>
                            </td>
                            <td>{{ $item->tanggal_peminjaman }}</td>
                            <td>{{ $item->tanggal_pengembalian ?? '-' }}</td>
                            <td>
                                @if(Auth::user()->name == 'ICT')
                                    <form action="{{ route('inventaris.peminjaman', $item->id) }}" method="POST" style="display:inline-block; margin-bottom:4px;">
                                        @csrf @method('PATCH')
                                        @if(request('status'))
                                            <input type="hidden" name="status" value="{{ request('status') }}">
                                        @endif
                                        @if(request('verifikasi'))
                                            <input type="hidden" name="verifikasi" value="{{ request('verifikasi') }}">
                                        @endif
                                        <select name="status_peminjaman" class="verify-select" onchange="this.form.submit()" title="Ubah status peminjaman">
                                            <option value="Pending" @selected($item->status_peminjaman == 'Pending')>Pending</option>
                                            @if($item->status_verifikasi === 'Disetujui')
                                                <option value="Belum Dikembalikan" @selected($item->status_peminjaman == 'Belum Dikembalikan')>Belum Dikembalikan</option>
                                                <option value="Dikembalikan" @selected($item->status_peminjaman == 'Dikembalikan')>Dikembalikan</option>
                                            @endif
                                        </select>
                                    </form>
                                    <br>
                                    <form action="{{ route('inventaris.verifikasi', $item->id) }}" method="POST" style="display:inline-block; margin-bottom:4px;">
                                        @csrf @method('PATCH')
                                        @if(request('status'))
                                            <input type="hidden" name="status" value="{{ request('status') }}">
                                        @endif
                                        @if(request('verifikasi'))
                                            <input type="hidden" name="verifikasi" value="{{ request('verifikasi') }}">
                                        @endif
                                        <select name="status_verifikasi" class="verify-select" onchange="this.form.submit()" title="Ubah status verifikasi">
                                            @foreach(['Pending', 'Disetujui', 'Ditolak'] as $v)
                                                <option value="{{ $v }}" @selected(($item->status_verifikasi ?? 'Pending') == $v)>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                    <br>
                                @endif
                                <a href="{{ route('inventaris.edit', $item->id) }}" class="btn btn-edit btn-modern">Edit</a>
                                <form action="{{ route('inventaris.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-modern" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-5">📭 Belum ada data inventaris</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-actions">
                @if(Auth::user()->name == 'ICT')
                    <a href="{{ route('inventaris.report') }}" class="btn btn-pdf btn-modern">
                        <i class="fas fa-file-pdf me-1"></i> Cetak PDF
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
