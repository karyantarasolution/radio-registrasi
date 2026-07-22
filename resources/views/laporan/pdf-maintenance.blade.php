<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Laporan Barang Maintenance</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:11px; }
    table { width:100%; border-collapse: collapse; }
    .bordered td, .bordered th { border:1px solid #000; padding:5px; text-align:center; }
    .section-title { background:#bfbfbf; font-weight:bold; padding:4px; text-align:left; }
    h3 { margin:0; padding:0; }
    .footer { margin-top:10px; font-size:10px; color:#999; text-align:center; }
</style>
</head>
<body>

<table style="width:100%; margin-bottom:8px;">
    <tr>
        <td style="width:15%; text-align:center;">
            <img src="{{ public_path('images/LogoPPA.png') }}" alt="logo" style="max-width:80px;">
        </td>
        <td style="width:55%; text-align:center;">
            <h3>LAPORAN BARANG MAINTENANCE</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-ICT-13</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

<table class="bordered">
    <tr><th colspan="8" class="section-title">DAFTAR BARANG DALAM MAINTENANCE</th></tr>
    <tr>
        <th style="width:4%;">No</th>
        <th style="width:22%;">Nama Perangkat</th>
        <th style="width:12%;">Merek</th>
        <th style="width:12%;">Kategori</th>
        <th style="width:10%;">Stok Total</th>
        <th style="width:10%;">Stok Tersedia</th>
        <th style="width:12%;">Unit di Maintenance</th>
        <th style="width:18%;">Keterangan</th>
    </tr>
    @forelse($items as $item)
    @php $unitMaintenance = $item->stok_total - $item->stok_tersedia; @endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_perangkat }}</td>
        <td>{{ $item->merk ?? '-' }}</td>
        <td>{{ $item->kategori }}</td>
        <td>{{ $item->stok_total }}</td>
        <td>{{ $item->stok_tersedia }}</td>
        <td>{{ $unitMaintenance }} unit</td>
        <td>{{ $item->keterangan ?? '-' }}</td>
    </tr>
    @empty
    <tr><td colspan="8">Tidak ada barang dalam maintenance</td></tr>
    @endforelse
</table>

@if($items->isNotEmpty())
@php $totalUnit = $items->sum(function($i){ return $i->stok_total - $i->stok_tersedia; }); @endphp
<div style="margin-top:10px;">
    <strong>KETERANGAN:</strong>
    <div style="min-height:50px; border:1px solid #000; padding:6px;">
        Laporan barang yang sedang dalam proses maintenance (disetujui pimpinan).
        Total: {{ $items->count() }} jenis barang, {{ $totalUnit }} unit sedang di-maintenance.
    </div>
</div>
@endif

@include('laporan.partials.signature_pdf')

<div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
