@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    .card-custom {
        background:#fff;
        border-radius:16px;
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
        overflow:hidden;
        margin-bottom:20px;
    }
    .card-header-custom {
        background:linear-gradient(135deg,#ea6666 0%,#f71414 100%);
        color:#fff;
        padding:13px 20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:8px;
    }
    .card-body-custom { padding:20px; }
    .timeline { position:relative; padding-left:28px; }
    .timeline::before {
        content:''; position:absolute; left:8px; top:6px; bottom:6px;
        width:2px; background:#e9ecef;
    }
    .timeline-item { position:relative; padding-bottom:16px; }
    .timeline-item::before {
        content:''; position:absolute; left:-25px; top:4px;
        width:14px; height:14px; border-radius:50%;
        background:#667eea; border:2px solid #fff; box-shadow:0 0 0 2px #667eea;
    }
    .timeline-item.highlight::before { background:#f71414; box-shadow:0 0 0 2px #f71414; }
    .timeline-date { font-size:0.75rem; color:#6c757d; }
    .btn-modern { border:none; padding:8px 16px; border-radius:8px; font-size:0.85rem; font-weight:600; color:#fff; text-decoration:none; display:inline-block; }
    .btn-modern:hover { opacity:.9; color:#fff; }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('scan.search', ['q' => $gudang_barang->kode_qr]) }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Scan</a>
        </div>

        <div class="card-custom">
            <div class="card-header-custom">
                <div>
                    <h5 class="mb-0 fw-bold"><i class="fas fa-box-open me-2"></i>{{ $gudang_barang->nama_perangkat }}</h5>
                    <small>{{ $gudang_barang->kode_qr }} · {{ $gudang_barang->kategori }}</small>
                </div>
                <code style="color:#fff;">Stok: {{ $gudang_barang->stok_tersedia }}/{{ $gudang_barang->stok_total }}</code>
            </div>
            <div class="card-body-custom">
                <div class="row small">
                    <div class="col-4">Merk: <strong>{{ $gudang_barang->merk ?? '-' }}</strong></div>
                    <div class="col-4">Kondisi: <strong>{{ $gudang_barang->kondisi }}</strong></div>
                    <div class="col-4">Lokasi: <strong>{{ $gudang_barang->lokasi ?? '-' }}</strong></div>
                </div>
                @if(Auth::user()->isAdmin())
                <hr>
                <form method="POST" action="{{ route('gudang-barang.pindah-lokasi', $gudang_barang->id) }}" class="d-flex flex-wrap gap-2">
                    @csrf
                    <label class="fw-semibold align-self-center mb-0">Pindah Lokasi:</label>
                    <input type="text" name="lokasi" class="form-control form-control-sm w-auto" placeholder="Lokasi baru" value="{{ $gudang_barang->lokasi }}" required>
                    <input type="text" name="keterangan" class="form-control form-control-sm w-auto" placeholder="Keterangan (opsional)">
                    <button class="btn-modern" style="background:#667eea;"><i class="fas fa-exchange-alt"></i> Simpan</button>
                </form>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Riwayat Aset</h6>
                    </div>
                    <div class="card-body-custom">
                        @if($riwayat->count() > 0)
                        <div class="timeline">
                            @foreach($riwayat as $r)
                            <div class="timeline-item">
                                <div><span class="badge bg-secondary">{{ $r->jenis }}</span></div>
                                <div class="small">{{ $r->deskripsi }}</div>
                                <div class="timeline-date">{{ $r->tanggal?->format('d-m-Y H:i') }} · {{ $r->user->name ?? '-' }}</div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted mb-0">Belum ada riwayat.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-tools me-2"></i>Maintenance Perangkat</h6>
                    </div>
                    <div class="card-body-custom">
                        @if($maintenances->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead><tr><th>No.</th><th>Jenis Kerusakan</th><th>Status</th><th>Tgl Masuk</th></tr></thead>
                                <tbody>
                                    @foreach($maintenances as $m)
                                    <tr>
                                        <td><code>{{ $m->nomor_maintenance }}</code></td>
                                        <td><small>{{ Str::limit($m->jenis_kerusakan, 40) }}</small></td>
                                        <td>
                                            @php
                                                $c = match($m->status) { 'Selesai' => ['#28a745','#fff'], 'Diproses' => ['#007bff','#fff'], 'Menunggu' => ['#ffc107','#333'], default => ['#6c757d','#fff'] };
                                            @endphp
                                            <span class="badge" style="background:{{ $c[0] }};color:{{ $c[1] }};">{{ $m->status }}</span>
                                        </td>
                                        <td><small>{{ $m->tanggal_masuk->format('d/m/Y') }}</small></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted mb-0">Belum ada maintenance untuk perangkat ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection