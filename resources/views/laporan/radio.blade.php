@extends('layouts.app')

@section('content')
<style>
    .page-container { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; padding: 20px 0; }
    .page-header { background: linear-gradient(135deg, #6f42c1, #e83e8c); color: white; padding: 25px 30px; border-radius: 20px; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
    .table-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .table-header { background: linear-gradient(135deg, #6f42c1, #e83e8c); color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
    .table-title { font-size: 1.1rem; font-weight: bold; margin: 0; }
    .table-custom { width:100%; border-collapse:collapse; }
    .table-custom thead { background:#f8f9fa; }
    .table-custom th { padding:10px; font-weight:600; text-align:center; border-bottom:2px solid #dee2e6; font-size:0.78rem; text-transform:uppercase; }
    .table-custom td { padding:8px 10px; text-align:center; border-top:1px solid #f1f1f1; font-size:0.85rem; }
    .table-custom tbody tr:hover { background:#f8f9fa; }
    .stat-row { display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap; }
    .stat-mini { background:#fff; border-radius:12px; padding:12px 16px; box-shadow:0 4px 10px rgba(0,0,0,0.05); flex:1; min-width:120px; text-align:center; }
    .stat-mini .num { font-size:1.4rem; font-weight:700; }
    .stat-mini .lbl { font-size:0.78rem; color:#6c757d; }
    .btn-back { background: linear-gradient(45deg, #7f8c8d, #95a5a6); color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; }
    .btn-back:hover { opacity: .9; color: #fff; }
    .badge-radio { padding:4px 10px; border-radius:8px; font-size:0.72rem; font-weight:600; }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="fw-bold mb-1"><i class="fas fa-broadcast-tower me-2"></i>Laporan Registrasi Radio</h2>
                <p class="mb-0">Daftar registrasi setting channel frekuensi radio komunikasi</p>
            </div>
            <a href="{{ route('pimpinan.laporan') }}" class="btn btn-light btn-sm fw-bold"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
        </div>

        <div class="stat-row">
            <div class="stat-mini"><div class="num" style="color:#6f42c1;">{{ $registrasis->count() }}</div><div class="lbl">Total Registrasi</div></div>
            <div class="stat-mini"><div class="num" style="color:#e83e8c;">{{ $registrasis->unique('perusahaan')->count() }}</div><div class="lbl">Total Perusahaan</div></div>
            <div class="stat-mini"><div class="num" style="color:#28a745;">{{ $registrasis->where('jenis_radio', 'Mobile')->count() }}</div><div class="lbl">Mobile</div></div>
            <div class="stat-mini"><div class="num" style="color:#ffc107;">{{ $registrasis->where('jenis_radio', 'HT')->count() }}</div><div class="lbl">HT</div></div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h4 class="table-title">Data Registrasi Radio ({{ $registrasis->count() }} data)</h4>
            </div>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr><th>No</th><th>Perusahaan</th><th>Nomor Lambung</th><th>Jenis Kendaraan</th><th>No Polisi</th><th>ID PTT</th><th>Merek Radio</th><th>Serial Number</th><th>Jenis Radio</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        @forelse($registrasis as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $r->perusahaan }}</td>
                            <td><code>{{ $r->nomor_lambung }}</code></td>
                            <td>{{ $r->jenis_kendaraan }}</td>
                            <td>{{ $r->nomor_polisi }}</td>
                            <td><code>{{ $r->id_ptt }}</code></td>
                            <td>{{ $r->merek_radio }}</td>
                            <td><small>{{ $r->serial_number }}</small></td>
                            <td><span class="badge-radio" style="background:{{ $r->jenis_radio === 'Mobile' ? '#6f42c1' : '#e83e8c' }}; color:#fff;">{{ $r->jenis_radio }}</span></td>
                            <td><small>{{ $r->tanggal_permintaan?->format('d/m/Y') ?? '-' }}</small></td>
                        </tr>
                        @empty
                        <tr><td colspan="10" class="text-center text-muted py-5">Belum ada data registrasi radio</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
