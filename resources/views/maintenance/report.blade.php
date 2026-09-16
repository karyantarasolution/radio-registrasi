<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Maintenance</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 10px; color: #333; }
        h1 { font-size: 16px; margin: 0 0 2px 0; }
        h2 { font-size: 13px; margin: 2px 0 10px 0; font-weight: normal; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 12px; }
        .header small { color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 5px 6px; text-align: center; }
        th { background: #eee; }
        .left { text-align: left; }
        .footer { margin-top: 14px; font-size: 9px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT. PUTRA PERKASA ABADI</h1>
        <h2>Laporan Maintenance Perangkat IT</h2>
        <small>Dicetak: {{ now()->timezone('Asia/Makassar')->format('d/m/Y H:i') }}</small>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Maintenance</th>
                <th class="left">Perangkat</th>
                <th class="left">Jenis Kerusakan</th>
                <th>Status</th>
                <th>Petugas</th>
                <th>Tgl Masuk</th>
                <th>Tgl Selesai</th>
                <th class="left">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $m)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $m->nomor_maintenance }}</td>
                <td class="left">{{ $m->gudangBarang->nama_perangkat ?? '-' }}</td>
                <td class="left">{{ $m->jenis_kerusakan }}</td>
                <td>{{ $m->status }}</td>
                <td>{{ $m->petugas ?? '-' }}</td>
                <td>{{ $m->tanggal_masuk->format('d/m/Y') }}</td>
                <td>{{ $m->tanggal_selesai?->format('d/m/Y') ?? '-' }}</td>
                <td class="left">{{ Str::limit($m->tindakan_perbaikan ?? '-', 60) }}</td>
            </tr>
            @empty
            <tr><td colspan="9">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total tiket: {{ $data->count() }} · Menunggu: {{ $data->where('status','Menunggu')->count() }} · Diproses: {{ $data->where('status','Diproses')->count() }} · Selesai: {{ $data->where('status','Selesai')->count() }}
    </div>
</body>
</html>