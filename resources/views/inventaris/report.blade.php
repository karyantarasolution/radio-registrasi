<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Data Inventaris</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NRP</th>
                <th>Nama Perangkat</th>
                <th>No Asset</th>
                <th>Status</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventaris as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nrp }}</td>
                <td>{{ $item->nama_perangkat }}</td>
                <td>{{ $item->no_asset }}</td>
                <td>{{ $item->status_peminjaman }}</td>
                <td>{{ $item->tanggal_peminjaman }}</td>
                <td>{{ $item->tanggal_pengembalian ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
