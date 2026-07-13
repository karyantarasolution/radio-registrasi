<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Laporan Barang Perlu Maintenance</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
    table { width:100%; border-collapse: collapse; }
    .bordered td, .bordered th { border:1px solid #000; padding:6px; text-align:center; }
    .section-title { background:#bfbfbf; font-weight:bold; padding:4px; text-align:left; }
    h3 { margin:0; padding:0; }
</style>
</head>
<body>

@include('gudang.partials.report_header_pdf', [
    'reportTitle' => 'LAPORAN BARANG PERLU MAINTENANCE',
    'docNumber' => 'PPA-ADRO-F-ICT-01',
])

<table class="bordered">
    <tr><th colspan="8" class="section-title">DAFTAR BARANG PERLU MAINTENANCE</th></tr>
    <tr>
        <th style="width:5%;">No</th>
        <th style="width:22%;">Nama Perangkat</th>
        <th style="width:12%;">Merek</th>
        <th style="width:12%;">Kategori</th>
        <th style="width:10%;">Stok Total</th>
        <th style="width:10%;">Stok Tersedia</th>
        <th style="width:12%;">Kondisi</th>
        <th style="width:13%;">Tgl Masuk</th>
    </tr>
    @forelse($items as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_perangkat }}</td>
        <td>{{ $item->merk ?? '-' }}</td>
        <td>{{ $item->kategori }}</td>
        <td>{{ $item->stok_total }}</td>
        <td>{{ $item->stok_tersedia }}</td>
        <td>{{ $item->kondisi }}</td>
        <td>{{ $item->tanggal_masuk->format('d-M-Y') }}</td>
    </tr>
    @empty
    <tr><td colspan="8">Tidak ada barang perlu maintenance</td></tr>
    @endforelse
</table>

@if($items->isNotEmpty())
<div style="margin-top:10px;">
    <strong>KETERANGAN:</strong>
    <div style="min-height:50px; border:1px solid #000; padding:6px;">
        Laporan barang dengan kondisi Perlu Maintenance pada gudang IT.
        Total: {{ $items->count() }} jenis barang.
    </div>
</div>
@endif

</body>
</html>
