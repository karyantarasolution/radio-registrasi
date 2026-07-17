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

    .account-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .account-header {
        background: linear-gradient(135deg, #2c3e50, #34495e);
        color: #fff;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .account-header h6 { margin: 0; font-weight: 700; }
    .badge-nrp { background: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; }
    .table-custom { width: 100%; border-collapse: collapse; }
    .table-custom thead { background: #f8f9fa; }
    .table-custom th {
        padding: 10px; font-weight: 600; text-align: center;
        border-bottom: 2px solid #dee2e6; font-size: 0.78rem;
        text-transform: uppercase; color: #495057;
    }
    .table-custom td {
        padding: 8px 10px; text-align: center; border-top: 1px solid #f1f1f1;
        font-size: 0.85rem; vertical-align: middle;
    }
    .badge-status {
        padding: 4px 10px; border-radius: 20px; color: white;
        font-weight: 600; font-size: 0.72rem; display: inline-block;
    }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="page-header" data-aos="fade-down">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1"><i class="fas fa-history me-2"></i>Riwayat Peminjaman</h2>
                    <p class="mb-0">Riwayat peminjaman perangkat IT per akun karyawan</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('inventaris.riwayat-pdf') }}" class="btn btn-sm" style="background:linear-gradient(135deg, #ff6b6b, #ee5a5a); color:#fff; border-radius:10px;" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i> Cetak PDF
                    </a>
                    <a href="{{ route('inventaris.index') }}" class="btn btn-sm" style="background:rgba(255,255,255,0.2); color:#fff; border-radius:10px;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        @forelse($riwayat as $nrp => $items)
            @php $first = $items->first(); @endphp
            <div class="account-card" data-aos="fade-up">
                <div class="account-header">
                    <div>
                        <h6><i class="fas fa-user me-2"></i>{{ $first->nama }}</h6>
                        <small class="opacity-75">{{ $items->count() }} peminjaman</small>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="{{ route('inventaris.riwayat-pdf-akun', $nrp) }}" class="btn btn-sm" style="background:rgba(255,255,255,0.2); color:#fff; border-radius:8px; font-size:0.75rem;" target="_blank" title="Cetak PDF {{ $first->nama }}">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </a>
                        <span class="badge-nrp">NRP: {{ $nrp }}</span>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Perangkat</th>
                                <th>Tgl Pinjam</th>
                                <th>Estimasi Kembali</th>
                                <th>Tgl Aktual Kembali</th>
                                <th>Status</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $item->nama_perangkat }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') }}</td>
                                <td>{{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->tanggal_actual_kembali ? \Carbon\Carbon::parse($item->tanggal_actual_kembali)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @php
                                        $color = match($item->status_peminjaman) {
                                            'Dikembalikan' => '#28a745',
                                            'Belum Dikembalikan' => '#dc3545',
                                            'Menunggu Persetujuan' => '#17a2b8',
                                            default => '#ffc107',
                                        };
                                        $textColor = $item->status_peminjaman === 'Pending' ? '#333' : '#fff';
                                    @endphp
                                    <span class="badge-status" style="background:{{ $color }}; color:{{ $textColor }};">
                                        {{ $item->status_peminjaman }}
                                    </span>
                                </td>
                                <td>{{ $item->kondisi_pengembalian ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="text-center py-5" data-aos="fade-up">
                <div style="font-size:3rem; margin-bottom:10px;">📭</div>
                <h5 class="text-muted">Belum ada riwayat peminjaman</h5>
            </div>
        @endforelse
    </div>
</div>
@endsection
