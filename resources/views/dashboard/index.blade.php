@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
            border-radius: 20px;
            color: white;
            padding: 1.75rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }
        .module-card {
            display: block;
            text-decoration: none;
            color: inherit;
            border-radius: 15px;
            border: none;
            padding: 1.25rem;
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
            color: inherit;
        }
        .module-card .count {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.1;
        }
        .module-card .label {
            font-size: 0.85rem;
            font-weight: 600;
            opacity: 0.95;
        }
        .module-card .sub {
            font-size: 0.75rem;
            opacity: 0.85;
            margin-top: 0.35rem;
        }
        .stat-card-1 { background: linear-gradient(135deg, #ea6666 0%, #df4c4c 100%); color: white; }
        .stat-card-2 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .stat-card-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
        .stat-card-4 { background: linear-gradient(135deg, #43e97b 0%, #11caa8 100%); color: white; }
        .stat-card-5 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
        .stat-card-6 { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }
        .stat-card-7 { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); color: white; }
        .stat-card-8 { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; }
        .enhanced-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .table-scroll {
            max-height: 280px;
            overflow-y: auto;
            border-radius: 10px;
        }
        .table-scroll thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f8f9fa;
        }
        .progress-inventaris {
            height: 6px;
            border-radius: 10px;
            background: rgba(255,255,255,0.35);
            margin-top: 8px;
            overflow: hidden;
        }
        .progress-inventaris-bar {
            height: 100%;
            background: rgba(255,255,255,0.9);
            border-radius: 10px;
        }
        .chart-card {
            background: #fff;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .chart-wrap {
            position: relative;
            height: 280px;
            max-width: 380px;
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
            gap: 8px;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }
        .chart-legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
    </style>

    <div class="dashboard-header" data-aos="fade-down">
        <div class="row align-items-center">
            <div class="col-md-8 d-flex align-items-center">
                <img src="{{ asset('images/LogoPPA.png') }}" alt="Logo PPA" style="height: 70px; margin-right: 15px;">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard ICT</h2>
                    <p class="mb-0 opacity-90">Ringkasan data seluruh modul sistem</p>
                    <small class="opacity-75">Diperbarui: {{ date('d F Y, H:i') }} WITA</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu modul --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3" data-aos="fade-up">
            <a href="{{ route('registrasi.index') }}" class="module-card stat-card-1">
                <div class="count">{{ $jumlahRegistrasi }}</div>
                <div class="label">Registrasi Radio</div>
            </a>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="50">
            <a href="{{ route('inventaris.index') }}" class="module-card stat-card-2">
                <div class="count">{{ $jumlahInventaris }}</div>
                <div class="label">Inventaris IT</div>
                <div class="sub">{{ $inventarisDikembalikan }} dikembalikan · {{ $inventarisBelum }} belum</div>
                @if($jumlahInventaris > 0)
                    @php $pct = round(($inventarisDikembalikan / $jumlahInventaris) * 100); @endphp
                    <div class="progress-inventaris">
                        <div class="progress-inventaris-bar" style="width: {{ $pct }}%;"></div>
                    </div>
                    <div class="sub">{{ $pct }}% dikembalikan</div>
                @endif
            </a>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('bukutamu.index') }}" class="module-card stat-card-3">
                <div class="count">{{ $jumlahBukuTamu }}</div>
                <div class="label">Buku Tamu</div>
            </a>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="150">
            <a href="{{ route('karyawan.index') }}" class="module-card stat-card-4">
                <div class="count">{{ $jumlahKaryawan }}</div>
                <div class="label">Karyawan IT</div>
            </a>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('inspeksiups.index') }}" class="module-card stat-card-5">
                <div class="count">{{ $jumlahInspeksiUps }}</div>
                <div class="label">Inspeksi UPS</div>
            </a>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="250">
            <a href="{{ route('inspeksistavolt.index') }}" class="module-card stat-card-6">
                <div class="count">{{ $jumlahInspeksiStavolt }}</div>
                <div class="label">Inspeksi Stavolt</div>
            </a>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('inspeksimonitor.index') }}" class="module-card stat-card-7">
                <div class="count">{{ $jumlahInspeksiMonitor }}</div>
                <div class="label">Inspeksi Monitor / TV</div>
            </a>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="350">
            <a href="{{ route('inspeksiproyektor.index') }}" class="module-card stat-card-8">
                <div class="count">{{ $jumlahInspeksiProyektor }}</div>
                <div class="label">Inspeksi Proyektor</div>
            </a>
        </div>
    </div>

    {{-- Diagram status peminjaman inventaris --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-5" data-aos="fade-up">
            <div class="chart-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Diagram Status Peminjaman</h5>
                    <a href="{{ route('inventaris.index') }}" class="btn btn-sm btn-outline-danger">Kelola inventaris</a>
                </div>
                <p class="text-muted small mb-3">Perbandingan status peminjaman perangkat IT</p>
                @if($chartStats['total'] > 0)
                    <div class="chart-wrap">
                        <canvas id="inventarisChart"></canvas>
                    </div>
                @else
                    <div class="chart-empty">Belum ada data inventaris untuk ditampilkan.</div>
                @endif
            </div>
        </div>
        <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
            <div class="chart-card h-100">
                <h5 class="fw-bold mb-3">Ringkasan Inventaris</h5>
                <div class="row g-3">
                    <div class="col-3 text-center">
                        <div class="fs-2 fw-bold text-primary">{{ $chartStats['total'] }}</div>
                        <small class="text-muted">Total</small>
                    </div>
                    <div class="col-3 text-center">
                        <div class="fs-2 fw-bold text-warning">{{ $chartStats['pending'] }}</div>
                        <small class="text-muted">Pending</small>
                    </div>
                    <div class="col-3 text-center">
                        <div class="fs-2 fw-bold text-success">{{ $chartStats['dikembalikan'] }}</div>
                        <small class="text-muted">Dikembalikan</small>
                    </div>
                    <div class="col-3 text-center">
                        <div class="fs-2 fw-bold text-danger">{{ $chartStats['belum'] }}</div>
                        <small class="text-muted">Belum dikembalikan</small>
                    </div>
                </div>
                @if($chartStats['total'] > 0)
                    <hr>
                    <div class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#ffc107;"></span>
                        <span>Pending — {{ $chartStats['pending'] }} unit ({{ round($chartStats['pending'] / $chartStats['total'] * 100) }}%)</span>
                    </div>
                    <div class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#28a745;"></span>
                        <span>Sudah Dikembalikan — {{ $chartStats['dikembalikan'] }} unit ({{ round($chartStats['dikembalikan'] / $chartStats['total'] * 100) }}%)</span>
                    </div>
                    <div class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#dc3545;"></span>
                        <span>Belum Dikembalikan — {{ $chartStats['belum'] }} unit ({{ round($chartStats['belum'] / $chartStats['total'] * 100) }}%)</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabel terbaru --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-6" data-aos="fade-up">
            <div class="card enhanced-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Registrasi Terbaru</h5>
                        <a href="{{ route('registrasi.index') }}" class="btn btn-sm btn-outline-danger">Lihat semua</a>
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
                                    <td>{{ $item->nomor_lambung }}</td>
                                    <td><small>{{ $item->created_at->format('d/m/Y') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card enhanced-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Buku Tamu Terbaru</h5>
                        <a href="{{ route('bukutamu.index') }}" class="btn btn-sm btn-outline-danger">Lihat semua</a>
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
                                    <td>{{ $item->instansi }}</td>
                                    <td><small>{{ $item->pic->nama ?? '-' }}</small></td>
                                    <td><small>{{ Str::limit($item->keperluan, 40) }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Belum ada data</td>
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
            AOS.init({ duration: 800, once: true, offset: 80 });
        }

        @if($chartStats['total'] > 0)
        const stats = @json($chartStats);
        const ctx = document.getElementById('inventarisChart');
        if (ctx && typeof Chart !== 'undefined') {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Sudah Dikembalikan', 'Belum Dikembalikan'],
                    datasets: [{
                        data: [stats.pending, stats.dikembalikan, stats.belum],
                        backgroundColor: ['#ffc107', '#28a745', '#dc3545'],
                        borderWidth: 2,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = stats.total || 1;
                                    const value = context.parsed;
                                    const pct = Math.round((value / total) * 100);
                                    return context.label + ': ' + value + ' (' + pct + '%)';
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
