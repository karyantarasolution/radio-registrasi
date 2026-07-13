<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Data Karyawan - {{ $karyawan->nama }}</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
    table { width:100%; border-collapse: collapse; }
    .bordered td, .bordered th { border:1px solid #000; padding:6px; }
    .section-title {
        background:#bfbfbf;
        font-weight:bold;
        text-align:left;
        padding:4px;
    }
    .qr-box {
        min-height:120px;
        text-align:center;
        padding:10px;
    }
    h3 { margin:0; padding:0; }
</style>
</head>
<body>

<table style="width:100%; margin-bottom:8px;">
    <tr>
        <td style="width:15%; text-align:center;">
            <img src="{{ public_path('images/LogoPPA.png') }}" style="max-width:80px;">
        </td>
        <td style="width:55%; text-align:center;">
            <h3>DATA KARYAWAN ICT</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-COE-XX</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

<table class="bordered" style="margin-bottom:10px;">
    <tr><th colspan="4" class="section-title">IDENTITAS KARYAWAN</th></tr>
    <tr>
        <td style="width:25%;">Nama</td>
        <td style="width:25%;">{{ $karyawan->nama }}</td>
        <td style="width:25%;">NRP</td>
        <td style="width:25%;">{{ $karyawan->nrp }}</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>{{ $karyawan->jabatan }}</td>
        <td>Departemen</td>
        <td>{{ $karyawan->departemen }}</td>
    </tr>
</table>

<table class="bordered" style="margin-bottom:10px;">
    <tr><th colspan="1" class="section-title">TANDA TANGAN DIGITAL (QR CODE)</th></tr>
    <tr>
        <td class="qr-box">
            @if($karyawan->qr_code)
                <img src="{{ public_path('storage/qr_codes/'.$karyawan->qr_code) }}"
                     style="width:100px;">
            @else
                <em>Belum ada QR Code</em>
            @endif
        </td>
    </tr>
</table>

<div style="margin-top:20px; font-size:11px;">
    <strong>Dicetak pada:</strong> {{ now()->format('d-M-Y H:i') }}
</div>

</body>
</html>
