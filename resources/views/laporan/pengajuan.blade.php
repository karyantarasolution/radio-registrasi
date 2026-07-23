@extends('layouts.app')

@section('content')
<style>
    .page-container { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; padding: 20px 0; }
    .page-header { background: linear-gradient(135deg, #ea6666 0%, #f71414 100%); color: white; padding: 25px 30px; border-radius: 20px; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
    .table-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .table-header { background: linear-gradient(135deg, #ea6666, #f71414); color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
    .table-title { font-size: 1.1rem; font-weight: bold; margin: 0; }
    .table-custom { width:100%; border-collapse:collapse; }
    .table-custom thead { background:#f8f9fa; }
    .table-custom th { padding:10px; font-weight:600; text-align:center; border-bottom:2px solid #dee2e6; font-size:0.78rem; text-transform:uppercase; }
    .table-custom td { padding:8px 10px; text-align:center; border-top:1px solid #f1f1f1; font-size:0.85rem; }
    .table-custom tbody tr:hover { background:#f8f9fa; }
    .badge-status { padding:4px 10px; border-radius:20px; color:white; font-weight:600; font-size:0.72rem; display:inline-block; }
    .stat-row { display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap; }
    .stat-mini { background:#fff; border-radius:12px; padding:12px 16px; box-shadow:0 4px 10px rgba(0,0,0,0.05); flex:1; min-width:120px; text-align:center; }
    .stat-mini .num { font-size:1.4rem; font-weight:700; }
    .stat-mini .lbl { font-size:0.78rem; color:#6c757d; }
    .btn-back { background: linear-gradient(45deg, #7f8c8d, #95a5a6); color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; }
    .btn-back:hover { opacity: .9; color: #fff; }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="fw-bold mb-1"><i class="fas fa-clipboard-list me-2"></i>Laporan Pengajuan</h2>
                <p class="mb-0">Detail seluruh data pengajuan barang IT</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pimpinan.laporan.pdf.pengajuan') }}" class="btn btn-danger btn-sm fw-bold" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
                <a href="{{ route('pimpinan.laporan') }}" class="btn btn-light btn-sm fw-bold"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
        </div>

        <div class="stat-row">
            <div class="stat-mini"><div class="num" style="color:#2c3e50;">{{ $stats['total'] }}</div><div class="lbl">Total</div></div>
            <div class="stat-mini"><div class="num" style="color:#ffc107;">{{ $stats['menunggu'] }}</div><div class="lbl">Menunggu</div></div>
            <div class="stat-mini"><div class="num" style="color:#28a745;">{{ $stats['disetujui'] }}</div><div class="lbl">Disetujui</div></div>
            <div class="stat-mini"><div class="num" style="color:#dc3545;">{{ $stats['ditolak'] }}</div><div class="lbl">Ditolak</div></div>
            <div class="stat-mini"><div class="num" style="color:#17a2b8;">{{ $stats['selesai'] ?? 0 }}</div><div class="lbl">Selesai</div></div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h4 class="table-title">Data Pengajuan ({{ $pengajuans->count() }} data)</h4>
            </div>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr><th>No</th><th>Nomor</th><th>Judul</th><th>Kategori</th><th>Nama Barang</th><th>Jumlah</th><th>Estimasi Biaya</th><th>Diajukan Oleh</th><th>Tanggal</th><th>Status</th><th>Catatan</th></tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuans as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><code style="font-size:0.72rem;">{{ $p->nomor_pengajuan }}</code></td>
                            <td class="fw-semibold">{{ $p->judul }}</td>
                            <td><span class="badge {{ $p->kategori == 'Pembelian' ? 'bg-primary' : 'bg-warning text-dark' }}">{{ $p->kategori }}</span></td>
                            <td>{{ $p->nama_barang }}</td>
                            <td>{{ $p->jumlah_diminta }} {{ $p->satuan }}</td>
                            <td>@if($p->estimasi_biaya)<small>Rp {{ number_format($p->estimasi_biaya, 0, ',', '.') }}</small>@else - @endif</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td><small>{{ $p->tanggal_pengajuan?->format('d/m/Y') ?? '-' }}</small></td>
                            <td>
                                @php $sColor = match($p->status) { 'Disetujui' => '#28a745', 'Ditolak' => '#dc3545', 'Selesai' => '#17a2b8', default => '#ffc107' }; @endphp
                                <span class="badge-status" style="background:{{ $sColor }}; color:{{ $p->status === 'Menunggu' ? '#333' : '#fff' }};">{{ $p->status }}</span>
                            </td>
                            <td><small>{{ $p->catatan_pimpinan ?? '-' }}</small></td>
                        </tr>
                        @empty
                        <tr><td colspan="11" class="text-center text-muted py-5">Belum ada pengajuan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
