<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Laporan Pengajuan</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:10px; }
    table { width:100%; border-collapse: collapse; }
    .bordered td, .bordered th { border:1px solid #000; padding:4px; text-align:center; }
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
            <h3>LAPORAN PENGAJUAN BARANG IT</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-ICT-12</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

<table class="bordered">
    <tr><th colspan="10" class="section-title">DAFTAR PENGAJUAN BARANG IT</th></tr>
    <tr>
        <th style="width:3%;">No</th>
        <th style="width:10%;">Nomor</th>
        <th style="width:12%;">Judul</th>
        <th style="width:9%;">Kategori</th>
        <th style="width:14%;">Nama Barang</th>
        <th style="width:7%;">Jumlah</th>
        <th style="width:11%;">Estimasi</th>
        <th style="width:10%;">Diajukan Oleh</th>
        <th style="width:9%;">Tanggal</th>
        <th style="width:8%;">Status</th>
    </tr>
    @forelse($pengajuans as $p)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $p->nomor_pengajuan }}</td>
        <td>{{ $p->judul }}</td>
        <td>{{ $p->kategori }}</td>
        <td>{{ $p->nama_barang }}</td>
        <td>{{ $p->jumlah_diminta }} {{ $p->satuan }}</td>
        <td>@if($p->estimasi_biaya)Rp {{ number_format($p->estimasi_biaya, 0, ',', '.') }}@else - @endif</td>
        <td>{{ $p->user->name ?? '-' }}</td>
        <td>{{ $p->tanggal_pengajuan?->format('d/m/Y') ?? '-' }}</td>
        <td>{{ $p->status }}</td>
    </tr>
    @empty
    <tr><td colspan="10">Belum ada pengajuan</td></tr>
    @endforelse
</table>

@include('laporan.partials.signature_pdf')

<div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
