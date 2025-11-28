<!doctype html>
<html>
        <head>
        <meta charset="utf-8"/>
        <title>Inspeksi Stavolt - {{ $inspeksistavolt->nomor_aset }}</title>
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
                    <h3>INSPEKSI STABILIZER VOLTASE (STAVOLT)</h3>
                    <div>ICT (Information Communication & Technology)</div>
                </td>
                <td style="width:35%;">
                    <table style="width:100%; border-collapse:collapse;">
                        <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-COE-50</td></tr>
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
                <td>Nomor Aset</td><td>{{ $inspeksistavolt->nomor_aset }}</td>
                <td>Departemen</td><td>{{ $inspeksistavolt->departemen }}</td>
            </tr>
            <tr>
                <td>Merek</td><td>{{ $inspeksistavolt->merek }}</td>
                <td>Lokasi</td><td>{{ $inspeksistavolt->lokasi }}</td>
            </tr>
            <tr>
                <td>Type</td><td>{{ $inspeksistavolt->type }}</td>
                <td>Tanggal Inspeksi</td><td>{{ optional($inspeksistavolt->tanggal_inspeksi)->format('d-M-Y') }}</td>
            </tr>
            <tr>
                <td>Serial Number</td><td>{{ $inspeksistavolt->sn }}</td>
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
            use App\Models\Karyawan;
            
                $checks = [
                    ['label'=>'Kondisi casing stavolt','key'=>'casing'],
                    ['label'=>'Kebersihan stavolt','key'=>'kebersihan'],
                    ['label'=>'Kondisi kabel adaptor','key'=>'kabel_adaptor'],
                    ['label'=>'Kondisi tombol dan switch','key'=>'tombol_switch'],
                    ['label'=>'Indikator voltase input/output (220 V)','key'=>'indikator_voltase'],
                    ['label'=>'Respon terhadap perubahan beban','key'=>'respon_perubahan_beban'],
                ];

                // Ambil data karyawan untuk inspektor dan diketahui
                $inspektorData = Karyawan::where('nama', $inspeksistavolt->inspektor)->first();
                $diketahuiData = Karyawan::where('nama', $inspeksistavolt->diketahui_oleh)->first();
            @endphp

            @foreach($checks as $c)
            <tr>
                <td>{{ $c['label'] }}</td>
                <td style="text-align:center;">{!! $inspeksistavolt->{$c['key']} == 'Baik' ? '&#10003;' : '' !!}</td>
                <td style="text-align:center;">{!! $inspeksistavolt->{$c['key']} == 'Tidak' ? '&#10007;' : '' !!}</td>
                <td>{{ $inspeksistavolt->{'tindakan_'.$c['key']} }}</td>
            </tr>
            @endforeach
        </table>

        <div style="margin-top:10px;">
            <strong>KETERANGAN:</strong>
            <div style="min-height:70px; border:1px solid #000; padding:6px;">{{ $inspeksistavolt->keterangan }}</div>
        </div>

        {{-- TANDA TANGAN --}}
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
                    Nama : {{ $inspeksistavolt->inspektor }}<br>
                    Jabatan : {{ $inspeksistavolt->jabatan_inspektor }}
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
                    Nama : {{ $inspeksistavolt->diketahui_oleh }} <br>
                    Jabatan : {{ $inspeksistavolt->karyawans }} Group Leader
                </td>
            </tr>
        </table>
    </body>
</html>
