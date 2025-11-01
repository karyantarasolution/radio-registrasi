@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    <style>
        .text-justify {
            text-align: justify;
        }

        /* Enhanced Card Styling */
        .enhanced-card {
            border-radius: 15px;
            border: none;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #ffffff 0%, #ffffffff 100%);
        }

        .enhanced-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }

        /* Gradient Cards for Stats */
        .stat-card-1 {
            background: linear-gradient(135deg, #ea6666ff 0%, #df4c4cff 100%);
            color: white;
        }

        .stat-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .stat-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .stat-card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #11caa8ff 100%);
            color: white;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #f58585ff 0%, #ff0303ff 100%);
            border-radius: 20px;
            color: black;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        /* Safety Status Indicator */
        .safety-indicator {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        .safety-safe { background-color: #28a745; }
        .safety-warning { background-color: #ffc107; }
        .safety-danger { background-color: #dc3545; }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
        }

        /* Enhanced Table */
        .table-scroll {
            max-height: 320px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .table-scroll table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
            margin-bottom: 0;
        }

        .table-scroll thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            padding: 15px;
        }

        .table-scroll tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        /* Progress Bar */
        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background-color: rgba(255,255,255,0.3);
            overflow: hidden;
        }

        .progress-bar-custom {
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            transition: width 1s ease-in-out;
        }

        /* Weather Widget */
        .weather-widget {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            border-radius: 15px;
            color: white;
            padding: 1.5rem;
        }

        /* Quick Actions */
        .quick-action-btn {
            border-radius: 15px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            padding: 1rem;
            text-decoration: none;
            display: block;
        }

        .quick-action-btn:hover {
            transform: translateY(-3px);
            border-color: #667eea;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
    </style>

    {{-- Welcome Banner --}}
        <div class="welcome-banner" data-aos="fade-down" data-aos-duration="1000">
        <div class="row align-items-center">
            <div class="col-md-8 d-flex align-items-center">
                <!-- Logo -->
                <img src="{{ asset('images/LogoPPA.png') }}" 
                    alt="Logo PPA" 
                    style="height: 100px; margin-right: 15px;">
                
                <!-- Teks -->
                <div>
                    <h2 class="fw-bold mb-2">PT. Putra Perkasa Abadi</h2>
                    <p class="mb-0">Dashboard Keselamatan & Kesehatan Kerja - Monitoring Real-time</p>
                    <small class="opacity-75">Terakhir diperbarui: {{ date('d F Y, H:i') }} WITA</small>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="safety-indicator safety-safe"></div>
                <span class="ms-2">Status: AMAN</span>
            </div>
        </div>
    </div>


    {{-- Statistics Cards Row --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="100">
            <div class="card enhanced-card stat-card-1 text-center">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total Registrasi</h6>
                            <h2 class="fw-bold mb-0">{{ $jumlahRegistrasi }}</h2>
                        </div>
                        <div class="fs-1 opacity-75">📊</div>
                    </div>
                    <div class="progress-custom mt-3">
                        <div class="progress-bar-custom" style="width: 75%"></div>
                    </div>
                    <small class="opacity-75">Jumlah Seluruh Registrasi</small> 
                </div>
            </div>
        </div>

    {{-- Total Inventaris --}}
    <div class="col-lg-3 col-md-6 mb-3" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="150">
        <div class="card enhanced-card stat-card-3 text-center">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title opacity-75">Total Inventaris</h6>
                        
                    </div>
                    <div class="fs-1 opacity-75">📻</div>
                </div>
                <div class="progress-custom mt-3">
                    <div class="progress-bar-custom" style="width: 60%"></div>
                </div>
                <small class="opacity-75">Jumlah seluruh perangkat</small>
            </div>
        </div>
    </div>


        <div class="col-lg-3 col-md-6 mb-3" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="200">
            <div class="card enhanced-card stat-card-2 text-center">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Hari Tanpa Kecelakaan</h6>
                            <h2 class="fw-bold mb-0">{{ rand(45, 120) }}</h2>
                        </div>
                        <div class="fs-1 opacity-75">🏆</div>
                    </div>
                    <div class="progress-custom mt-3">
                        <div class="progress-bar-custom" style="width: 90%"></div>
                    </div>
                    <small class="opacity-75">Target: 365 hari</small>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-6 mb-3" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="400">
            <div class="card enhanced-card stat-card-4 text-center">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Compliance Rate</h6>
                            <h2 class="fw-bold mb-0">{{ rand(85, 98) }}%</h2>
                        </div>
                        <div class="fs-1 opacity-75">✅</div>
                    </div>
                    <div class="progress-custom mt-3">
                        <div class="progress-bar-custom" style="width: 92%"></div>
                    </div>
                    <small class="opacity-75">Sangat Baik</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions & Weather Row --}}
    <div class="row mb-4">
        <div class="col-lg-8 mb-3">
            <div class="card enhanced-card" data-aos="fade-right" data-aos-duration="1000">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">⚡ Quick Actions</h5>
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <a href="#" class="quick-action-btn bg-light text-center text-decoration-none">
                                <div class="fs-2 mb-2">🚨</div>
                                <small class="fw-bold text-dark">Laporkan Insiden</small>
                                <div class="notification-badge">3</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="#" class="quick-action-btn bg-light text-center text-decoration-none">
                                <div class="fs-2 mb-2">📋</div>
                                <small class="fw-bold text-dark">Safety Checklist</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="#" class="quick-action-btn bg-light text-center text-decoration-none">
                                <div class="fs-2 mb-2">🎓</div>
                                <small class="fw-bold text-dark">Pelatihan K3</small>
                                <div class="notification-badge">2</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="#" class="quick-action-btn bg-light text-center text-decoration-none">
                                <div class="fs-2 mb-2">📞</div>
                                <small class="fw-bold text-dark">Emergency</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3"> 
    <div class="weather-widget" data-aos="fade-left" data-aos-duration="1000">
        <h6 class="fw-bold mb-3">🌤️ Cuaca Hari Ini</h6>
        @if(!empty($weatherData) && isset($weatherData['main']))
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">{{ round($weatherData['main']['temp']) }}°C</h3>
                    <small>{{ $weatherData['name'] }}</small>
                </div>
                <div class="text-end">
                    <div class="fs-1">
                        @php
                            $icon = $weatherData['weather'][0]['icon'];
                        @endphp
                        <img src="http://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="icon">
                    </div>
                    <small>{{ ucfirst($weatherData['weather'][0]['description']) }}</small>
                </div>
            </div>
            <hr class="my-3 opacity-50">
            <div class="row text-center">
                <div class="col-4">
                    <small>Kelembaban</small><br>
                    <strong>{{ $weatherData['main']['humidity'] }}%</strong>
                </div>
                <div class="col-4">
                    <small>Angin</small><br>
                    <strong>{{ $weatherData['wind']['speed'] }} km/h</strong>
                </div>
                <div class="col-4">
                    <small>Tekanan</small><br>
                    <strong>{{ $weatherData['main']['pressure'] }} hPa</strong>
                </div>
            </div>
        @else
            <p>Data cuaca tidak tersedia.</p> 
        @endif
    </div>
</div>



    {{-- Safety Tips & Announcements --}}
    <div class="row mb-4">
        <div class="col-lg-6 mb-3">
            <div class="card enhanced-card" data-aos="fade-up" data-aos-duration="1000">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">💡 Safety Tip of the Day</h5>
                    <div class="alert alert-info border-0 rounded-3" style="background: linear-gradient(135deg, #a8edea 0%, #80fde2ff 100%);">
                        <div class="d-flex align-items-center">
                            <div class="fs-1 me-3">🦺</div>
                            <div>
                                <strong>Selalu Gunakan APD Lengkap!</strong><br>
                                <small>Helm, sarung tangan, sepatu safety, dan kacamata pelindung wajib digunakan di area kerja.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="card enhanced-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">📢 Pengumuman Terbaru</h5>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <strong class="text-primary">Pelatihan K3 Wajib</strong>
                                <small class="text-muted">2 jam lalu</small>
                            </div>
                            <small>Pelatihan untuk semua karyawan baru dimulai Senin depan.</small>
                        </div>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <strong class="text-success">Safety Award</strong>
                                <small class="text-muted">1 hari lalu</small>
                            </div>
                            <small>Selamat kepada Tim Site ADW atas pencapaian 100 hari tanpa kecelakaan!</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Company Profile --}}
    <div class="card enhanced-card mb-5" data-aos="fade-right" data-aos-duration="1200">
        <div class="card-body">
            <h4 class="fw-bold mb-4">🏢 Profil Perusahaan</h4>
            <div class="row">
                <div class="col-lg-8">
                    <p class="text-justify">
                        <strong>PT. Putra Perkasa Abadi</strong> adalah sebagai perusahaan rental alat berat. 
                        Dengan pemahaman yang mendalam mengenai industri pertambangan serta asimiliasi budaya kerja yang baik dengan para customernya,
                        PPA kemudian menjadi perusahaan jasa kontraktor pertambangan pada tahun 2005 hingga detik ini. 
                        Pada tahun 2024 ini, PPA dipercaya untuk mengerjakan 11 Jobsite di Kalimantan, Sulawesi, dan Sumatera.
                    </p>
                </div>
                <div class="col-lg-4">
                    <div class="bg-light rounded-3 p-3">
                        <h6 class="fw-bold">📊 Statistik Perusahaan</h6>
                        <ul class="list-unstyled mb-0">
                            <li>👥 <strong>12.000+</strong> Karyawan</li>
                            <li>🚛 <strong>2.000+</strong> Unit Alat Berat</li>
                            <li>🏗️ <strong>11</strong> Jobsite Aktif</li>
                            <li>🥉 <strong>Peringkat 3</strong> Kontraktor Tambang Indonesia</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="border rounded-3 p-3 bg-light">
                        <h6 class="fw-bold text-primary">ℹ️   Informasi Perusahaan</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent px-0"><b>Berdiri:</b> 2003</li>
                            <li class="list-group-item bg-transparent px-0"><b>Alamat:</b> RF69+WQ5, Maburai, Kec. Murung Pudak, Kabupaten Tabalong, Kalimantan Selatan 71571</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded-3 p-3 bg-light">
                        <h6 class="fw-bold text-success">🎯 Visi & Misi</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent px-0"><b>Visi:</b> Menjadi perusahaan jasa pertambangan terdepan di Indonesia</li>
                            <li class="list-group-item bg-transparent px-0"><b>Misi:</b> Memberikan pelayanan terbaik, mengutamakan keselamatan, serta menjaga kelestarian lingkungan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- K3 Guidelines --}}
    <div class="card enhanced-card mb-5" data-aos="fade-left" data-aos-duration="1200">
        <div class="card-body">
            <h4 class="fw-bold mb-4">⚠️ Keselamatan & Kesehatan Kerja (K3)</h4>
            <div class="row">
                <div class="col-lg-8">
                    <p>
                        Kami berkomitmen untuk menjaga keselamatan karyawan, mitra kerja, serta lingkungan kerja.
                        Berikut adalah pedoman K3 yang wajib ditaati:
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item border-0 px-0">✅ Gunakan Alat Pelindung Diri (APD) setiap saat.</li>
                                <li class="list-group-item border-0 px-0">✅ Ikuti prosedur kerja standar (SOP).</li>
                                <li class="list-group-item border-0 px-0">✅ Periksa peralatan secara rutin.</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item border-0 px-0">✅ Laporkan kondisi berbahaya atau kecelakaan segera.</li>
                                <li class="list-group-item border-0 px-0">✅ Utamakan budaya <i>Safety First</i>.</li>
                                <li class="list-group-item border-0 px-0">🎯 <b>Tujuan:</b> Zero Accident & kesehatan seluruh pekerja.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                            <div>
                                <div class="fs-1">🛡️</div>
                                <div class="fw-bold">SAFETY</div>
                                <div class="small">FIRST</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6 class="text-success fw-bold">Status Keselamatan</h6>
                            <span class="badge bg-success fs-6">AMAN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Latest Registration Data --}}
    <div class="card enhanced-card mb-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">📋 Data Registrasi Terbaru</h5>
                <div>
                    <span class="badge bg-primary me-2">Live Data</span>
                    <button class="btn btn-sm btn-outline-primary" onclick="refreshTable()">
                        🔄 Refresh
                    </button>
                </div>
            </div>

            <div class="table-scroll">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Perusahaan</th>
                            <th class="fw-bold">No Lambung</th>
                            <th class="fw-bold">ID PTT</th>
                            <th class="fw-bold">Tanggal</th>
                            <th class="fw-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestRegistrasi as $index => $item)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $index + 1 }}</span></td>
                                <td class="fw-bold">{{ $item->perusahaan }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $item->nomor_lambung }}</span>
                                </td>
                                <td>{{ $item->id_ptt }}</td>
                                <td>
                                    <small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small><br>
                                    <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-success">Aktif</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Menampilkan data terbaru - Diperbarui otomatis setiap 30 detik</small>
                <a href="{{ route('registrasi.index') }}" class="btn btn-primary">
                    🔎 Lihat Semua Data
                </a>
            </div>
        </div>
    </div>

</div>

<script>
    // Refresh table function
    function refreshTable() {
        // Add loading animation or actual refresh logic here
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '⏳ Loading...';
        button.disabled = true;
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    }

    // Auto refresh every 30 seconds
    setInterval(() => {
        // Add actual refresh logic here
        console.log('Auto refreshing data...');
    }, 30000);

    // Initialize AOS animations
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    });

    
</script>

@endsection