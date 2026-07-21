@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    .page-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .table-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .table-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .table-custom { width: 100%; border-collapse: collapse; }
    .table-custom thead { background: #f8f9fa; }
    .table-custom th {
        padding: 12px;
        font-weight: 600;
        text-align: center;
        border-bottom: 2px solid #dee2e6;
    }
    .table-custom td {
        padding: 10px;
        text-align: center;
        border-top: 1px solid #f1f1f1;
        font-size: 14px;
    }
    .table-custom tbody tr:hover { background: #f8f9fa; }
    .btn-modern {
        border: none;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-modern:hover { opacity: .9; }
    .btn-pdf { background: linear-gradient(135deg, #ff6b6b, #ee5a5a); }
    .btn-excel { background: linear-gradient(135deg, #43cea2, #185a9d); }
    .btn-back { background: linear-gradient(135deg, #6c757d, #495057); }
    .stat-row { display: flex; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .stat-mini {
        background: #fff;
        border-radius: 12px;
        padding: 15px 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        flex: 1;
        min-width: 150px;
        text-align: center;
    }
    .stat-mini .num { font-size: 1.5rem; font-weight: 700; }
    .stat-mini .lbl { font-size: 0.8rem; color: #6c757d; margin-top: 2px; }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1"><i class="fas fa-plug me-2"></i>Laporan Inspeksi Stavolt</h2>
                    <p class="mb-0">Daftar seluruh data inspeksi perangkat Stavolt</p>
                    <small>PT. Putra Perkasa Abadi</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('pimpinan.laporan') }}" class="btn btn-back btn-modern">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="stat-row">
            <div class="stat-mini">
                <div class="num" style="color:#3498db;">{{ $data->total() }}</div>
                <div class="lbl">Total Data</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#2980b9;">{{ $data->pluck('lokasi')->unique()->count() }}</div>
                <div class="lbl">Lokasi Berbeda</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#27ae60;">{{ $data->pluck('merek')->unique()->count() }}</div>
                <div class="lbl">Merek Berbeda</div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h4 style="font-weight:bold; margin:0;">📋 Data Inspeksi Stavolt</h4>
                <div>
                    <a href="{{ route('inspeksistavolt.export.excel') }}" class="btn btn-excel btn-modern" target="_blank">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Aset</th>
                            <th>Merek</th>
                            <th>Lokasi</th>
                            <th>Tanggal Inspeksi</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ $row->nomor_aset }}</td>
                            <td>{{ $row->merek }}</td>
                            <td>{{ $row->lokasi }}</td>
                            <td>{{ optional($row->tanggal_inspeksi)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('inspeksistavolt.report', $row->id) }}"
                                   class="btn btn-pdf btn-modern" target="_blank">
                                    <i class="fas fa-file-pdf me-1"></i> PDF
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">📭 Belum ada data inspeksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center py-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
