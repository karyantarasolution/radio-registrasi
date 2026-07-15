@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    .table-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .table-title { font-size: 1.25rem; font-weight: bold; margin: 0; }
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
    .dropdown-action .dropdown-toggle::after { display: none; }
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
    .dropdown-action .btn-action:hover { opacity: 0.8; }
    .dropdown-action .dropdown-menu {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        padding: 6px 0;
        min-width: 200px;
        font-size: 0.83rem;
    }
    .dropdown-action .dropdown-item {
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }
    .dropdown-action .dropdown-item i { width: 18px; text-align: center; }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="page-header" data-aos="fade-down">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">📋 Pengajuan Barang IT</h2>
                    <p class="mb-0">Pengajuan pembelian & maintenance perangkat IT</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-add btn-modern">
                        <i class="fas fa-plus me-1"></i> Ajukan Pengajuan
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="table-card" data-aos="fade-up">
            <div class="table-header">
                <div>
                    <h4 class="table-title">Daftar Pengajuan</h4>
                    <small>Total: {{ $pengajuans->count() }} data
                        @if(Auth::user()->isPimpinan() && $pendingCount > 0)
                            &middot; {{ $pendingCount }} menunggu persetujuan
                        @endif
                    </small>
                </div>
                <form method="GET" action="{{ route('pengajuan.index') }}" style="display:flex; gap:8px;">
                    <select name="status" onchange="this.form.submit()" style="border-radius:8px; border:none; padding:6px 10px; font-size:0.85rem; font-weight:600; background:rgba(255,255,255,0.9); color:#333;">
                        <option value="">Semua Status</option>
                        @foreach(['Menunggu','Disetujui','Ditolak'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <select name="kategori" onchange="this.form.submit()" style="border-radius:8px; border:none; padding:6px 10px; font-size:0.85rem; font-weight:600; background:rgba(255,255,255,0.9); color:#333;">
                        <option value="">Semua Kategori</option>
                        @foreach(['Pembelian','Maintenance'] as $k)
                            <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Estimasi Biaya</th>
                            <th>Diajukan Oleh</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            @if(Auth::user()->isPimpinan())<th>Aksi</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuans as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><code style="font-size:0.75rem;">{{ $p->nomor_pengajuan }}</code></td>
                            <td class="fw-semibold">{{ $p->judul }}</td>
                            <td>
                                <span class="badge {{ $p->kategori == 'Pembelian' ? 'bg-primary' : 'bg-warning text-dark' }}">
                                    {{ $p->kategori }}
                                </span>
                            </td>
                            <td>
                                {{ $p->nama_barang }}
                                @if($p->kategori === 'Maintenance' && $p->gudangBarang)
                                    <br><small class="text-muted">Kondisi: {{ $p->gudangBarang->kondisi }}</small>
                                @endif
                            </td>
                            <td>{{ $p->jumlah_diminta }} {{ $p->satuan }}</td>
                            <td>-</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td><small>{{ $p->tanggal_pengajuan?->format('d/m/Y') ?? '-' }}</small></td>
                            <td>
                                @php
                                    $statusColor = match($p->status) {
                                        'Disetujui' => '#28a745',
                                        'Ditolak' => '#dc3545',
                                        default => '#ffc107',
                                    };
                                    $statusTextColor = $p->status === 'Menunggu' ? '#333' : '#fff';
                                @endphp
                                <span class="badge-status" style="background:{{ $statusColor }}; color:{{ $statusTextColor }};">
                                    {{ $p->status }}
                                </span>
                            </td>
                            @if(Auth::user()->isPimpinan())
                            <td>
                                @if($p->status === 'Menunggu')
                                    <div style="display:flex; gap:4px; justify-content:center;">
                                        <button type="button" class="action-btn btn-success" title="Setujui" onclick="approvePengajuan({{ $p->id }}, 'Disetujui')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="action-btn btn-danger" title="Tolak" onclick="approvePengajuan({{ $p->id }}, 'Ditolak')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::user()->isPimpinan() ? 11 : 10 }}" class="text-center text-muted py-5">
                                <div style="font-size:2.5rem; margin-bottom:8px;">📭</div>
                                Belum ada pengajuan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden;">
            <div style="padding: 20px 24px; color: #fff;" id="approveModalHeader">
                <h5 class="mb-0 fw-bold" id="approveModalTitle">Konfirmasi</h5>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <input type="hidden" name="status" id="approveStatus">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan (opsional)</label>
                        <textarea name="catatan_pimpinan" class="form-control" rows="3" style="border-radius:10px;" placeholder="Tambahkan catatan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="submit" class="btn" id="approveBtn" style="border-radius:10px; padding:8px 24px; color:#fff;">
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approvePengajuan(id, status) {
    document.getElementById('approveForm').action = '/pengajuan/' + id + '/approve';
    document.getElementById('approveStatus').value = status;
    var header = document.getElementById('approveModalHeader');
    var btn = document.getElementById('approveBtn');

    if (status === 'Disetujui') {
        header.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
        document.getElementById('approveModalTitle').textContent = 'Setujui Pengajuan';
        btn.textContent = 'Setujui';
        btn.style.background = '#28a745';
    } else {
        header.style.background = 'linear-gradient(135deg, #dc3545, #e74c3c)';
        document.getElementById('approveModalTitle').textContent = 'Tolak Pengajuan';
        btn.textContent = 'Tolak';
        btn.style.background = '#dc3545';
    }

    var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('approveModal'));
    modal.show();
}
</script>
@endsection
