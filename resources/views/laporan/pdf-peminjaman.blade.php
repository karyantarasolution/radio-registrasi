<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Laporan Peminjaman</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:10px; }
    table { width:100%; border-collapse: collapse; }
    .bordered td, .bordered th { border:1px solid #000; padding:4px; text-align:center; }
    .section-title { background:#bfbfbf; font-weight:bold; padding:4px; text-align:left; }
    h3 { margin:0; padding:0; }
    .footer { margin-top:10px; font-size:10px; color:#999; text-align:center; }
</style>
</head>
<body>

<table style="width:100%; margin-bottom:8px;">
    <tr>
        <td style="width:15%; text-align:center;">
            <img src="{{ public_path('images/LogoPPA.png') }}" alt="logo" style="max-width:80px;">
        </td>
        <td style="width:55%; text-align:center;">
            <h3>LAPORAN PEMINJAMAN BARANG IT</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-ICT-11</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

<table class="bordered">
    <tr><th colspan="10" class="section-title">DAFTAR PEMINJAMAN PERANGKAT IT</th></tr>
    <tr>
        <th style="width:3%;">No</th>
        <th style="width:12%;">Nama</th>
        <th style="width:8%;">NRP</th>
        <th style="width:14%;">Perangkat</th>
        <th style="width:8%;">No Asset</th>
        <th style="width:12%;">Status</th>
        <th style="width:10%;">Verifikasi</th>
        <th style="width:9%;">Tgl Pinjam</th>
        <th style="width:9%;">Est. Kembali</th>
        <th style="width:9%;">Tgl Aktual</th>
    </tr>
    @forelse($inventaris as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->nrp }}</td>
        <td>{{ $item->nama_perangkat }}</td>
        <td>{{ $item->no_asset }}</td>
        <td>{{ $item->status_peminjaman }}</td>
        <td>{{ $item->status_verifikasi ?? 'Pending' }}</td>
        <td>{{ $item->tanggal_peminjaman }}</td>
        <td>{{ $item->tanggal_pengembalian?->format('d/m/Y') ?? '-' }}</td>
        <td>{{ $item->tanggal_actual_kembali?->format('d/m/Y') ?? '-' }}</td>
    </tr>
    @empty
    <tr><td colspan="10">Belum ada data peminjaman</td></tr>
    @endforelse
</table>

@include('laporan.partials.signature_pdf')

<div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
