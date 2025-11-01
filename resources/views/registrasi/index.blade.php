@extends('layouts.app')

@section('content')
<style>
    /* Enhanced container styling */
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }

    /* Header section with gradient background */
    .page-header {
        background: linear-gradient(135deg, #ea6666ff 0%, #f71414ff 100%);
        color: white;
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
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
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Statistics cards */
    .stats-container {
        margin-bottom: 30px;
    }

    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #ea6666ff 0%, #f71414ff 100%);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        opacity: 0.8;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #667feaff;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Enhanced table styling */
    .table-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        position: relative;
    }

    .table-header {
        background: linear-gradient(135deg, #ea6666ff 0%, #f71414ff 100%);
        color: white;
        padding: 20px 25px;
        margin: 0;
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .table-title {
        font-size: 1.3rem;
        font-weight: bold;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-container {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 15px 20px;
        margin: 0 25px 20px 25px;
    }

    .search-input {
        background: white;
        border: none;
        border-radius: 10px;
        padding: 10px 15px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
    }

    .table-custom {
        margin: 0;
        background: white;
    }

    .table-custom thead {
        background: linear-gradient(135deg, #ea6666ff 0%, #f71414ff 100%);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table-custom th {
        font-weight: 600;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 15px 20px;
        color: black;
        border: none;
        text-align: center;
    }

    .table-custom td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
        text-align: center;
    }

    .table-custom tbody tr {
        transition: all 0.3s ease;
        position: relative;
    }

    .table-custom tbody tr:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .table-custom tbody tr:nth-child(even) {
        background-color: #f8f9fc;
    }

    /* Enhanced buttons */
    .btn-modern {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-add {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(67, 233, 123, 0.3);
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(67, 233, 123, 0.4);
        color: white;
    }

    .btn-pdf {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
    }

    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        color: white;
    }

    /* ID Badge styling */
    .id-badge {
        background: linear-gradient(135deg, #ea6666ff 0%, #f71414ff 100%);  
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.85rem;
        display: inline-block;
        min-width: 40px;
        text-align: center;
    }

    /* Company name styling */
    .company-name {
        font-weight: 600;
        color: #2c3e50;
    }

    /* Vehicle number styling */
    .vehicle-number {
        background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
        color: #2d3436;
        padding: 5px 10px;
        border-radius: 8px;
        font-weight: bold;
        font-family: 'Courier New', monospace;
        display: inline-block;
    }

    /* Date styling */
    .date-text {
        color: #74b9ff;
        font-weight: 500;
    }

    /* Empty state styling */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #74b9ff;
    }

    .empty-icon {
        font-size: 4rem;
        opacity: 0.5;
        margin-bottom: 20px;
    }

    /* Responsive table container */
    .table-responsive-custom {
        max-height: 600px;
        overflow-y: auto;
        overflow-x: auto;
    }

    .table-responsive-custom::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .table-responsive-custom::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 10px;
    }

    .table-responsive-custom::-webkit-scrollbar-track {
        background: #f1f3f4;
        border-radius: 10px;
    }

    /* Action buttons container */
    .table-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    /* Loading animation */
    .loading-spinner { 
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="page-container">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header" data-aos="fade-down" data-aos-duration="1000">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-2">📻 Sistem Registrasi Radio</h2>
                    <p class="mb-0 opacity-90">Kelola data registrasi radio komunikasi untuk operasional yang aman</p>
                    <small class="opacity-75">PT. Putra Perkasa Abadi </small>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('registrasi.create') }}" class="btn btn-add btn-modern">
                        <i class="fas fa-plus me-2"></i>Tambah Registrasi Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-container" data-aos="fade-up" data-aos-duration="1000">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-number">{{ count($data) }}</div>
                        <div class="stat-label">Total Registrasi</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-number">{{ count($data->where('created_at', '>=', now()->subDays(30))) }}</div>
                        <div class="stat-label">Bulan Ini</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon">📅</div>
                        <div class="stat-number">{{ count($data->where('created_at', '>=', now()->startOfDay())) }}</div>
                        <div class="stat-label">Hari Ini</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon">🏢</div>
                        <div class="stat-number">{{ $data->pluck('perusahaan')->unique()->count() }}</div>
                        <div class="stat-label">Perusahaan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="table-card" data-aos="fade-up" data-aos-duration="1200">
            <!-- Table Header -->
            <div class="table-header">
                <h4 class="table-title">
                    <span>📋</span>
                    <span>Data Registrasi Radio</span>
                </h4>
                <div class="d-flex align-items-center">
                    <div class="loading-spinner" id="loadingSpinner"></div>
                    <small class="table-subtitle">Total: {{ count($data) }} registrasi</small>
                </div>
            </div>

            <!-- Search Container -->
            <div class="search-container">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="search-input" placeholder="🔍 Cari berdasarkan perusahaan, nomor lambung, atau ID PTT..." id="searchInput">
                    </div>
                    <div class="col-md-3">
                        <select class="search-input" id="companyFilter">
                            <option value="">Semua Perusahaan</option>
                            @foreach($data->pluck('perusahaan')->unique() as $company)
                                <option value="{{ $company }}">{{ $company }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                       <a href="{{ route('registrasi.export.all') }}"
                        class="btn btn-modern"
                        style="background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); color:white">📥 Export Semua Excel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-responsive-custom">
                <table class="table table-custom" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th style="width: 200px;">Perusahaan</th>
                            <th style="width: 150px;">No Lambung</th>
                            <th style="width: 150px;">ID PTT</th>
                            <th style="width: 150px;">Tanggal</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $d)
                            <tr class="data-row">
                                <td>
                                    <span class="id-badge">{{ $d->id }}</span>
                                </td>
                                <td>
                                    <span class="company-name">{{ $d->perusahaan }}</span>
                                </td>
                                <td>
                                    <span class="vehicle-number">{{ $d->nomor_lambung }}</span>
                                </td>
                                <td>
                                    <strong>{{ $d->id_ptt }}</strong>
                                </td>
                                <td>
                                    @if($d->created_at)
                                        <small class="text-muted">{{ $d->created_at->timezone('Asia/Makassar')->format('d/m/Y') }}</small><br>
                                        <small class="text-muted">{{ $d->created_at->timezone('Asia/Makassar')->format('H:i:s') }}</small>
                                    @else
                                        <span class="date-text">-</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                    {{-- Tombol PDF --}}
                                    <button class="btn btn-pdf btn-modern btn-sm px-2 py-1"
                                        onclick="generatePDF(event, '{{ $d->id }}')">
                                        <i class="fas fa-file-pdf me-1"></i>PDF
                                    </button>

                                    {{-- Tombol Excel --}}
                                    <button class="btn btn-modern btn-sm px-2 py-1"
                                        style="background: linear-gradient(135deg,#74b9ff,#0984e3); color:white"
                                        onclick="exportExcel('{{ $d->id }}')">
                                        <i class="fas fa-file-excel me-1"></i>Excel
                                    </button>

                                    {{-- Tombol CSV --}}
                                    <button class="btn btn-modern btn-sm px-2 py-1"
                                        style="background: linear-gradient(135deg,#00b894,#00cec9); color:white"
                                        onclick="exportCSV('{{ $d->id }}')">
                                        <i class="fas fa-file-csv me-1"></i>CSV
                                    </button>
                                </div>

                                </td>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <h5>Belum Ada Data Registrasi</h5>
                                    <p class="text-muted">Silakan tambah registrasi radio baru untuk memulai</p>
                                    <a href="{{ route('registrasi.create') }}" class="btn btn-add btn-modern">
                                        <i class="fas fa-plus me-2"></i>Tambah Sekarang
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Actions -->
            <div class="table-actions">
                <div>
                    <small class="text-muted">
                        <span id="totalRecords">{{ count($data) }}</span> registrasi ditemukan
                    </small>
                </div>
                <div>
                    <button class="btn btn-modern me-2" onclick="refreshData()" style="background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%); color: white;">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const companyFilter = document.getElementById('companyFilter').value.toLowerCase();
        filterTable(searchTerm, companyFilter);
    });

    document.getElementById('companyFilter').addEventListener('change', function() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const companyFilter = this.value.toLowerCase();
        filterTable(searchTerm, companyFilter);
    });

    function filterTable(searchTerm, companyFilter) {
        const rows = document.querySelectorAll('.data-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const company = row.cells[1].textContent.toLowerCase();
            const lambung = row.cells[2].textContent.toLowerCase();
            const idPtt = row.cells[3].textContent.toLowerCase();

            const matchesSearch = company.includes(searchTerm) || 
                                lambung.includes(searchTerm) || 
                                idPtt.includes(searchTerm);
            const matchesCompany = companyFilter === '' || company.includes(companyFilter);

            if (matchesSearch && matchesCompany) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('totalRecords').textContent = visibleCount;
    }

    // PDF generation with loading
        function generatePDF(event, id) {
        const button = event.currentTarget;
        const originalText = button.innerHTML;

        button.innerHTML = '<div class="loading-spinner" style="display: inline-block;"></div>Loading...';
        button.disabled = true;

        setTimeout(() => {
            window.open("{{ route('registrasi.report', ':id') }}".replace(':id', id), '_blank');
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
        }


    // Export functionality
        function exportData() {
        const button = event.currentTarget;
        const originalText = button.innerHTML;
        
        button.innerHTML = '<div class="loading-spinner" style="display: inline-block;"></div>Exporting...';
        button.disabled = true;

        setTimeout(() => {
            window.location.href = "{{ route('registrasi.export.all') }}"; // ✅ route benar
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    }



    // Refresh data
    function refreshData() {
        const spinner = document.getElementById('loadingSpinner');
        spinner.style.display = 'inline-block';
        
        setTimeout(() => {
            location.reload();
        }, 1000);
    }

    // Print table
    function printTable() {
        window.print();
    }

    // Initialize AOS animations
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100
            });
        }
    });



    // Auto refresh every 5 minutes
    setInterval(() => {
        if (!document.hidden) {
            console.log('Auto refreshing data...');
            // Add subtle refresh indicator
        }
    }, 300000);

    function exportExcel(id) {
        window.open("{{ url('registrasi') }}/" + id + "/export-excel", '_blank');
    }

    function exportCSV(id) {
        window.open("{{ url('registrasi') }}/" + id + "/export-csv", '_blank');
    }


</script>

@endsection