<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Laporan Mutasi Stok</title>
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
    'reportTitle' => 'LAPORAN MUTASI STOK GUDANG IT',
    'docNumber' => 'PPA-ADRO-F-ICT-03',
])

<table class="bordered">
    <tr><th colspan="6" class="section-title">RIWAYAT MUTASI STOK MASUK / KELUAR</th></tr>
    <tr>
        <th style="width:5%;">No</th>
        <th style="width:16%;">Tanggal</th>
        <th style="width:24%;">Nama Barang</th>
        <th style="width:12%;">Jenis</th>
        <th style="width:10%;">Jumlah</th>
        <th style="width:33%;">Keterangan</th>
    </tr>
    @forelse($items as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->created_at->format('d-M-Y H:i') }}</td>
        <td>{{ $item->gudangBarang->nama_perangkat ?? '-' }}</td>
        <td>{{ $item->jenis }}</td>
        <td>{{ $item->jumlah }}</td>
        <td>{{ $item->keterangan }}</td>
    </tr>
    @empty
    <tr><td colspan="6">Belum ada riwayat mutasi stok</td></tr>
    @endforelse
</table>

@if($items->isNotEmpty())
<div style="margin-top:10px;">
    <strong>KETERANGAN:</strong>
    <div style="min-height:50px; border:1px solid #000; padding:6px;">
        Riwayat mutasi stok masuk dan keluar gudang IT.
        Total: {{ $items->count() }} transaksi.
    </div>
</div>
@endif

</body>
</html>
