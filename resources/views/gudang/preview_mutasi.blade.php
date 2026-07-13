@extends('layouts.app')

@section('content')
@include('gudang.partials.preview_styles')

<div class="page-container">
    <div class="container-fluid py-4">
        <div class="preview-page-header no-print">
            <h4 class="fw-bold mb-1">Pratinjau Laporan Mutasi Stok</h4>
            <p class="mb-0 small">Periksa data sebelum cetak atau buka PDF</p>
        </div>

        <div class="preview-container">
            <div class="preview-actions no-print">
                <a href="{{ route('gudang.laporan') }}" class="btn btn-secondary btn-sm">Kembali</a>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="window.print()">Cetak</button>
                <a href="{{ route('gudang.report.mutasi') }}" target="_blank" class="btn btn-danger btn-sm">Buka PDF</a>
            </div>

            @include('gudang.partials.report_header_preview', [
                'reportTitle' => 'LAPORAN MUTASI STOK GUDANG IT',
                'docNumber' => 'PPA-ADRO-F-ICT-03',
            ])

            <div class="table-responsive">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th colspan="6" class="section-title">RIWAYAT MUTASI STOK MASUK / KELUAR</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
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
                        <tr>
                            <td colspan="6">Belum ada riwayat mutasi stok</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
