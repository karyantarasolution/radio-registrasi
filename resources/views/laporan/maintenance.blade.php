@extends('layouts.app')

@section('content')
<style>
    .page-container { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; padding: 20px 0; }
    .page-header { background: linear-gradient(135deg, #ea6666 0%, #f71414 100%); color: white; padding: 25px 30px; border-radius: 20px; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
    .table-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .table-header { background: linear-gradient(135deg, #ea6666, #f71414); color: white; padding: 15px 25px; }
    .table-title { font-size: 1.1rem; font-weight: bold; margin: 0; }
    .table-custom { width:100%; border-collapse:collapse; }
    .table-custom thead { background:#f8f9fa; }
    .table-custom th { padding:10px; font-weight:600; text-align:center; border-bottom:2px solid #dee2e6; font-size:0.8rem; text-transform:uppercase; }
    .table-custom td { padding:8px 10px; text-align:center; border-top:1px solid #f1f1f1; font-size:0.85rem; }
    .table-custom tbody tr:hover { background:#f8f9fa; }
    .badge-kondisi { padding:4px 10px; border-radius:8px; font-size:0.75rem; font-weight:600; }
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
                <h2 class="fw-bold mb-1"><i class="fas fa-tools me-2"></i>Laporan Barang Maintenance</h2>
                <p class="mb-0">Detail barang yang perlu maintenance atau rusak</p>
            </div>
            <a href="{{ route('pimpinan.laporan') }}" class="btn btn-light btn-sm fw-bold"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
        </div>

        <div class="stat-row">
            <div class="stat-mini"><div class="num" style="color:#e67e22;">{{ $items->count() }}</div><div class="lbl">Total</div></div>
            <div class="stat-mini"><div class="num" style="color:#ffc107;">{{ $items->where('kondisi', 'Perlu Maintenance')->count() }}</div><div class="lbl">Perlu Maintenance</div></div>
            <div class="stat-mini"><div class="num" style="color:#dc3545;">{{ $items->where('kondisi', 'Rusak')->count() }}</div><div class="lbl">Rusak</div></div>
            <div class="stat-mini"><div class="num" style="color:#667eea;">{{ $items->sum('stok_tersedia') }}</div><div class="lbl">Stok di Maintenance</div></div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h4 class="table-title">Barang Maintenance ({{ $items->count() }} item)</h4>
            </div>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr><th>No</th><th>Nama Perangkat</th><th>Merek</th><th>Kategori</th><th>Stok Total</th><th>Stok Tersedia</th><th>Kondisi</th><th>Tgl Masuk</th><th>Keterangan</th></tr>
                    </thead>
                    <tbody>
                        @forelse($items as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $b->nama_perangkat }}</td>
                            <td>{{ $b->merk ?? '-' }}</td>
                            <td>{{ $b->kategori }}</td>
                            <td>{{ $b->stok_total }}</td>
                            <td>{{ $b->stok_tersedia }}</td>
                            <td>
                                @php $kColor = match($b->kondisi) { 'Perlu Maintenance' => '#ffc107', default => '#dc3545' }; @endphp
                                <span class="badge-kondisi" style="background:{{ $kColor }}; color:{{ $b->kondisi === 'Perlu Maintenance' ? '#333' : '#fff' }};">{{ $b->kondisi }}</span>
                            </td>
                            <td>{{ $b->tanggal_masuk->format('d-m-Y') }}</td>
                            <td><small>{{ $b->keterangan ?? '-' }}</small></td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center text-muted py-5">Tidak ada barang maintenance</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
