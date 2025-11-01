<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Inspeksi UPS - {{ $inspeksiup->nomor_aset }}</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
    table { width:100%; border-collapse: collapse; }
    .bordered td, .bordered th { border:1px solid #000; padding:6px; }
    .header-table td { vertical-align:top; }
    .section-title {
        background:#bfbfbf;
        font-weight:bold;
        text-align:left;
        padding:4px;
    }
    .sign-box {
        height:60px;
        border:1px solid #000;
        margin-bottom:4px;
    }
    h3 {
        margin:0;
        padding:0;
    }
</style>
</head>
<body>

{{-- HEADER --}}
<table style="width:100%; margin-bottom:8px;">
    <tr>
        <td style="width:15%; text-align:center;">
            <img src="{{ public_path('images/LogoPPA.png') }}" alt="logo" style="max-width:80px;">
        </td>
        <td style="width:55%; text-align:center;">
            <h3>INSPEKSI BATERAI UPS</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-COE-49</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

{{-- IDENTITAS PERANGKAT --}}
<table class="bordered" style="margin-bottom:10px;">
    <tr><th colspan="4" class="section-title">IDENTITAS PERANGKAT</th></tr>
    <tr>
        <td>Nomor Aset UPS</td><td>{{ $inspeksiup->nomor_aset }}</td>
        <td>Departemen</td><td>{{ $inspeksiup->departemen }}</td>
    </tr>
    <tr>
        <td>Merek</td><td>{{ $inspeksiup->merek }}</td>
        <td>Lokasi</td><td>{{ $inspeksiup->lokasi }}</td>
    </tr>
    <tr>
        <td>Type</td><td>{{ $inspeksiup->type }}</td>
        <td>Tanggal Inspeksi</td><td>{{ optional($inspeksiup->tanggal_inspeksi)->format('d-M-Y') }}</td>
    </tr>
    <tr>
        <td>S/N</td><td> {{ $inspeksiup->sn }}</td>
         <td></td><td></td>
    </tr>
</table>

{{-- KONDISI PEMERIKSAAN --}}
<table class="bordered" style="margin-bottom:10px;">
    <tr><th colspan="4" class="section-title">KONDISI PEMERIKSAAN</th></tr>
    <tr>
        <th style="width:45%;">Media Yang diperiksa</th>
        <th style="width:10%;">Baik</th>
        <th style="width:10%;">Tidak</th>
        <th style="width:35%;">Tindakan Perbaikan</th>
    </tr>

    @php
        $checks = [
            ['label'=>'Kondisi Casing UPS','key'=>'casing'],
            ['label'=>'Kebersihan UPS','key'=>'kebersihan'],
            ['label'=>'Kondisi kabel adaptor','key'=>'kabel_adaptor'],
            ['label'=>'Kondisi tombol dan switch','key'=>'tombol_switch'],
            ['label'=>'Indikator status (power, battery, load)','key'=>'indikator_status'],
            ['label'=>'Fungsi alarm','key'=>'fungsi_alarm'],
            ['label'=>'Respon terhadap kehilangan daya','key'=>'respon_kehilangan_daya'],
            ['label'=>'Fuse (sekering)','key'=>'fuse'],
        ];
    @endphp

    @foreach($checks as $c)
    <tr>
        <td>{{ $c['label'] }}</td>
        <td style="text-align:center;">{!! $inspeksiup->{$c['key']} == 'Baik' ? '&#10003;' : '' !!}</td>
        <td style="text-align:center;">{!! $inspeksiup->{$c['key']} == 'Tidak' ? '&#10007;' : '' !!}</td>
        <td>{{ $inspeksiup->{'tindakan_'.$c['key']} }}</td>
    </tr>
    @endforeach
</table>

<div style="margin-top:10px;">
    <strong>KETERANGAN:</strong>
    <div style="min-height:70px; border:1px solid #000; padding:6px;">{{ $inspeksiup->keterangan }}</div>
</div>

{{-- TANDA TANGAN --}}
<table style="width:100%; margin-top:20px; text-align:center;">
    <tr>
        <td style="width:50%;">
            <div class="sign-box"></div>
            <strong>Inspektor (ICT)</strong><br>
            Nama : {{ $inspeksiup->inspektor }}<br>
            Jabatan : {{ $inspeksiup->jabatan_inspektor }}
        </td>
        <td style="width:50%;">
            <div class="sign-box"></div>
            <strong>Diketahui Oleh</strong><br>
            Nama : {{ $inspeksiup->diketahui_oleh }}<br>
            Jabatan : Group Leader ICT
        </td>
    </tr>
</table>

</body>
</html>
        