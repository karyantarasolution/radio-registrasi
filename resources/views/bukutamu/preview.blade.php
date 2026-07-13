@extends('layouts.app')

@section('content')
<style>
    .preview-container {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .preview-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    .report-logo {
        text-align: center;
        margin-bottom: 16px;
    }
    .report-logo img {
        max-width: 280px;
        height: auto;
    }
    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .report-table th,
    .report-table td {
        border: 1px solid #333;
        padding: 8px;
        text-align: center;
    }
    .report-table th {
        background-color: #f2f2f2;
    }
    .report-table .judul {
        background-color: #d9d9d9;
        font-weight: bold;
        font-size: 14px;
        text-transform: uppercase;
    }
    @media print {
        .sidebar, .navbar-custom, footer, .preview-actions, .no-print {
            display: none !important;
        }
        .content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .preview-container {
            box-shadow: none;
            padding: 0;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="preview-container">
        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
            <h4 class="fw-bold mb-0">Pratinjau Laporan Buku Tamu</h4>
            <small class="text-muted">Periksa data sebelum cetak atau unduh PDF</small>
        </div>

        <div class="preview-actions no-print">
            <a href="{{ route('bukutamu.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.print()">Cetak</button>
            <a href="{{ route('bukutamu.export.pdf') }}" target="_blank" class="btn btn-outline-danger btn-sm">Buka PDF</a>
            <a href="{{ route('bukutamu.export.pdf.download') }}" class="btn btn-danger btn-sm">Unduh PDF</a>
        </div>

        <div class="report-logo">
            <img src="{{ asset('images/ppa-logo.png') }}" alt="Logo PPA">
        </div>

        <div class="table-responsive">
            <table class="report-table">
                <thead>
                    <tr>
                        <th class="judul" colspan="9">LAPORAN BUKU TAMU</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No Telepon</th>
                        <th>NRP</th>
                        <th>Instansi</th>
                        <th>Keperluan</th>
                        <th>PIC</th>
                        <th>Departemen PIC</th>
                        <th>Tanggal Registrasi</th>
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
                        <td>{{ $tamu->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">Belum ada data buku tamu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
