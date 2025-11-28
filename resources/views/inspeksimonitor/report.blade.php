<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Inspeksi Monitor - {{ $inspeksimonitor->nomor_aset }}</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
    table { width:100%; border-collapse: collapse; }
    .bordered td, .bordered th { border:1px solid #000; padding:6px; }
    .section-title { background:#bfbfbf; font-weight:bold; padding:4px; text-align:left;}
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
            <h3>FORM INSPEKSI MONITOR / TV</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-COE-27</td></tr>
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
        <td>Nomor Asset Monitor/TV</td><td>{{ $inspeksimonitor->nomor_aset }}</td>
        <td>Departemen</td><td>{{ $inspeksimonitor->departemen }}</td>
    </tr>
    <tr>
        <td>Merek</td><td>{{ $inspeksimonitor->merek }}</td>
        <td>Lokasi</td><td>{{ $inspeksimonitor->lokasi }}</td>
    </tr>
    <tr>
        <td>Type</td><td>{{ $inspeksimonitor->type }}</td>
        <td>Tanggal Inspeksi</td><td>{{ optional($inspeksimonitor->tanggal_inspeksi)->format('d-M-Y') }}</td>
    </tr>
    <tr><td>S/N</td><td>{{ $inspeksimonitor->sn }}</td><td></td><td></td></tr>
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
    use App\Models\Karyawan;

    $checks = [
        ['key'=>'tampilan_layer','label'=>'Tampilan layer monitor'],
        ['key'=>'kabel_power','label'=>'Kondisi Kabel power'],
        ['key'=>'bracket_dudukan','label'=>'Kondisi bracket dudukan'],
        ['key'=>'kebersihan','label'=>'Kebersihan monitor'],
        ['key'=>'stop_kontak','label'=>'Kondisi stop kontak'],
    ];

    // Ambil data karyawan untuk inspektor dan diketahui
    $inspektorData = Karyawan::where('nama', $inspeksimonitor->inspektor)->first();
    $diketahuiData = Karyawan::where('nama', $inspeksimonitor->diketahui_oleh)->first();
    @endphp

    @foreach($checks as $c)
    <tr>
        <td>{{ $c['label'] }}</td>
        <td style="text-align:center">{!! $inspeksimonitor->{$c['key']} == 'Baik' ? '&#10003;' : '' !!}</td>
        <td style="text-align:center">{!! $inspeksimonitor->{$c['key']} == 'Tidak' ? '&#10007;' : '' !!}</td>
        <td>{{ $inspeksimonitor->{'tindakan_'.$c['key']} }}</td>
    </tr>
    @endforeach
</table>

<div style="margin-top:10px;">
    <strong>KETERANGAN:</strong>
    <div style="min-height:70px; border:1px solid #000; padding:6px;">{{ $inspeksimonitor->keterangan }}</div>
</div>

    <table style="width:100%; margin-top:20px;">
        <tr>
            <td style="width:50%; text-align:center;">
                <strong>Inspektor (ICT)</strong><br><br>
                <div class="sign-box" style="border:none;">
                    @if($inspektorData && $inspektorData->qr_code)
                        <img src="{{ public_path('storage/qr_codes/'.$inspektorData->qr_code) }}" alt="TTD Inspektor" style="width:70px; height:auto;">
                    @else
                        <div style="height:40px;"></div>
                    @endif
                </div>
               <br>
                Nama : {{ $inspeksimonitor->inspektor }}<br>
                Jabatan : {{ $inspeksimonitor->jabatan_inspektor }}
            </td>

            <td style="width:50%; text-align:center;">
                <strong>Diketahui Oleh</strong><br>
                <div class="sign-box" style="border:none;">
                    @if($diketahuiData && $diketahuiData->qr_code)
                        <img src="{{ public_path('storage/qr_codes/'.$diketahuiData->qr_code) }}" alt="TTD Diketahui" style="width:80px; height:auto;">
                    @else
                        <div style="height:40px;"></div>
                    @endif
                </div>
                <br><br>
                Nama : {{ $inspeksimonitor->diketahui_oleh }} <br>
                Jabatan : {{ $inspeksimonitor->karyawans }} Group Leader
            </td>
        </tr>
    </table>
</body>
</html>
