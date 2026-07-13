@extends('layouts.app')

@section('content')
@include('gudang.partials.preview_styles')

<div class="page-container">
    <div class="container-fluid py-4">
        <div class="preview-page-header no-print">
            <h4 class="fw-bold mb-1">Pratinjau Laporan Barang Baru</h4>
            <p class="mb-0 small">Periksa data sebelum cetak atau buka PDF</p>
        </div>

        <div class="preview-container">
            <div class="preview-actions no-print">
                <a href="{{ route('gudang.laporan') }}" class="btn btn-secondary btn-sm">Kembali</a>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="window.print()">Cetak</button>
                <a href="{{ route('gudang.report.baru') }}" target="_blank" class="btn btn-danger btn-sm">Buka PDF</a>
            </div>

            @include('gudang.partials.report_header_preview', [
                'reportTitle' => 'LAPORAN BARANG BARU GUDANG IT',
                'docNumber' => 'PPA-ADRO-F-ICT-02',
            ])

            <div class="table-responsive">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th colspan="8" class="section-title">DAFTAR BARANG BARU (30 HARI TERAKHIR)</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Nama Perangkat</th>
                            <th>Merek</th>
                            <th>Kategori</th>
                            <th>Stok Total</th>
                            <th>Stok Tersedia</th>
                            <th>Kondisi</th>
                            <th>Tgl Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
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
                        <tr>
                            <td colspan="8">Tidak ada barang baru dalam 30 hari terakhir</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
