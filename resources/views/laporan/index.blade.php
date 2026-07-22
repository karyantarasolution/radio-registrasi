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
        top: -50%; right: -10%;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
        pointer-events: none;
    }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-20px)} }
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
        transition: transform 0.2s;
    }
    .laporan-card:hover { transform: translateY(-2px); }
    .laporan-card h5 { margin: 0; font-weight: 700; color: #2c3e50; }
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
    .btn-view { background: linear-gradient(135deg, #2980b9, #3498db); }
    .laporan-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: #fff;
        flex-shrink: 0;
    }
    .stat-row {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
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
    .section-divider {
        border: none;
        border-top: 2px dashed #dee2e6;
        margin: 30px 0;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #6c757d;
        margin-bottom: 20px;
    }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="page-header">
            <h2 class="fw-bold mb-1"><i class="fas fa-chart-bar me-2"></i>Laporan</h2>
            <p class="mb-0">Akses semua laporan sistem inventaris IT</p>
            <small>PT. Putra Perkasa Abadi</small>
        </div>

        <div class="stat-row">
            <div class="stat-mini">
                <div class="num" style="color:#2980b9;">{{ $stats['total_barang'] }}</div>
                <div class="lbl">Total Barang Gudang</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#28a745;">{{ $stats['stok_tersedia'] }}</div>
                <div class="lbl">Stok Tersedia</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#e67e22;">{{ $stats['maintenance'] }}</div>
                <div class="lbl">Maintenance/Rusak</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#17a2b8;">{{ $stats['total_peminjaman'] }}</div>
                <div class="lbl">Total Peminjaman</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#dc3545;">{{ $stats['belum_kembali'] }}</div>
                <div class="lbl">Belum Dikembalikan</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#6f42c1;">{{ $stats['total_pengajuan'] }}</div>
                <div class="lbl">Total Pengajuan</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#17a2b8;">{{ $stats['total_bukutamu'] }}</div>
                <div class="lbl">Total Buku Tamu</div>
            </div>
            <div class="stat-mini">
                <div class="num" style="color:#e83e8c;">{{ $stats['total_radio'] }}</div>
                <div class="lbl">Total Registrasi Radio</div>
            </div>
        </div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #27ae60, #2ecc71);">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div>
                    <h5>1. Laporan Gudang IT</h5>
                    <p>Daftar seluruh stok barang, barang baru, dan mutasi stok gudang</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.gudang') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #e74c3c, #c0392b);">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <h5>2. Laporan Peminjaman</h5>
                    <p>Riwayat dan status peminjaman perangkat IT oleh karyawan</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.peminjaman') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #8e44ad, #9b59b6);">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h5>3. Laporan Pengajuan</h5>
                    <p>Riwayat pengajuan pembelian dan maintenance barang IT</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.pengajuan') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #e67e22, #f39c12);">
                    <i class="fas fa-tools"></i>
                </div>
                <div>
                    <h5>4. Laporan Barang Maintenance</h5>
                    <p>Daftar barang yang sedang dalam perbaikan/maintenance</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.maintenance') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #17a2b8, #20c997);">
                    <i class="fas fa-address-book"></i>
                </div>
                <div>
                    <h5>5. Laporan Buku Tamu</h5>
                    <p>Daftar kunjungan tamu dan riwayat registrasi</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.bukutamu') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #6f42c1, #e83e8c);">
                    <i class="fas fa-broadcast-tower"></i>
                </div>
                <div>
                    <h5>6. Laporan Registrasi Radio</h5>
                    <p>Daftar registrasi setting channel frekuensi radio</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.radio') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>

        <hr class="section-divider">
        <div class="section-title"><i class="fas fa-search me-2"></i>Laporan Inspeksi</div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #f39c12, #f1c40f);">
                    <i class="fas fa-car-battery"></i>
                </div>
                <div>
                    <h5>7. Laporan Inspeksi UPS</h5>
                    <p>Daftar inspeksi perangkat UPS - Total: {{ $stats['total_ups'] }} data</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.inspeksi.ups') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #3498db, #2980b9);">
                    <i class="fas fa-plug"></i>
                </div>
                <div>
                    <h5>8. Laporan Inspeksi Stavolt</h5>
                    <p>Daftar inspeksi perangkat Stavolt - Total: {{ $stats['total_stavolt'] }} data</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.inspeksi.stavolt') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #9b59b6, #8e44ad);">
                    <i class="fas fa-tv"></i>
                </div>
                <div>
                    <h5>9. Laporan Inspeksi Monitor / TV</h5>
                    <p>Daftar inspeksi monitor dan TV - Total: {{ $stats['total_monitor'] }} data</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.inspeksi.monitor') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>

        <div class="laporan-card">
            <div class="d-flex align-items-center gap-3">
                <div class="laporan-icon" style="background:linear-gradient(135deg, #1abc9c, #16a085);">
                    <i class="fas fa-video"></i>
                </div>
                <div>
                    <h5>10. Laporan Inspeksi Proyektor</h5>
                    <p>Daftar inspeksi proyektor - Total: {{ $stats['total_proyektor'] }} data</p>
                </div>
            </div>
            <a href="{{ route('pimpinan.laporan.inspeksi.proyektor') }}" class="btn-modern btn-view">
                <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
        </div>
    </div>
</div>
@endsection
