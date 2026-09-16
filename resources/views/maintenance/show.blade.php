@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    .card-custom {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .card-header-custom {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .card-body-custom { padding: 20px; }
    .badge-status { padding:6px 14px; border-radius:10px; font-size:0.85rem; font-weight:700; }
    .info-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px dashed #eee; font-size:0.9rem; }
    .info-row:last-child { border-bottom:none; }
    .info-label { color:#6c757d; font-weight:600; }
    .timeline { position:relative; padding-left:28px; }
    .timeline::before {
        content:''; position:absolute; left:8px; top:6px; bottom:6px;
        width:2px; background:#e9ecef;
    }
    .timeline-item { position:relative; padding-bottom:18px; }
    .timeline-item::before {
        content:''; position:absolute; left:-25px; top:4px;
        width:14px; height:14px; border-radius:50%;
        background:#667eea; border:2px solid #fff; box-shadow:0 0 0 2px #667eea;
    }
    .timeline-item.state-milestone::before { background:#28a745; box-shadow:0 0 0 2px #28a745; }
    .timeline-date { font-size:0.75rem; color:#6c757d; }
    .btn-modern {
        border:none;
        padding:8px 16px;
        border-radius:8px;
        font-size:0.85rem;
        font-weight:600;
        transition:all .2s;
        color:#fff;
        text-decoration:none;
        display:inline-block;
    }
    .btn-modern:hover { opacity:.9; color:#fff; }
</style>

<div class="page-container">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @php
            $color = match($maintenance->status) {
                'Menunggu' => ['#ffc107', '#333'],
                'Diproses' => ['#007bff', '#fff'],
                'Selesai' => ['#28a745', '#fff'],
                default => ['#6c757d', '#fff'],
            };
        @endphp

        <div class="card-custom">
            <div class="card-header-custom">
                <div>
                    <h5 class="mb-0 fw-bold"><i class="fas fa-tools me-2"></i>{{ $maintenance->nomor_maintenance }}</h5>
                </div>
                <div>
                    <span class="badge-status" style="background:{{ $color[0] }}; color:{{ $color[1] }};">{{ $maintenance->status }}</span>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-row"><span class="info-label">Perangkat</span><span>{{ $maintenance->gudangBarang->nama_perangkat ?? '-' }} <small class="text-muted">({{ $maintenance->gudangBarang->kode_qr ?? '-' }})</small></span></div>
                        <div class="info-row"><span class="info-label">Kode QR</span><code>{{ $maintenance->gudangBarang->kode_qr ?? '-' }}</code></div>
                        <div class="info-row"><span class="info-label">Jenis Kerusakan</span><span>{{ $maintenance->jenis_kerusakan }}</span></div>
                        <div class="info-row"><span class="info-label">Deskripsi</span><span>{{ $maintenance->deskripsi_kerusakan ?? '-' }}</span></div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row"><span class="info-label">Petugas</span><span>{{ $maintenance->petugas ?? '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Tanggal Masuk</span><span>{{ $maintenance->tanggal_masuk->format('d-m-Y') }}</span></div>
                        <div class="info-row"><span class="info-label">Tanggal Selesai</span><span>{{ $maintenance->tanggal_selesai?->format('d-m-Y') ?? '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Tindakan Perbaikan</span><span>{{ $maintenance->tindakan_perbaikan ?? '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Biaya</span><span>{{ $maintenance->biaya ? 'Rp ' . number_format($maintenance->biaya, 0, ',', '.') : '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Diajukan Oleh</span><span>{{ $maintenance->createdBy->name ?? '-' }}</span></div>
                    </div>
                </div>

                @if(Auth::user()->isAdmin() && in_array($maintenance->status, ['Menunggu', 'Diproses']))
                <hr>
                <div class="d-flex flex-wrap gap-2">
                    @if($maintenance->status === 'Menunggu')
                    <form method="POST" action="{{ route('maintenance.proses', $maintenance->id) }}">
                        @csrf
                        <input type="text" name="petugas" class="form-control form-control-sm d-inline-block w-auto" placeholder="Petugas / teknisi">
                        <button class="btn-modern" style="background:#007bff;"><i class="fas fa-play"></i> Mulai Proses</button>
                    </form>
                    @endif
                    @if(in_array($maintenance->status, ['Menunggu', 'Diproses']))
                    <form method="POST" action="{{ route('maintenance.selesai', $maintenance->id) }}" class="d-inline-flex align-items-center gap-2 flex-wrap">
                        @csrf
                        <input type="text" name="tindakan_perbaikan" class="form-control form-control-sm w-auto" placeholder="Tindakan perbaikan">
                        <input type="number" name="biaya" class="form-control form-control-sm w-auto" placeholder="Biaya (Rp)" min="0">
                        <button class="btn-modern" style="background:#28a745;"><i class="fas fa-check"></i> Selesai</button>
                    </form>
                    <form method="POST" action="{{ route('maintenance.batalkan', $maintenance->id) }}" class="d-inline">
                        @csrf
                        <input type="text" name="catatan" class="form-control form-control-sm d-inline-block w-auto" placeholder="Alasan batal">
                        <button class="btn-modern" style="background:#dc3545;" onclick="return confirm('Batalkan maintenance ini? Stok akan dikembalikan.')"><i class="fas fa-times"></i> Batalkan</button>
                    </form>
                    <a href="{{ route('maintenance.edit', $maintenance->id) }}" class="btn-modern" style="background:#6c757d;"><i class="fas fa-edit"></i> Edit</a>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Riwayat Status Maintenance</h6>
                    </div>
                    <div class="card-body-custom">
                        @if($maintenance->histories->count() > 0)
                        <div class="timeline">
                            @foreach($maintenance->histories->sortByDesc('created_at') as $h)
                            <div class="timeline-item">
                                <div><strong>{{ $h->status_dari ? $h->status_dari . ' → ' : '' }}{{ $h->status_ke }}</strong></div>
                                <div class="small">{{ $h->keterangan }}</div>
                                <div class="timeline-date">{{ $h->created_at->format('d-m-Y H:i') }} · {{ $h->user->name ?? 'Sistem' }}</div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted mb-0">Belum ada riwayat status.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-box-open me-2"></i>Riwayat Perangkat</h6>
                    </div>
                    <div class="card-body-custom">
                        @if($riwayatPerangkat->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr><th>Tanggal</th><th>Jenis</th><th>Keterangan</th><th>Oleh</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatPerangkat as $r)
                                    <tr>
                                        <td><small>{{ $r->tanggal?->format('d/m/Y H:i') }}</small></td>
                                        <td><span class="badge bg-secondary">{{ $r->jenis }}</span></td>
                                        <td><small>{{ Str::limit($r->deskripsi, 80) }}</small></td>
                                        <td><small>{{ $r->user->name ?? '-' }}</small></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted mb-0">Belum ada riwayat perangkat ini.</p>
                        @endif

                        @if(Auth::user()->isAdmin())
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            <form method="POST" action="{{ route('maintenance.destroy', $maintenance->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn-modern" style="background:#dc3545;" onclick="return confirm('Hapus data maintenance ini?')"><i class="fas fa-trash"></i> Hapus Data</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection