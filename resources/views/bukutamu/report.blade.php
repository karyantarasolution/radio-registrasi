<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Laporan Buku Tamu</title>
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
            <h3>LAPORAN BUKU TAMU</h3>
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
    <tr><th colspan="9" class="section-title">DAFTAR KUNJUNGAN BUKU TAMU</th></tr>
    <tr>
        <th style="width:4%;">No</th>
        <th style="width:14%;">Nama</th>
        <th style="width:10%;">No Telepon</th>
        <th style="width:9%;">NRP</th>
        <th style="width:14%;">Instansi</th>
        <th style="width:16%;">Keperluan</th>
        <th style="width:13%;">PIC</th>
        <th style="width:12%;">Departemen</th>
        <th style="width:8%;">Tanggal</th>
    </tr>
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
        <td>{{ $tamu->created_at->format('d/m/Y') }}</td>
    </tr>
    @empty
    <tr><td colspan="9">Belum ada data buku tamu</td></tr>
    @endforelse
</table>

@include('laporan.partials.signature_pdf')

<div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
