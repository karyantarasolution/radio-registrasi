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

    .table-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .table-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 15px 25px;
    }
    .table-custom { width: 100%; border-collapse: collapse; }
    .table-custom thead { background: #f8f9fa; }
    .table-custom th {
        padding: 12px 10px; font-weight: 600; text-align: center;
        border-bottom: 2px solid #dee2e6; font-size: 0.78rem;
        text-transform: uppercase; color: #495057;
    }
    .table-custom td {
        padding: 10px; text-align: center; border-top: 1px solid #f1f1f1;
        font-size: 0.85rem; vertical-align: middle;
    }
    .table-custom tbody tr:hover { background: #f8f9fa; }
    .action-btn {
        border: none; width: 30px; height: 30px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.75rem; cursor: pointer; transition: all .2s;
        padding: 0; color: #fff; text-decoration: none;
    }
    .action-btn:hover { opacity: 0.8; transform: translateY(-1px); color: #fff; }
    .action-btn.btn-success { background: linear-gradient(135deg, #28a745, #20c997); }
    .action-btn.btn-danger { background: linear-gradient(135deg, #dc3545, #e74c3c); }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="page-header" data-aos="fade-down">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1"><i class="fas fa-user-cog me-2"></i>Daftar Akun Inventaris</h2>
                    <p class="mb-0">Kelola akun karyawan yang mendaftar untuk peminjaman inventaris</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('inventaris.index') }}" class="btn btn-sm" style="background:rgba(255,255,255,0.2); color:#fff; border-radius:10px;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="table-card" data-aos="fade-up">
            <div class="table-header">
                <h4 class="mb-0" style="font-size:1.1rem; font-weight:bold;">Daftar Akun Karyawan</h4>
                <small>Total: {{ $akunKaryawan->count() }} akun</small>
            </div>

            <div style="overflow-x:auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NRP</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Tgl Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($akunKaryawan as $akun)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $akun->name }}</td>
                            <td><code>{{ $akun->nrp ?? '-' }}</code></td>
                            <td>{{ $akun->jabatan ?? '-' }}</td>
                            <td>
                                @if($akun->is_approved)
                                    <span class="badge-status" style="background:#28a745; color:#fff;">Disetujui</span>
                                @else
                                    <span class="badge-status" style="background:#ffc107; color:#333;">Menunggu</span>
                                @endif
                            </td>
                            <td><small>{{ $akun->created_at->format('d/m/Y') }}</small></td>
                            <td>
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    @if(!$akun->is_approved)
                                        <form action="{{ route('admin.approve-akun', $akun->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="action-btn btn-success" title="Setujui"><i class="fas fa-check"></i></button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.destroy-akun', $akun->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn btn-danger" title="Hapus" onclick="return confirm('Yakin hapus akun ini?')"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <div style="font-size:2.5rem; margin-bottom:8px;">📭</div>
                                Belum ada akun karyawan
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
