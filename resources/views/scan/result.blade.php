@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    .result-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .result-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 12px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .result-body { padding: 20px; }
    .badge-status { padding:4px 10px; border-radius:100px; font-size:0.75rem; font-weight:700; }
    .border-dashed { border: 1px dashed #ddd; border-radius: 12px; padding: 14px; }
    .label-qr {
        display: inline-block;
        border: 1px solid #666;
        border-radius: 6px;
        padding: 8px 12px;
        text-align: center;
        background:#fff;
    }
    .label-qr .code { font-family: Consolas, monospace; font-weight: 700; font-size: 0.9rem; letter-spacing: .5px; }
    .label-qr .name { font-size: 0.68rem; color: #555; }
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="{{ route('scan.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left"></i> Scan Lagi</a>
            </div>
            <form method="GET" action="{{ route('scan.search') }}" class="d-flex gap-2">
                <input type="text" name="q" class="form-control form-control-sm" value="{{ $q }}" placeholder="Cari aset lain..." style="width:260px;">
                <button class="btn btn-modern" style="background:linear-gradient(135deg,#ea6666,#f71414);"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <h5 class="text-white fw-bold mb-0" style="text-shadow:0 1px 3px rgba(0,0,0,0.3);">Hasil pencarian: <em>"{{ $q }}"</em></h5>

        @if($hasQuery && $gudang->isEmpty() && $radio->isEmpty())
        <div class="alert alert-warning mt-3">Tidak ditemukan aset dengan kata kunci tersebut.</div>
        @endif

        @if($gudang->count() > 0)
        <h6 class="text-white fw-bold mt-4 mb-2" style="text-shadow:0 1px 3px rgba(0,0,0,0.3);">
            <i class="fas fa-warehouse me-1"></i> Perangkat Gudang IT ({{ $gudang->count() }})
        </h6>
        <div class="row g-3">
            @foreach($gudang as $item)
            @php
                $st = $statusGudang[$item->id] ?? ['dipinjam'=>0, 'maintenance'=>0, 'tersedia'=>0];
            @endphp
            <div class="col-md-6">
                <div class="result-card">
                    <div class="result-header">
                        <h6 class="mb-0 fw-bold">{{ $item->nama_perangkat }}</h6>
                        <code style="color:#fff;">{{ $item->kode_qr }}</code>
                    </div>
                    <div class="result-body">
                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <span class="badge-status" style="background:#28a745;color:#fff;">Tersedia {{ $st['tersedia'] }}</span>
                            <span class="badge-status" style="background:#ffc107;color:#333;">Dipinjam {{ $st['dipinjam'] }}</span>
                            <span class="badge-status" style="background:#007bff;color:#fff;">Maintenance {{ $st['maintenance'] }}</span>
                        </div>
                        <div class="row small">
                            <div class="col-6">Merk: <strong>{{ $item->merk ?? '-' }}</strong></div>
                            <div class="col-6">Kategori: <strong>{{ $item->kategori }}</strong></div>
                            <div class="col-6">Stok Total: <strong>{{ $item->stok_total }}</strong></div>
                            <div class="col-6">Kondisi: <strong>{{ $item->kondisi }}</strong></div>
                            <div class="col-12">Lokasi: <strong>{{ $item->lokasi ?? '-' }}</strong></div>
                        </div>
                        <div class="mt-3 d-flex gap-2 flex-wrap">
                            <a href="{{ route('gudang-barang.history', $item->id) }}" class="btn-modern" style="background:#667eea;"><i class="fas fa-history"></i> Riwayat</a>
                            <a href="{{ route('maintenance.index', ['gudang_barang_id' => $item->id]) }}" class="btn-modern" style="background:#007bff;"><i class="fas fa-tools"></i> Maintenance</a>
                            <button class="btn-modern" style="background:#28a745;" data-target="printable-{{ $loop->index }}"><i class="fas fa-tag"></i> Cetak Label</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($radio->count() > 0)
        <h6 class="text-white fw-bold mt-4 mb-2" style="text-shadow:0 1px 3px rgba(0,0,0,0.3);">
            <i class="fas fa-broadcast-tower me-1"></i> Radio / Kendaraan ({{ $radio->count() }})
        </h6>
        <div class="row g-3">
            @foreach($radio as $item)
            <div class="col-md-6">
                <div class="result-card">
                    <div class="result-header">
                        <h6 class="mb-0 fw-bold">{{ $item->perusahaan }}</h6>
                        <code style="color:#fff;">{{ $item->kode_qr }}</code>
                    </div>
                    <div class="result-body">
                        <div class="row small">
                            <div class="col-6">ID PTT: <strong>{{ $item->id_ptt }}</strong></div>
                            <div class="col-6">No. Lambung: <strong>{{ $item->nomor_lambung }}</strong></div>
                            <div class="col-6">Merek Radio: <strong>{{ $item->merek_radio }}</strong></div>
                            <div class="col-6">Serial: <code>{{ $item->serial_number }}</code></div>
                            <div class="col-6">Jenis: <strong>{{ $item->jenis_radio ?? '-' }}</strong></div>
                            <div class="col-6">Lokasi: <strong>{{ $item->lokasi ?? '-' }}</strong></div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('registrasi.report', $item->id) }}" target="_blank" class="btn-modern" style="background:#667eea;"><i class="fas fa-file-alt"></i> Detail / Cetak</a>
                            <button class="btn-modern" style="background:#28a745;" data-target="printable-r{{ $loop->index }}">
                                <i class="fas fa-tag"></i> Cetak Label QR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @foreach($gudang as $item)
            @php $labelQr = $item->kode_qr; $labelName = $item->nama_perangkat; @endphp
            <div id="printable-{{ $loop->index }}" style="display:none;text-align:center;">
                <div class="label-qr" style="padding:14px 22px;font-size:16px;">
                    <div style="font-size:13px;font-weight:700;color:#222;">{{ $labelName }}</div>
                    <div class="code" style="font-size:18px;">{{ $labelQr }}</div>
                </div>
            </div>
        @endforeach
        @foreach($radio as $item)
            <div id="printable-r{{ $loop->index }}" style="display:none;text-align:center;">
                <div class="label-qr" style="padding:14px 22px;font-size:16px;">
                    <div style="font-size:13px;font-weight:700;color:#222;">{{ $item->perusahaan }} / {{ $item->nomor_lambung }}</div>
                    <div class="code" style="font-size:18px;">{{ $item->kode_qr }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function printLabelBtn(id) {
        const win = window.open('', '_blank', 'width=400,height=300');
        if (!win) return alert('Blokir popup! Izinkan popup untuk mencetak label.');
        const content = document.getElementById(id).innerHTML;
        win.document.write('<html><head><title>Label QR</title></head><body style="display:flex;align-items:center;justify-content:center;height:100vh;margin:0;font-family:Arial,Helvetica,sans-serif;">' + content + '</body></html>');
        win.document.close();
        win.focus();
        win.print();
    }
    document.querySelectorAll('[data-target]').forEach(function(btn){
        btn.addEventListener('click', function(){ printLabelBtn(this.dataset.target); });
    });
</script>
@endsection