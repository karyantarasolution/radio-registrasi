<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Laporan Inspeksi Stavolt</title>
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
            <h3>LAPORAN INSPEKSI STAVOLT</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-ICT-17</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

<table class="bordered">
    <tr><th colspan="10" class="section-title">DAFTAR INSPEKSI PERANGKAT STAVOLT</th></tr>
    <tr>
        <th style="width:3%;">No</th>
        <th style="width:10%;">Nomor Aset</th>
        <th style="width:9%;">Merek</th>
        <th style="width:8%;">Type</th>
        <th style="width:10%;">SN</th>
        <th style="width:10%;">Departemen</th>
        <th style="width:11%;">Lokasi</th>
        <th style="width:10%;">Tanggal</th>
        <th style="width:11%;">Inspektor</th>
        <th style="width:18%;">Keterangan</th>
    </tr>
    @forelse($data as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->nomor_aset }}</td>
        <td>{{ $row->merek }}</td>
        <td>{{ $row->type }}</td>
        <td>{{ $row->sn }}</td>
        <td>{{ $row->departemen }}</td>
        <td>{{ $row->lokasi }}</td>
        <td>{{ optional($row->tanggal_inspeksi)->format('d/m/Y') }}</td>
        <td>{{ $row->inspektor }}</td>
        <td>{{ $row->keterangan }}</td>
    </tr>
    @empty
    <tr><td colspan="10">Belum ada data inspeksi Stavolt</td></tr>
    @endforelse
</table>

@include('laporan.partials.signature_pdf')

<div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
