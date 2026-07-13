<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Karyawan ICT</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
        th { background-color: #eee; }
        .header-table { border: none; margin-bottom: 8px; }
        .header-table td { border: none; padding: 2px; }
        .judul {
            background-color: #bfbfbf;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<table class="header-table" style="width:100%;">
    <tr>
        <td style="width:15%; text-align:center;">
            <img src="{{ public_path('images/LogoPPA.png') }}" style="max-width:70px;">
        </td>
        <td style="width:55%; text-align:center;">
            <strong style="font-size:14px;">LAPORAN DATA KARYAWAN ICT</strong><br>
            ICT (Information Communication & Technology)
        </td>
        <td style="width:30%; font-size:11px;">
            Tgl Cetak: {{ now()->format('d-M-Y') }}<br>
            Total: {{ $karyawans->count() }} karyawan
        </td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th class="judul" colspan="6">DAFTAR KARYAWAN IT</th>
        </tr>
        <tr>
            <th style="width:5%;">No</th>
            <th style="width:22%;">Nama</th>
            <th style="width:15%;">NRP</th>
            <th style="width:22%;">Jabatan</th>
            <th style="width:18%;">Departemen</th>
            <th style="width:18%;">QR Code</th>
        </tr>
    </thead>
    <tbody>
        @forelse($karyawans as $k)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $k->nama }}</td>
            <td>{{ $k->nrp }}</td>
            <td>{{ $k->jabatan }}</td>
            <td>{{ $k->departemen }}</td>
            <td>
                @if($k->qr_code)
                    <img src="{{ public_path('storage/qr_codes/'.$k->qr_code) }}"
                         style="width:40px;">
                @else
                    -
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Belum ada data karyawan</td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
