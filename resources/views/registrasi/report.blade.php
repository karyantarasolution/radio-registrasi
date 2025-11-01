<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
   <title>Laporan Registrasi Radio</title>
   <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table,tbody, th { font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; }
        table,thead, th { font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #000; padding: 3px; }
        table,tbody, th { border: 1px solid #000; padding: 3px;text-align: left;  }
        table,thead, th { border: 1px solid #000; padding: 3px;text-align: center; }
        .title { text-align: center; font-weight: bold; font-size: 30px; }
        .subtitle { text-align: center; font-weight: bold; font-size: 20px; }
        .header-table td { 
            font-size: 10px; 
            text-align: left;       /* Rata kiri */
            vertical-align: top;    /* Supaya nempel ke atas */
            padding-left: 5px;      /* Kasih jarak dari garis */
        }
        .header-label { font-weight: bold; width: 25%; }
        .header-value { font-weight: normal; }

        .check {
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            display: inline-block;
        }
    
        .check {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 4px; /* jarak kotak dengan teks */
        }

        .miring {
            font-style: italic;
        }


        .indent {
            display: inline-block;
            margin-left: 45px; /* atur sesuai kebutuhan */
        }

    </style>
</head>
<body>
    <!-- Logo kanan atas -->
    <img src="{{ $logoPath }}" alt="Logo" 
    style="position: absolute; top: -35px; right: 5px; height: 120px;">

    <!-- Judul -->
    <div class="title">PT ADARO INDONESIA</div>
    <div class="subtitle">SETTING CHANNEL FREKUENSI<br>RADIO KOMUNIKASI</div>
    <br>
    

    <!-- Data Header -->
    <table class="header-table-atas">
        <tr>
            <td class="header-label">TANGGAL PERMINTAAN</td>
            <td class="header-value">{{ \Carbon\Carbon::parse($registrasi->tanggal_permintaan)->format('d M Y') }}</td>
            <td class="header-label">ID PTT</td>
            <td class="header-value">{{ $registrasi->id_ptt }}</td>
        </tr>
        <tr>
            <td class="header-label">PERUSAHAAN</td>
            <td class="header-value">{{ $registrasi->perusahaan }}</td>
            <td class="header-label">MERK RADIO</td>
            <td class="header-value">{{ $registrasi->merek_radio }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="header-value"></td>
            <td class="header-label">SERIAL NOMOR</td>
            <td class="header-value">{{ $registrasi->serial_number }}</td>
        </tr>
        <tr>
            <td class="header-label">NOMOR LAMBUNG</td>
            <td class="header-value">{{ $registrasi->nomor_lambung }}</td>
            <td class="header-label">RANGE POWER</td>
            <td>
                <span class="check"></span> 25w
                <span class="check" style="margin-left:15px;"></span> 45w
            </td>
        </tr>
        <tr>
            <td class="header-label">JENIS KENDARAAN</td>
            <td class="header-value">{{ $registrasi->jenis_kendaraan }}</td>
            <td class="header-label">RANGE FREKUENSI</td>
            <td>
                <span class="check"></span>136-162
                <span class="check" style="margin-left:15px;"></span> 146-174
            </td>
        </tr>
        <tr>
            <td class="header-label">NOMOR POLISI</td>
            <td class="header-value">{{ $registrasi->nomor_polisi }}</td>
            <td class="header-label">JENIS RADIO</td>
            <td>
                <span class="check"></span> Mobile
                <span class="check" style="margin-left:15px;"></span> HT
                <span class="check" style="margin-left:15px;"></span> Base
            </td>
        </tr>
    </table>

    <br>

    <!-- Tabel Channel Frekuensi dengan kolom checklist di setiap cell -->
    <table>
        <thead>
            <tr>
                <th style="width:8px;"></th><th>ADARO</th>
                <th style="width:8px;"></th><th>PAMA</th>
                <th style="width:8px;"></th><th>SIS</th>
                <th style="width:8px;"></th><th>PPA</th>
                <th style="width:8px;"></th><th>BUMA</th>
                <th style="width:8px;"></th><th>SUKONTRAKTOR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 5px;"></td><td>ADARO 2</td>
                <td></td><td>LW</td>
                <td></td><td>SIS 3</td>
                <td></td><td>PPA SECURITY</td>
                <td></td><td>PSV</td>
                <td></td><td>REP OPCC</td>
            </tr>
            <tr>
                <td></td><td>ADARO 4</td>
                <td></td><td>HW1</td>
                <td></td><td>SIS 4</td>
                <td></td><td>PPA FRONT</td>
                <td></td><td>MCC</td>
                <td></td><td>OPCC</td>
            </tr>
            <tr>
                <td></td><td>MWM</td>
                <td></td><td>HW2</td>
                <td></td><td>SIS 5</td>
                <td></td><td>PPA DISPOSAL</td>
                <td></td><td>PRO 1</td>
                <td></td><td>RMI</td>
            </tr>
            <tr>
                <td></td><td>WARA CRUSHER</td>
                <td></td><td>HILL 11</td>
                <td></td><td>SIS 7</td>
                <td></td><td>PPA CCR</td>
                <td></td><td>PRO 2</td>
                <td></td><td>CBML</td>
            </tr>
            <tr>
                <td></td><td>SURVEY 1</td>
                <td></td><td>ROM</td>
                <td></td><td>SIS 8</td>
                <td></td><td>PPA PLANT</td>
                <td></td><td>BLASTING</td>
                <td></td><td>BC 1</td>
            </tr>
            <tr>
                <td></td><td>SURVEY 2</td>
                <td></td><td>HAULING</td>
                <td></td><td>SIS 9</td>
                <td></td><td>PPA BASECONTROL</td>
                <td></td><td>SURVEY</td>
                <td></td><td>BC 2</td>
            </tr>
            <tr>
                <td></td><td>SURVEY 3</td>
                <td></td><td>ADS 1</td>
                <td></td><td>SIS 10</td>
                <td></td><td>PPA 1</td>
                <td></td><td>LW</td>
                <td></td><td>BC 3</td>
            </tr>
            <tr>
                <td></td><td>GEOTECH</td>
                <td></td><td>ADS 3</td>
                <td></td><td>SIS 11</td>
                <td></td><td>PPA 2</td>
                <td></td><td>HW</td>
                <td></td><td>SERA</td>
            </tr>
            <tr>
                <td></td><td>HOPPER KLS</td>
                <td></td><td>DIGGER</td>
                <td></td><td>ROM 15</td>
                <td></td><td></td>
                <td></td><td>ROM</td>
                <td></td><td></td>
            </tr>
            <tr>
                <td></td><td>ROM KLS</td>
                <td></td><td>FUEL</td>
                <td></td><td>SIS 35</td>
                <td></td><td></td>
                <td></td><td>PLANT 76</td>
                <td></td><td></td>
            </tr>
            <tr>
                <td></td><td>MTN KLS</td>
                <td></td><td>BLASTING</td>
                <td></td><td>PSV</td>
                <td></td><td></td>
                <td></td><td></td>
                <td></td><td></td>
            </tr>
            <tr>
                <td></td><td>OPR KLS</td>
                <td></td><td>WORKSHOP</td>
                <td></td><td>MCR NEW</td>
                <td></td><td></td>
                <td></td><td></td>
                <td></td><td></td>
            </tr>
            <tr>
                <td></td><td>ROM 18</td>
                <td></td><td></td>
                <td></td><td></td>
                <td></td><td></td>
                <td></td><td></td>
                <td></td><td></td>
            </tr>
        </tbody>
    </table>


     <p class="miring">
       Catatan: 1. List channel yang dipilihkan sesuai di butuhkan <br>
        <span style="margin-left: 47px;">2. Channel yang dibutuhkan tidak ada didaftar, silahkan ditulis dikolom kosong sesuai perusahaan pemilik izin frekuensi.</span>
    </p>

    <!-- ===== Tabel Pemohon & PJA/Custodian ===== -->
    <table style="width:45%; float:left; border:1px solid #000; border-collapse:collapse;">
        <tr>
            <th style="width:50%; text-align:center; border:1px solid #000; padding:8px;">
            PEMOHON<br><br><br><br><br>
            <span>Arisal Farzan</span>
            </th>
            <th style="width:55%; text-align:center; border:1px solid #000; padding:8px;">
            PJA/CUSTODIAN<br><br><br><br><br>
            <span></span>
            </th>
        </tr>
    </table>

    <!-- ===== Tabel Adaro (terpisah) ===== -->
    <table style="width:35%; float:right; border:1px solid #000; border-collapse:collapse;">
        <tr>
            <th style="text-align:center; border:1px solid #000; padding:8px;">
            PT ADARO INDONESIA<br>
            GENERAL AFFAIRS DEPT<br><br><br><br><br>
            </th>
        </tr>
    </table>

        <div style="clear:both;"></div>


    <br><br>

        <!-- Pemilik Izin -->
        <style>
        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
        }
        .center {
            text-align: center;
        }
        .bottom-text {
            vertical-align: bottom;
            text-align: left;
            padding-left: 5px;
        }
</style>

        <table>
            <tr>
                <th colspan="7" class="center">PEMILIK IZIN FREKUENSI RADIO</th>
            </tr>
            <tr style="height:90px;">
                <th>
                    PT PPA<br>COE DEPT
                    <div style="margin-top:30px;">
                        <span>Angga M. S</span>
                    </div>
                </th>
                <th>PT SIS<br>IT DEPT</th>
                <th>PT BUMA<br>IT DEPT</th>
                <th>PT JPI<br>OPS DEPT</th>
                <th>PT RMI</th>
                <th>PT CBML</th>
                <th>BALANGAN<br>COAL</th>
            </tr>
        </table>

    <p class="miring">
    Copy 1. Telekomunikasi PT Adaro Indonesia<br>
    <span style="margin-left: 30px;">2. Subkontraktor</span>
    </p>

</html>
