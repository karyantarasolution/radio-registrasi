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
        position: relative;
        overflow: hidden;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
        pointer-events: none;
    }
    @keyframes float {
        0%,100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    .laporan-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .laporan-card h5 { margin: 0; font-weight: 700; }
    .laporan-card p { margin: 4px 0 0; color: #6c757d; font-size: 0.9rem; }
    .btn-modern {
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-modern:hover { opacity: .9; }
    .btn-preview { background: linear-gradient(135deg, #ea6666, #f71414); }
    .btn-pdf { background: linear-gradient(135deg, #ff6b6b, #ee5a5a); }
    .btn-back {
        background: linear-gradient(45deg, #7f8c8d, #95a5a6);
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
    }
    .btn-back:hover { opacity: .9; color: #fff; }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="page-header">
            <h2 class="fw-bold mb-1">Laporan Gudang IT</h2>
            <p class="mb-0">Pilih laporan yang ingin dilihat atau diekspor ke PDF</p>
        </div>

        <div class="laporan-card">
            <div>
                <h5>1. Barang Perlu Maintenance</h5>
                <p>Daftar barang dengan kondisi Perlu Maintenance</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('gudang.preview.maintenance') }}" class="btn-modern btn-preview">Lihat Laporan</a>
                <a href="{{ route('gudang.report.maintenance') }}" target="_blank" class="btn-modern btn-pdf">PDF</a>
            </div>
        </div>

        <div class="laporan-card">
            <div>
                <h5>2. Barang Baru</h5>
                <p>Barang yang masuk gudang dalam 30 hari terakhir</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('gudang.preview.baru') }}" class="btn-modern btn-preview">Lihat Laporan</a>
                <a href="{{ route('gudang.report.baru') }}" target="_blank" class="btn-modern btn-pdf">PDF</a>
            </div>
        </div>

        <div class="laporan-card">
            <div>
                <h5>3. Mutasi Stok</h5>
                <p>Riwayat stok masuk dan keluar gudang IT</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('gudang.preview.mutasi') }}" class="btn-modern btn-preview">Lihat Laporan</a>
                <a href="{{ route('gudang.report.mutasi') }}" target="_blank" class="btn-modern btn-pdf">PDF</a>
            </div>
        </div>

        <a href="{{ route('gudang-barang.index') }}" class="btn-back">Kembali ke Gudang IT</a>
    </div>
</div>
@endsection
