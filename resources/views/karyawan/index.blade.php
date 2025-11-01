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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title { font-size: 1.3rem; font-weight: bold; margin: 0; }
    .table-subtitle { font-size: 0.8rem; font-weight: 500; }

    .table-custom { width: 100%; border-collapse: collapse; }
    .table-custom thead { background: #f8f9fa; }
    .table-custom th {
        padding: 12px;
        font-weight: 600;
        text-align: center;
        border-bottom: 2px solid #dee2e6;
    }
    .table-custom td {
        padding: 10px;
        text-align: center;
        border-top: 1px solid #f1f1f1;
        font-size: 14px;
    }
    .table-custom tbody tr:hover { background: #f8f9fa; }

    /* ===== Buttons ===== */
    .btn-modern {
        border: none;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all .2s;
    }
    .btn-modern:hover { opacity: .9; }
    .btn-add    { background: linear-gradient(135deg,#43e97b,#38f9d7); color:#fff; }
    .btn-excel  { background: linear-gradient(135deg,#43cea2,#185a9d); color:#fff; }
    .btn-edit   { background: linear-gradient(135deg,#51cf66,#2ecc71); color:#fff; }
    .btn-delete { background: linear-gradient(135deg,#ffa94d,#ff922b); color:#fff; }

    .table-actions {
        background: #f8f9fa;
        padding: 15px 25px;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<div class="page-container">
    <div class="container-fluid">

        {{-- ===== Header ===== --}}
        <div class="page-header" data-aos="fade-down">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">👨‍💼 Data Karyawan IT</h2>
                    <p class="mb-0">Kelola data dan tanda tangan barcode karyawan bagian IT</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('karyawan.create') }}" class="btn btn-add btn-modern">
                        <i class="fas fa-plus me-1"></i> Tambah Karyawan
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== Table ===== --}}
        <div class="table-card" data-aos="fade-up">
            <div class="table-header">
                <h4 class="table-title">📋 Daftar Karyawan IT</h4>
                <small class="table-subtitle">Total: {{ $karyawans->count() }} data</small>
            </div>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NRP</th>
                            <th>Jabatan</th>
                            <th>Departemen</th>
                            <th>QR Code</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($karyawans as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama }}</td>
                            <td>{{ $k->nrp }}</td>
                            <td>{{ $k->jabatan }}</td>
                            <td>{{ $k->departemen }}</td>
                            <td>
                                @if($k->qr_code)
                                    <img src="{{ asset('storage/qr_codes/' . $k->qr_code) }}" width="50" alt="QR Code">
                                @else
                                    <span class="text-muted">Belum ada</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('karyawan.edit', $k->id) }}" class="btn btn-edit btn-modern">Edit</a>
                                <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-modern" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">📭 Belum ada data karyawan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-actions">
                <div>
                    <a href="{{ route('karyawan.export') }}" class="btn btn-excel btn-modern">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
