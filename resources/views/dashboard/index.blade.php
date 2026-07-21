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

    .module-card {
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        border-radius: 16px;
        border: none;
        padding: 1.25rem 1rem;
        height: 100%;
        transition: all 0.25s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        position: relative;
        overflow: hidden;
    }
    .module-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 60px; height: 60px;
        background: rgba(255,255,255,0.1);
        border-radius: 0 16px 0 60px;
    }
    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        color: inherit;
    }
    .module-card .mc-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 12px;
        background: rgba(255,255,255,0.2);
    }
    .module-card .mc-count {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 4px;
    }
    .module-card .mc-label {
        font-size: 0.82rem;
        font-weight: 600;
        opacity: 0.95;
    }
    .module-card .mc-sub {
        font-size: 0.72rem;
        opacity: 0.8;
        margin-top: 4px;
    }

    .mc-radio   { background: linear-gradient(135deg, #e74c3c, #c0392b); color: #fff; }
    .mc-inv     { background: linear-gradient(135deg, #ea6666, #f71414); color: #fff; }
    .mc-guest   { background: linear-gradient(135deg, #dc3545, #c0392b); color: #fff; }
    .mc-karyawan{ background: linear-gradient(135deg, #ff6b6b, #ee5a24); color: #fff; }
    .mc-ups     { background: linear-gradient(135deg, #e74c3c, #c0392b); color: #fff; }
    .mc-stavolt { background: linear-gradient(135deg, #ea6666, #d63031); color: #fff; }
    .mc-monitor { background: linear-gradient(135deg, #ff4757, #c0392b); color: #fff; }
    .mc-proyek  { background: linear-gradient(135deg, #ff7675, #d63031); color: #fff; }

    .section-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: #495057;
        margin-bottom: 1rem;
        padding-left: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #dee2e6;
    }

    .chart-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        height: 100%;
    }
    .chart-wrap {
        position: relative;
        height: 260px;
        max-width: 340px;
        margin: 0 auto;
    }
    .chart-empty {
        text-align: center;
        color: #6c757d;
        padding: 2.5rem 1rem;
    }
    .chart-legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 0.85rem;
    }
    .chart-legend-dot {
        width: 14px; height: 14px;
        border-radius: 4px;
        flex-shrink: 0;
    }

    .summary-stat {
        text-align: center;
        padding: 16px 8px;
        border-radius: 12px;
        background: #f8f9fa;
        transition: transform 0.2s;
    }
    .summary-stat:hover { transform: translateY(-2px); }
    .summary-stat .ss-num {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1.2;
    }
    .summary-stat .ss-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        margin-top: 2px;
    }

    .enhanced-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .enhanced-card .card-header-custom {
        padding: 16px 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .enhanced-card .card-header-custom h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .table-scroll {
        max-height: 260px;
        overflow-y: auto;
    }
    .table-scroll thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #f8f9fa;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .progress-inventaris {
        height: 6px;
        border-radius: 10px;
        background: rgba(255,255,255,0.3);
        margin-top: 8px;
        overflow: hidden;
    }
    .progress-inventaris-bar {
        height: 100%;
        background: rgba(255,255,255,0.9);
        border-radius: 10px;
        transition: width 0.6s ease;
    }
</style>

<div class="page-container">
    <div class="container-fluid">
        <div class="page-header" data-aos="fade-down">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">🏠 {{ Auth::user()->isPimpinan() ? 'Dashboard Pimpinan' : 'Dashboard ICT' }}</h2>
                    <p class="mb-0">{{ Auth::user()->isPimpinan() ? 'Ringkasan pengajuan dan peminjaman perangkat IT' : 'Ringkasan data seluruh modul sistem manajemen' }}</p>
                    <small>{{ now()->translatedFormat('l, d F Y') }}</small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('notifications.index') }}" class="btn btn-light btn-modern position-relative" style="border-radius:12px; padding:10px 20px; color:#333; font-weight:600;">
                        <i class="fas fa-bell me-1"></i> Notifikasi
                        @if(($unreadNotificationsCount ?? 0) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background:#ea6666; color:#fff; font-size:0.7rem;">
                                {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

    <div class="container-fluid" style="position: relative; z-index: 1;">

        {{-- ===== Module Cards ===== --}}
        <div class="section-label mt-3" data-aos="fade-up">📦 Modul Sistem</div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3" data-aos="fade-up">
                <a href="{{ route('registrasi.index') }}" class="module-card mc-radio">
                    <div class="mc-icon"><i class="fas fa-broadcast-tower"></i></div>
                    <div class="mc-count">{{ $jumlahRegistrasi }}</div>
                    <div class="mc-label">Registrasi Radio</div>
                </a>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="50">
                <a href="{{ route('inventaris.index') }}" class="module-card mc-inv">
                    <div class="mc-icon"><i class="fas fa-box"></i></div>
                    <div class="mc-count">{{ $jumlahInventaris }}</div>
                    <div class="mc-label">Inventaris IT</div>
                    <div class="mc-sub">{{ $inventarisDikembalikan }} dikembalikan &middot; {{ $inventarisBelum }} belum</div>
                    @if($jumlahInventaris > 0)
                        @php $pct = round(($inventarisDikembalikan / $jumlahInventaris) * 100); @endphp
                        <div class="progress-inventaris">
                            <div class="progress-inventaris-bar" style="width: {{ $pct }}%;"></div>
                        </div>
                        <div class="mc-sub">{{ $pct }}% selesai</div>
                    @endif
                </a>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('bukutamu.index') }}" class="module-card mc-guest">
                    <div class="mc-icon"><i class="fas fa-book"></i></div>
                    <div class="mc-count">{{ $jumlahBukuTamu }}</div>
                    <div class="mc-label">Buku Tamu</div>
                </a>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                <a href="{{ route('karyawan.index') }}" class="module-card mc-karyawan">
                    <div class="mc-icon"><i class="fas fa-users"></i></div>
                    <div class="mc-count">{{ $jumlahKaryawan }}</div>
                    <div class="mc-label">Karyawan IT</div>
                </a>
            </div>
        </div>

        <div class="section-label" data-aos="fade-up">🔍 Inspeksi Perangkat</div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('inspeksiups.index') }}" class="module-card mc-ups">
                    <div class="mc-icon"><i class="fas fa-battery-full"></i></div>
                    <div class="mc-count">{{ $jumlahInspeksiUps }}</div>
                    <div class="mc-label">Inspeksi UPS</div>
                </a>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="250">
                <a href="{{ route('inspeksistavolt.index') }}" class="module-card mc-stavolt">
                    <div class="mc-icon"><i class="fas fa-bolt"></i></div>
                    <div class="mc-count">{{ $jumlahInspeksiStavolt }}</div>
                    <div class="mc-label">Inspeksi Stavolt</div>
                </a>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('inspeksimonitor.index') }}" class="module-card mc-monitor">
                    <div class="mc-icon"><i class="fas fa-tv"></i></div>
                    <div class="mc-count">{{ $jumlahInspeksiMonitor }}</div>
                    <div class="mc-label">Monitor / TV</div>
                </a>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="350">
                <a href="{{ route('inspeksiproyektor.index') }}" class="module-card mc-proyek">
                    <div class="mc-icon"><i class="fas fa-video"></i></div>
                    <div class="mc-count">{{ $jumlahInspeksiProyektor }}</div>
                    <div class="mc-label">Proyektor</div>
                </a>
            </div>
        </div>

        {{-- ===== Chart + Summary ===== --}}
        <div class="section-label" data-aos="fade-up">📊 Statistik Inventaris</div>
        <div class="row g-3 mb-4">
            <div class="col-lg-5" data-aos="fade-up">
                <div class="chart-card">
                    <h6 class="fw-bold mb-1">Status Peminjaman</h6>
                    <small class="text-muted">Perbandingan status perangkat IT</small>
                    @if($chartStats['total'] > 0)
                        <div class="chart-wrap mt-3">
                            <canvas id="inventarisChart"></canvas>
                        </div>
                    @else
                        <div class="chart-empty mt-3">Belum ada data inventaris.</div>
                    @endif
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                <div class="chart-card">
                    <h6 class="fw-bold mb-3">Ringkasan Inventaris</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-3">
                            <div class="summary-stat">
                                <div class="ss-num" style="color:#3b82f6;">{{ $chartStats['total'] }}</div>
                                <div class="ss-label">Total</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="summary-stat">
                                <div class="ss-num" style="color:#3b82f6;">{{ $chartStats['pending'] }}</div>
                                <div class="ss-label">Pending</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="summary-stat">
                                <div class="ss-num" style="color:#3b82f6;">{{ $chartStats['dikembalikan'] }}</div>
                                <div class="ss-label">Dikembalikan</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="summary-stat">
                                <div class="ss-num" style="color:#3b82f6;">{{ $chartStats['belum'] }}</div>
                                <div class="ss-label">Belum</div>
                            </div>
                        </div>
                    </div>
                    @if($chartStats['total'] > 0)
                        <hr style="margin: 0.5rem 0;">
                        <div class="chart-legend-item">
                            <span class="chart-legend-dot" style="background:#ffc107;"></span>
                            <span><strong>Pending</strong> — {{ $chartStats['pending'] }} unit ({{ round($chartStats['pending'] / $chartStats['total'] * 100) }}%)</span>
                        </div>
                        <div class="chart-legend-item">
                            <span class="chart-legend-dot" style="background:#28a745;"></span>
                            <span><strong>Dikembalikan</strong> — {{ $chartStats['dikembalikan'] }} unit ({{ round($chartStats['dikembalikan'] / $chartStats['total'] * 100) }}%)</span>
                        </div>
                        <div class="chart-legend-item">
                            <span class="chart-legend-dot" style="background:#dc3545;"></span>
                            <span><strong>Belum Dikembalikan</strong> — {{ $chartStats['belum'] }} unit ({{ round($chartStats['belum'] / $chartStats['total'] * 100) }}%)</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== Recent Tables ===== --}}
        <div class="section-label" data-aos="fade-up">📋 Data Terbaru</div>
        <div class="row g-3 mb-4">
            <div class="col-lg-6" data-aos="fade-up">
                <div class="card enhanced-card h-100">
                    <div class="card-header-custom">
                        <h6><i class="fas fa-broadcast-tower me-2 text-danger"></i>Registrasi Terbaru</h6>
                        <a href="{{ route('registrasi.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">Lihat semua</a>
                    </div>
                    <div class="table-scroll">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Perusahaan</th>
                                    <th>No Lambung</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestRegistrasi as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->perusahaan }}</td>
                                    <td><code>{{ $item->nomor_lambung }}</code></td>
                                    <td><small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card enhanced-card h-100">
                    <div class="card-header-custom">
                        <h6><i class="fas fa-book me-2 text-info"></i>Buku Tamu Terbaru</h6>
                        <a href="{{ route('bukutamu.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">Lihat semua</a>
                    </div>
                    <div class="table-scroll">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Instansi</th>
                                    <th>PIC</th>
                                    <th>Keperluan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestBukuTamu as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td><small>{{ $item->instansi }}</small></td>
                                    <td><small>{{ $item->pic->nama ?? '-' }}</small></td>
                                    <td><small class="text-muted">{{ Str::limit($item->keperluan, 35) }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@if($chartStats['total'] > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({ duration: 700, once: true, offset: 60 });
        }

        @if($chartStats['total'] > 0)
        const stats = @json($chartStats);
        const ctx = document.getElementById('inventarisChart');
        if (ctx && typeof Chart !== 'undefined') {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Dikembalikan', 'Belum Dikembalikan'],
                    datasets: [{
                        data: [stats.pending, stats.dikembalikan, stats.belum],
                        backgroundColor: ['#ffc107', '#28a745', '#dc3545'],
                        borderWidth: 3,
                        borderColor: '#fff',
                        hoverBorderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { size: 13, weight: '600' },
                            bodyFont: { size: 12 },
                            callbacks: {
                                label: function(context) {
                                    const total = stats.total || 1;
                                    const value = context.parsed;
                                    const pct = Math.round((value / total) * 100);
                                    return context.label + ': ' + value + ' unit (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }
        @endif
    });
</script>
@endsection
