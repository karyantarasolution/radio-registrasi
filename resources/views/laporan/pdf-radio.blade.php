<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Laporan Registrasi Radio</title>
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
            <h3>LAPORAN REGISTRASI RADIO</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-ICT-15</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

<table class="bordered">
    <tr><th colspan="10" class="section-title">DAFTAR REGISTRASI SETTING CHANNEL FREKUENSI RADIO</th></tr>
    <tr>
        <th style="width:3%;">No</th>
        <th style="width:11%;">Perusahaan</th>
        <th style="width:9%;">No Lambung</th>
        <th style="width:10%;">Jenis Kendaraan</th>
        <th style="width:8%;">No Polisi</th>
        <th style="width:7%;">ID PTT</th>
        <th style="width:10%;">Merek Radio</th>
        <th style="width:11%;">Serial Number</th>
        <th style="width:7%;">Jenis</th>
        <th style="width:9%;">Tanggal</th>
    </tr>
    @forelse($registrasis as $r)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $r->perusahaan }}</td>
        <td>{{ $r->nomor_lambung }}</td>
        <td>{{ $r->jenis_kendaraan }}</td>
        <td>{{ $r->nomor_polisi }}</td>
        <td>{{ $r->id_ptt }}</td>
        <td>{{ $r->merek_radio }}</td>
        <td>{{ $r->serial_number }}</td>
        <td>{{ $r->jenis_radio }}</td>
        <td>{{ $r->tanggal_permintaan?->format('d/m/Y') ?? '-' }}</td>
    </tr>
    @empty
    <tr><td colspan="10">Belum ada data registrasi radio</td></tr>
    @endforelse
</table>

@include('laporan.partials.signature_pdf')

<div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
