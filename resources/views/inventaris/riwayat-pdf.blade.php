<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 4px 6px; text-align: center; }
        th { background-color: #eee; font-weight: bold; }
        .logo { text-align: center; margin-bottom: 10px; }
        .logo img { width: 250px; height: auto; }
        .judul { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        .sub-judul { text-align: center; font-size: 11px; color: #666; margin-bottom: 15px; }
        .account-section { margin-bottom: 20px; page-break-inside: avoid; }
        .account-title { background: #2c3e50; color: #fff; padding: 6px 12px; font-weight: bold; font-size: 12px; border-radius: 4px 4px 0 0; }
        .footer { margin-top: 30px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('images/ppa-logo.png') }}" alt="Logo PPA">
    </div>
    <div class="judul">LAPORAN RIWAYAT PEMINJAMAN PER AKUN</div>
    <div class="sub-judul">PT. Putra Perkasa Abadi - {{ now()->format('d F Y') }}</div>

    @forelse($riwayat as $nrp => $items)
        @php $first = $items->first(); @endphp
        <div class="account-section">
            <div class="account-title">
                {{ $first->nama }} (NRP: {{ $nrp }}) - {{ $items->count() }} peminjaman
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Perangkat</th>
                        <th>No Asset</th>
                        <th>Tgl Pinjam</th>
                        <th>Estimasi Kembali</th>
                        <th>Tgl Aktual Kembali</th>
                        <th>Status</th>
                        <th>Kondisi</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_perangkat }}</td>
                        <td>{{ $item->no_asset ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') }}</td>
                        <td>{{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $item->tanggal_actual_kembali ? \Carbon\Carbon::parse($item->tanggal_actual_kembali)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $item->status_peminjaman }}</td>
                        <td>{{ $item->kondisi_pengembalian ?? '-' }}</td>
                        <td>{{ $item->catatan_pengembalian ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p style="text-align:center; color:#999;">Belum ada riwayat peminjaman</p>
    @endforelse

    <div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
