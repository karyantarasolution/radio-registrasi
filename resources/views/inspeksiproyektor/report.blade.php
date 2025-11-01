<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Inspeksi Proyektor - {{ $inspeksiproyektor->nomor_aset }}</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
    table { width:100%; border-collapse: collapse; }
    .bordered td, .bordered th { border:1px solid #000; padding:6px; }
    .section-title { background:#bfbfbf; font-weight:bold; padding:4px; }
    .sign-box { height:60px; border:1px solid #000; margin-bottom:4px; }
    h3 { margin:0; padding:0; }
</style>
</head>
<body>

<table style="width:100%; margin-bottom:8px;">
    <tr>
        <td style="width:15%; text-align:center;">
            <img src="{{ public_path('images/LogoPPA.png') }}" alt="logo" style="max-width:80px;">
        </td>
        <td style="width:55%; text-align:center;">
            <h3>FORM INSPEKSI PROYEKTOR</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-COE-28</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

<table class="bordered" style="margin-bottom:10px;">
    <tr><th colspan="4" class="section-title">IDENTITAS PERANGKAT</th></tr>
    <tr>
        <td>Nomor Asset Proyektor</td><td>{{ $inspeksiproyektor->nomor_aset }}</td>
        <td>Departemen</td><td>{{ $inspeksiproyektor->departemen }}</td>
    </tr>
    <tr>
        <td>Merek</td><td>{{ $inspeksiproyektor->merek }}</td>
        <td>Lokasi</td><td>{{ $inspeksiproyektor->lokasi }}</td>
    </tr>
    <tr>
        <td>Type</td><td>{{ $inspeksiproyektor->type }}</td>
        <td>Tanggal Inspeksi</td><td>{{ optional($inspeksiproyektor->tanggal_inspeksi)->format('d-M-Y') }}</td>
    </tr>
    <tr><td>S/N</td><td>{{ $inspeksiproyektor->sn }}</td><td></td><td></td></tr>
</table>

<table class="bordered" style="margin-bottom:10px;">
    <tr><th colspan="4" class="section-title">KONDISI PEMERIKSAAN</th></tr>
    <tr>
        <th style="width:45%;">Media yang diperiksa</th>
        <th style="width:10%;">Baik</th>
        <th style="width:10%;">Tidak</th>
        <th style="width:35%;">Tindakan Perbaikan</th>
    </tr>

    @php
      $checks = [
        ['key'=>'kondisi_casing','label'=>'Kondisi Casing Proyektor'],
        ['key'=>'kebersihan','label'=>'Kebersihan Proyektor'],
        ['key'=>'kabel_adaptor','label'=>'Kondisi Kabel Adaptor'],
        ['key'=>'lensa_proyektor','label'=>'Lensa Proyektor'],
        ['key'=>'indikator_lampu','label'=>'Indikator Lampu'],
        ['key'=>'fokus_zoom','label'=>'Fokus dan Zoom'],
        ['key'=>'kecerahan_kontras','label'=>'Kecerahan dan Kontras'],
        ['key'=>'koneksi_input_hdmi','label'=>'Koneksi Input (☐ HDMI, ☐ VGA, ☐ USB)'],
      
      ];
    @endphp

    @foreach($checks as $c)
    <tr>
        <td>{{ $c['label'] }}</td>
        <td style="text-align:center">{!! $inspeksiproyektor->{$c['key']} == 'Baik' ? '&#10003;' : '' !!}</td>
        <td style="text-align:center">{!! $inspeksiproyektor->{$c['key']} == 'Tidak' ? '&#10007;' : '' !!}</td>
        <td>{{ $inspeksiproyektor->{'tindakan_'.$c['key']} }}</td>
    </tr>
    @endforeach
</table>

<div style="margin-top:10px;">
    <strong>KETERANGAN:</strong>
    <div style="min-height:70px; border:1px solid #000; padding:6px;">{{ $inspeksiproyektor->keterangan }}</div>
</div>

<table style="width:100%; margin-top:20px;">
    <tr>
        <td style="width:50%; text-align:center;">
            <div class="sign-box"></div>
            <strong>Inspektor (ICT)</strong><br>
            Nama : {{ $inspeksiproyektor->inspektor }}<br>
            Jabatan : {{ $inspeksiproyektor->jabatan_inspektor }}
        </td>
        <td style="width:50%; text-align:center;">
            <div class="sign-box"></div>
            <strong>Diketahui Oleh</strong><br>
            Nama : {{ $inspeksiproyektor->diketahui_oleh }}<br>
            Jabatan : Group Leader
        </td>
    </tr>
</table>

</body>
</html>
