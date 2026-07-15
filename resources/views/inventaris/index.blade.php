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
    }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-20px)} }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px 15px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-2px); }
    .stat-icon { font-size: 1.6rem; margin-bottom: 4px; }
    .stat-number { font-size: 1.5rem; font-weight: 700; color: #2c3e50; }
    .stat-label { font-size: 0.78rem; font-weight: 500; color: #6c757d; margin-top: 2px; }

    .table-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .table-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .table-title { font-size: 1.25rem; font-weight: bold; margin: 0; }
    .table-subtitle { font-size: 0.8rem; font-weight: 500; }
    .table-custom { width: 100%; border-collapse: collapse; }
    .table-custom thead { background: #f8f9fa; }
    .table-custom th {
        padding: 12px 10px;
        font-weight: 600;
        text-align: center;
        border-bottom: 2px solid #dee2e6;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #495057;
    }
    .table-custom td {
        padding: 10px;
        text-align: center;
        border-top: 1px solid #f1f1f1;
        font-size: 0.85rem;
        vertical-align: middle;
    }
    .table-custom tbody tr:hover { background: #f8f9fa; }

    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        color: white;
        font-weight: 600;
        font-size: 0.72rem;
        display: inline-block;
        letter-spacing: 0.3px;
    }

    .btn-modern {
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all .2s;
        cursor: pointer;
    }
    .btn-modern:hover { opacity: .85; transform: translateY(-1px); }
    .btn-add { background: linear-gradient(135deg, #43e97b, #38f9d7); color: #fff; }
    .btn-pdf { background: linear-gradient(135deg, #ff6b6b, #ee5a5a); color: #fff; }

    .table-actions {
        background: #f8f9fa;
        padding: 12px 25px;
        border-top: 1px solid #e9ecef;
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
        font-size: 0.85rem;
        font-weight: 600;
        background: rgba(255,255,255,0.9);
        color: #333;
    }

    .overdue-badge {
        background: #fff3cd;
        color: #856404;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.68rem;
        font-weight: 700;
        display: inline-block;
        margin-top: 4px;
    }
    .dropdown-action .dropdown-toggle::after { display: none; }
    .dropdown-action { position: static !important; }
    .dropdown-action .btn-action {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        border: none;
        width: 32px; height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all .2s;
        padding: 0;
    }
    .dropdown-action .btn-action:hover { opacity: 0.8; transform: translateY(-1px); }
    .action-btn {
        border: none;
        width: 30px; height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all .2s;
        padding: 0;
        color: #fff;
        text-decoration: none;
    }
    .action-btn:hover { opacity: 0.8; transform: translateY(-1px); color: #fff; }
    .action-btn.btn-success { background: linear-gradient(135deg, #28a745, #20c997); }
    .action-btn.btn-danger { background: linear-gradient(135deg, #dc3545, #e74c3c); }
    .action-btn.btn-warning { background: linear-gradient(135deg, #e67e22, #f39c12); }
    .action-btn.btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
    .action-btn.btn-info { background: linear-gradient(135deg, #17a2b8, #20c997); }
</style>

<div class="page-container">
    <div class="container-fluid">

        <div class="page-header" data-aos="fade-down">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">📦 Inventaris Perangkat IT</h2>
                    <p class="mb-0">Kelola data peminjaman dan pengembalian perangkat IT</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('inventaris.create') }}" class="btn btn-add btn-modern">
                        <i class="fas fa-plus me-1"></i> Ajukan Peminjaman
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-number">{{ $chartStats['total'] }}</div>
                    <div class="stat-label">Total Data</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-number" style="color:#e67e22;">{{ $chartStats['pending'] }}</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-number" style="color:#28a745;">{{ $chartStats['dikembalikan'] }}</div>
                    <div class="stat-label">Dikembalikan</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">🔴</div>
                    <div class="stat-number" style="color:#dc3545;">{{ $chartStats['belum'] }}</div>
                    <div class="stat-label">Belum Dikembalikan</div>
                </div>
            </div>
        </div>

        <div class="table-card" data-aos="fade-up">
            <div class="table-header">
                <div>
                    <h4 class="table-title">📋 Data Inventaris</h4>
                    <small class="table-subtitle">
                        Total: {{ $inventaris->count() }} data
                        @if(Auth::user()->isAdmin() && $pendingCount > 0)
                            &middot; {{ $pendingCount }} menunggu verifikasi
                        @endif
                        @if(Auth::user()->isPimpinan() && $pendingApprovalCount > 0)
                            &middot; {{ $pendingApprovalCount }} menunggu persetujuan
                        @endif
                    </small>
                </div>
                <form method="GET" action="{{ route('inventaris.index') }}" class="filter-form">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">Semua Peminjaman</option>
                        @foreach(['Pending','Menunggu Persetujuan','Belum Dikembalikan','Dikembalikan'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <select name="verifikasi" onchange="this.form.submit()">
                        <option value="">Semua Verifikasi</option>
                        @foreach(['Pending','Disetujui','Ditolak'] as $v)
                            <option value="{{ $v }}" {{ request('verifikasi') == $v ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                    <select name="persetujuan" onchange="this.form.submit()">
                        <option value="">Semua Persetujuan</option>
                        @foreach(['Pending','Disetujui','Ditolak'] as $p)
                            <option value="{{ $p }}" {{ request('persetujuan') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div style="overflow-x:auto; position:relative;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NRP</th>
                            <th>Perangkat</th>
                            <th>No Asset</th>
                            <th>Peminjaman</th>
                            <th>Verifikasi</th>
                            <th>Persetujuan</th>
                            <th>Tgl Pinjam</th>
                            <th style="width:80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventaris as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $item->nama }}</td>
                            <td><code>{{ $item->nrp }}</code></td>
                            <td>{{ $item->nama_perangkat }}</td>
                            <td><small>{{ $item->no_asset }}</small></td>
                            <td>
                                @php
                                    $pinjamColor = match($item->status_peminjaman) {
                                        'Dikembalikan' => '#28a745',
                                        'Belum Dikembalikan' => '#dc3545',
                                        'Menunggu Persetujuan' => '#17a2b8',
                                        default => '#ffc107',
                                    };
                                    $pinjamText = $item->status_peminjaman === 'Pending' ? '#333' : '#fff';
                                @endphp
                                <span class="badge-status" style="background:{{ $pinjamColor }}; color:{{ $pinjamText }};">
                                    {{ $item->status_peminjaman }}
                                </span>
                                @if($item->status_peminjaman === 'Belum Dikembalikan' && $item->isOverdue())
                                    <br><span class="overdue-badge">⚠ Terlambat</span>
                                @endif
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
                            <td>
                                @php
                                    $persColor = match($item->status_persetujuan ?? 'Pending') {
                                        'Disetujui' => '#28a745',
                                        'Ditolak' => '#dc3545',
                                        default => '#ffc107',
                                    };
                                    $persTextColor = ($item->status_persetujuan ?? 'Pending') === 'Pending' ? '#333' : '#fff';
                                @endphp
                                <span class="badge-status" style="background:{{ $persColor }}; color:{{ $persTextColor }};">
                                    {{ $item->status_persetujuan ?? 'Pending' }}
                                </span>
                            </td>
                            <td>{{ $item->tanggal_peminjaman }}</td>
                            <td>
                                <div style="display:flex; gap:4px; flex-wrap:wrap; justify-content:center;">
                                    @if(Auth::user()->isAdmin() && ($item->status_verifikasi ?? 'Pending') === 'Pending')
                                        <form action="{{ route('inventaris.verifikasi', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status_verifikasi" value="Disetujui">
                                            <button type="submit" class="action-btn btn-success" title="Setujui Verifikasi"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('inventaris.verifikasi', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status_verifikasi" value="Ditolak">
                                            <button type="submit" class="action-btn btn-danger" title="Tolak Verifikasi" onclick="return confirm('Tolak verifikasi ini?')"><i class="fas fa-times"></i></button>
                                        </form>
                                    @endif

                                    @if(Auth::user()->isPimpinan() && ($item->status_verifikasi ?? '') === 'Disetujui' && ($item->status_persetujuan ?? 'Pending') === 'Pending')
                                        <form action="{{ route('inventaris.persetujuan', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status_persetujuan" value="Disetujui">
                                            <button type="submit" class="action-btn btn-success" title="Setujui Pengajuan"><i class="fas fa-thumbs-up"></i></button>
                                        </form>
                                        <form action="{{ route('inventaris.persetujuan', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status_persetujuan" value="Ditolak">
                                            <button type="submit" class="action-btn btn-danger" title="Tolak Pengajuan" onclick="return confirm('Tolak pengajuan ini?')"><i class="fas fa-thumbs-down"></i></button>
                                        </form>
                                    @endif

                                    @if($item->status_peminjaman === 'Belum Dikembalikan')
                                        <button type="button" class="action-btn btn-primary" title="Kembalikan" onclick="openReturnModal({{ $item->id }}, '{{ addslashes($item->nama_perangkat) }}')">
                                            <i class="fas fa-undo-alt"></i>
                                        </button>
                                    @endif

                                    @if(!Auth::user()->isPimpinan())
                                        <a href="{{ route('inventaris.edit', $item->id) }}" class="action-btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if(Auth::user()->isAdmin())
                                        <form action="{{ route('inventaris.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn btn-danger" title="Hapus" onclick="return confirm('Yakin hapus data ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-5">
                                <div style="font-size:2.5rem; margin-bottom:8px;">📭</div>
                                Belum ada data inventaris
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-actions">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('inventaris.report') }}" class="btn btn-pdf btn-modern">
                        <i class="fas fa-file-pdf me-1"></i> Cetak PDF
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden;">
            <div style="background: linear-gradient(135deg, #667eea, #764ba2); padding: 20px 24px; color: #fff;">
                <h5 class="mb-0 fw-bold"><i class="fas fa-undo-alt me-2"></i>Dokumentasi Pengembalian</h5>
            </div>
            <form id="returnForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-4">
                    <div class="alert alert-info mb-3" style="border-radius:10px; font-size:0.85rem;">
                        Barang: <strong id="returnItemName"></strong>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kondisi Barang <span class="text-danger">*</span></label>
                        <select name="kondisi_barang" class="form-select" style="border-radius:10px;" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Baik">✅ Baik</option>
                            <option value="Rusak Ringan">⚠️ Rusak Ringan</option>
                            <option value="Rusak Berat">❌ Rusak Berat</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" style="border-radius:10px;" placeholder="Catatan pengembalian (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #667eea, #764ba2); color:#fff; border-radius:10px; padding: 8px 24px;">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openReturnModal(id, name) {
    var form = document.getElementById('returnForm');
    form.action = '/inventaris/' + id + '/pengembalian';
    document.getElementById('returnItemName').textContent = name;
    var modalEl = document.getElementById('returnModal');
    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}
</script>
@endsection
