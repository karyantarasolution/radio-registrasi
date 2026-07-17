<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 4px 6px; text-align: center; }
        th { background-color: #eee; font-weight: bold; }
        .logo { text-align: center; margin-bottom: 10px; }
        .logo img { width: 250px; height: auto; }
        .judul { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        .sub-judul { text-align: center; font-size: 11px; color: #666; margin-bottom: 15px; }
        .footer { margin-top: 30px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('images/ppa-logo.png') }}" alt="Logo PPA">
    </div>
    <div class="judul">LAPORAN DATA PENGAJUAN BARANG IT</div>
    <div class="sub-judul">PT. Putra Perkasa Abadi - {{ now()->format('d F Y') }}</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Estimasi Biaya</th>
                <th>Diajukan Oleh</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nomor_pengajuan }}</td>
                <td>{{ $p->judul }}</td>
                <td>{{ $p->kategori }}</td>
                <td>{{ $p->nama_barang }}</td>
                <td>{{ $p->jumlah_diminta }} {{ $p->satuan }}</td>
                <td>
                    @if($p->estimasi_biaya)
                        Rp {{ number_format($p->estimasi_biaya, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->tanggal_pengajuan?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $p->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">Belum ada pengajuan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
