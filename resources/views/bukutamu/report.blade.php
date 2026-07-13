<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Buku Tamu</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            margin: 40px; 
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo img {
            width: 300px;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .judul {
            background-color: #d9d9d9;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <!-- Logo di Tengah -->
    <div class="logo">
        <img src="{{ public_path('images/ppa-logo.png') }}" alt="Logo PPA">
    </div>

    <!-- Tabel Laporan Buku Tamu (Menyatu Seperti Identitas Perangkat) -->
    <table>
        <thead>
            <tr>
                <th class="judul" colspan="9">LAPORAN BUKU TAMU</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No Telepon</th>
                <th>NRP</th>
                <th>Instansi</th>
                <th>Keperluan</th>
                <th>PIC</th>
                <th>Departemen PIC</th>
                <th>Tanggal Registrasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bukutamu as $tamu)
            <tr>
                <td style="text-align:center;">{{ $loop->iteration }}</td>
                <td>{{ $tamu->nama }}</td>
                <td>{{$tamu->no_telp}}</td>
                <td>{{ $tamu->nrp }}</td>
                <td>{{ $tamu->instansi }}</td>
                <td>{{ $tamu->keperluan }}</td>
                <td>{{ $tamu->pic->nama ?? '-' }}</td>
                <td>{{ $tamu->pic->departemen ?? '-' }}</td>
                <td>{{ $tamu->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

