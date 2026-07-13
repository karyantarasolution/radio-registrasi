<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Inspeksi Proyektor - {{ $inspeksiproyektor->nomor_aset }}</title>

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .bordered td,
    .bordered th {
        border: 1px solid #000;
        padding: 6px;
    }

    /* ===== PAKSA RATA KIRI (ANTI DOMPDF BANDel) ===== */
    .text-left td {
        text-align: left !important;
        vertical-align: top;
    }

    .text-left th {
        text-align: left !important;
        vertical-align: middle;
    }

    .section-title {
        background: #bfbfbf;
        font-weight: bold;
        padding: 4px;
        text-align: left !important;
    }

    .sign-box {
        height: 60px;
        border: 1px solid #000;
        margin-bottom: 4px;
    }

    h3 {
        margin: 0;
        padding: 0;
    }
</style>
</head>

<body>

<!-- ===== HEADER ===== -->
<table style="margin-bottom:8px;">
    <tr>
        <td style="width:15%; text-align:center;">
            <img src="{{ public_path('images/LogoPPA.png') }}" style="max-width:80px;">
        </td>
        <td style="width:55%; text-align:center;">
            <h3>FORM INSPEKSI PROYEKTOR</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table>
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-COE-28</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

<!-- ===== IDENTITAS PERANGKAT ===== -->
<table class="bordered text-left" style="margin-bottom:10px;">
    <tr>
        <th colspan="4" class="section-title">IDENTITAS PERANGKAT</th>
    </tr>
    <tr>
        <td>Nomor Asset Proyektor</td>
        <td>{{ $inspeksiproyektor->nomor_aset }}</td>
        <td>Departemen</td>
        <td>{{ $inspeksiproyektor->departemen }}</td>
    </tr>
    <tr>
        <td>Merek</td>
        <td>{{ $inspeksiproyektor->merek }}</td>
        <td>Lokasi</td>
        <td>{{ $inspeksiproyektor->lokasi }}</td>
    </tr>
    <tr>
        <td>Type</td>
        <td>{{ $inspeksiproyektor->type }}</td>
        <td>Tanggal Inspeksi</td>
        <td>{{ optional($inspeksiproyektor->tanggal_inspeksi)->format('d-M-Y') }}</td>
    </tr>
    <tr>
        <td>S/N</td>
        <td>{{ $inspeksiproyektor->sn }}</td>
        <td></td>
        <td></td>
    </tr>
</table>

<!-- ===== KONDISI PEMERIKSAAN ===== -->
<table class="bordered text-left" style="margin-bottom:10px;">
    <tr>
        <th colspan="4" class="section-title">KONDISI PEMERIKSAAN</th>
    </tr>
    <tr>
        <th style="width:45%; text-align:left;">Media yang diperiksa</th>
        <th style="width:10%; text-align:center;">Baik</th>
        <th style="width:10%; text-align:center;">Tidak</th>
        <th style="width:35%; text-align:left;">Tindakan Perbaikan</th>
    </tr>

@php
use App\Models\Karyawan;

$checks = [
    ['key'=>'kondisi_casing','label'=>'Kondisi casing proyektor'],
    ['key'=>'kebersihan','label'=>'Kebersihan proyektor'],
    ['key'=>'kabel_adaptor','label'=>'Kondisi kabel adaptor'],
    ['key'=>'lensa_proyektor','label'=>'Lensa proyektor'],
    ['key'=>'indikator_lampu','label'=>'Indikator lampu'],
    ['key'=>'fokus_zoom','label'=>'Fokus dan zoom'],
    ['key'=>'kecerahan_kontras','label'=>'Kecerahan dan kontras'],
    ['key'=>'koneksi_input_hdmi','label'=>'Koneksi input (HDMI / VGA / USB)'],
];

$inspektorData = Karyawan::where('nama', $inspeksiproyektor->inspektor)->first();
$diketahuiData = Karyawan::where('nama', $inspeksiproyektor->diketahui_oleh)->first();
@endphp

@foreach($checks as $c)
<tr>
    <td>{{ $c['label'] }}</td>
    <td style="text-align:center;">
        {!! $inspeksiproyektor->{$c['key']} == 'Baik' ? '&#10003;' : '' !!}
    </td>
    <td style="text-align:center;">
        {!! $inspeksiproyektor->{$c['key']} == 'Tidak' ? '&#10007;' : '' !!}
    </td>
    <td>{{ $inspeksiproyektor->{'tindakan_'.$c['key']} }}</td>
</tr>
@endforeach
</table>

<!-- ===== KETERANGAN ===== -->
<div style="margin-top:10px;">
    <strong>KETERANGAN:</strong>
    <div style="min-height:70px; border:1px solid #000; padding:6px;">
        {{ $inspeksiproyektor->keterangan }}
    </div>
</div>

<!-- ===== TANDA TANGAN ===== -->
<table style="margin-top:20px;">
    <tr>
        <td style="width:50%; text-align:center;">
            <strong>Inspektor (ICT)</strong><br><br>
            <div class="sign-box" style="border:none;">
                @if($inspektorData && $inspektorData->qr_code)
                    <img src="{{ public_path('storage/qr_codes/'.$inspektorData->qr_code) }}" width="70">
                @else
                    <div style="height:40px;"></div>
                @endif
            </div>
            <br>
            Nama : {{ $inspeksiproyektor->inspektor }}<br>
            Jabatan : {{ $inspeksiproyektor->jabatan_inspektor }}
        </td>

        <td style="width:50%; text-align:center;">
            <strong>Diketahui Oleh</strong><br>
            <div class="sign-box" style="border:none;">
                @if($diketahuiData && $diketahuiData->qr_code)
                    <img src="{{ public_path('storage/qr_codes/'.$diketahuiData->qr_code) }}" width="80">
                @else
                    <div style="height:40px;"></div>
                @endif
            </div>
            <br><br>
            Nama : {{ $inspeksiproyektor->diketahui_oleh }}<br>
            Jabatan : {{ $inspeksiproyektor->karyawans }} Group Leader
        </td>
    </tr>
</table>

</body>
</html>
