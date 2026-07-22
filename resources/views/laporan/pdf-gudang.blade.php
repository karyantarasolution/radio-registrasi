<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Laporan Gudang IT</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:11px; }
    table { width:100%; border-collapse: collapse; }
    .bordered td, .bordered th { border:1px solid #000; padding:5px; text-align:center; }
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
            <h3>LAPORAN GUDANG IT</h3>
            <div>ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td>No. Dokumen</td><td>: PPA-ADRO-F-ICT-10</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
                <tr><td>Halaman</td><td>: 1</td></tr>
            </table>
        </td>
    </tr>
</table>

<table class="bordered">
    <tr><th colspan="9" class="section-title">DAFTAR STOK GUDANG IT</th></tr>
    <tr>
        <th style="width:4%;">No</th>
        <th style="width:18%;">Nama Perangkat</th>
        <th style="width:12%;">Merek</th>
        <th style="width:12%;">Kategori</th>
        <th style="width:8%;">Stok Total</th>
        <th style="width:8%;">Stok Tersedia</th>
        <th style="width:12%;">Kondisi</th>
        <th style="width:12%;">Tgl Masuk</th>
        <th style="width:12%;">Keterangan</th>
    </tr>
    @forelse($barang as $b)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $b->nama_perangkat }}</td>
        <td>{{ $b->merk ?? '-' }}</td>
        <td>{{ $b->kategori }}</td>
        <td>{{ $b->stok_total }}</td>
        <td>{{ $b->stok_tersedia }}</td>
        <td>{{ $b->kondisi }}</td>
        <td>{{ $b->tanggal_masuk->format('d-M-Y') }}</td>
        <td>{{ $b->keterangan ?? '-' }}</td>
    </tr>
    @empty
    <tr><td colspan="9">Belum ada data gudang</td></tr>
    @endforelse
</table>

@if($mutasi->isNotEmpty())
<table class="bordered" style="margin-top:15px;">
    <tr><th colspan="6" class="section-title">RIWAYAT MUTASI STOK (50 TRANSAKSI TERAKHIR)</th></tr>
    <tr>
        <th style="width:4%;">No</th>
        <th style="width:16%;">Tanggal</th>
        <th style="width:24%;">Nama Barang</th>
        <th style="width:12%;">Jenis</th>
        <th style="width:10%;">Jumlah</th>
        <th style="width:34%;">Keterangan</th>
    </tr>
    @foreach($mutasi as $m)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $m->created_at->format('d-M-Y H:i') }}</td>
        <td>{{ $m->gudangBarang->nama_perangkat ?? '-' }}</td>
        <td>{{ $m->jenis }}</td>
        <td>{{ $m->jumlah }}</td>
        <td>{{ $m->keterangan }}</td>
    </tr>
    @endforeach
</table>
@endif

@include('laporan.partials.signature_pdf')

<div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
