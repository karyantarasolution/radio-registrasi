    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PT. PUTRA PERKASA ABADI</title>

        <!-- AOS CSS -->
        <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

        {{-- Bootstrap CSS CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        {{-- CSS & JS via Vite --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">


        <style>
            body {
                min-height: 100vh;
                margin: 0;
                display: flex;
                flex-direction: column;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: #f7f9fc;
            }

            /* Navbar */
            .navbar-custom {
                background: #fff;
                border-bottom: 1px solid #ddd;
                height: 60px;
                z-index: 1050;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 20px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }
            .navbar-custom .navbar-brand {
                display: flex;
                align-items: center;
                gap: 8px;
                font-weight: bold;
                color: #2c3e50;
                text-decoration: none;
                font-size: 1rem;
            }
            .navbar-custom .navbar-brand img {
                height: 34px;
                width: auto;
                object-fit: contain;
            }

            /* User Info Section */
            .user-info-section {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .user-info {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 6px 14px;
                background: #f8f9fa;
                border-radius: 20px;
                border: 1px solid #e0e0e0;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-weight: bold;
                font-size: 14px;
            }

            .user-avatar.admin {
                background: linear-gradient(135deg, #93b6fbff 0%, #57f5e0ff 100%);
            }

            .user-details {
                display: flex;
                flex-direction: column;
                line-height: 1.2;
            }

            .user-name {
                font-size: 0.85rem;
                font-weight: 600;
                color: #2c3e50;
            }

            .user-role {
                font-size: 0.75rem;
                color: #7f8c8d;
            }

            .navbar-custom .btn-logout {
                background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
                border: none;
                color: #fff;
                border-radius: 20px;
                padding: 8px 20px;
                transition: all 0.3s ease;
                font-size: 0.9rem;
                font-weight: 500;
                box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .navbar-custom .btn-logout:hover {
                background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
                box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
                transform: translateY(-1px);
            }

            .navbar-custom .btn-logout:active {
                transform: translateY(0);
            }

            .navbar-custom .btn-logout i {
                font-size: 0.95rem;
            }

            .notif-dropdown .btn-notif {
                position: relative;
                background: #f8f9fa;
                border: 1px solid #e0e0e0;
                border-radius: 50%;
                width: 38px;
                height: 38px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #2c3e50;
            }
            .notif-dropdown .btn-notif:hover {
                background: #fff;
                color: #ea6666;
            }
            .notif-badge {
                position: absolute;
                top: -4px;
                right: -4px;
                background: #ea6666;
                color: #fff;
                font-size: 0.65rem;
                font-weight: 700;
                min-width: 18px;
                height: 18px;
                border-radius: 9px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 4px;
            }
            .notif-menu {
                width: 320px;
                max-height: 400px;
                overflow-y: auto;
            }
            .notif-menu .dropdown-item.unread {
                background: #fff8f8;
            }
            .notif-menu .dropdown-item small {
                display: block;
                color: #6c757d;
            }

            /* ================= SIDEBAR ================= */
            .sidebar {
                width: 220px;
                min-height: calc(100vh - 60px);
                background: #fff;
                border-right: 1px solid #ddd;
                position: fixed;
                top: 60px;
                left: 0;
                overflow-y: auto;
                transition: width 0.3s ease;
                box-shadow: 2px 0 6px rgba(0,0,0,0.05);
            }

            .sidebar.collapsed {
                width: 70px;
            }

            .sidebar a {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 18px;
                margin: 4px 6px;
                border-radius: 6px;
                color: #2c3e50;
                text-decoration: none;
                white-space: nowrap;
                transition: 0.3s;
            }

            .sidebar a:hover {
                background: #f1f1f1;
                transform: translateX(4px);
            }

            .sidebar a.active {
                background: #e74c3c;
                color: #fff;
                font-weight: 600;
            }

            /* Icon */
            .sidebar i {
                font-size: 18px;
                min-width: 22px;
                text-align: center;
                flex-shrink: 0;
            }

            /* ===== TEXT CONTROL ===== */
            .link-text {
                display: inline;
            }

            /* HANYA menu utama yang disembunyikan */
            .sidebar.collapsed .link-text {
                display: none;
            }

            /* Icon center saat collapse */
            .sidebar.collapsed a {
                justify-content: center;
            }

            /* ================= SUBMENU ================= */
            #submenu-inspeksi {
                background: transparent;
                padding: 0;
            }

            .submenu {
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .submenu li {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            /* Submenu links */
            .sidebar .submenu li a {
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
                padding: 10px 18px 10px 50px !important;
                margin: 4px 6px !important;
                border-radius: 6px !important;
                color: #2c3e50 !important;
                text-decoration: none !important;
                font-size: 0.88rem !important;
                white-space: nowrap !important;
                transition: 0.3s !important;
            }

            .sidebar .submenu li a:hover {
                background: #f8f9fa !important;
                transform: translateX(4px) !important;
            }

            .sidebar .submenu li a.active {
                background: #e74c3c !important;
                color: #fff !important;
                font-weight: 600 !important;
            }

            /* Icon dalam submenu - CRITICAL FIX */
            .sidebar .submenu li a i {
                font-size: 16px !important;
                min-width: 20px !important;
                width: 20px !important;
                height: 20px !important;
                line-height: 20px !important;
                text-align: center !important;
                flex-shrink: 0 !important;
                display: inline-block !important;
                visibility: visible !important;
                opacity: 1 !important;
                font-family: 'Font Awesome 6 Free' !important;
                font-weight: 900 !important;
                font-style: normal !important;
            }

            /* Override Bootstrap collapse visibility */
            .collapse .submenu li a i,
            .collapsing .submenu li a i,
            .show .submenu li a i {
                visibility: visible !important;
                display: inline-block !important;
            }

            /* Text dalam submenu */
            .sidebar .submenu .submenu-text {
                display: inline !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            /* CRITICAL: Override semua kemungkinan CSS yang hide text */
            .sidebar.collapsed .submenu .submenu-text,
            .sidebar .submenu .submenu-text,
            .submenu .submenu-text,
            .submenu-text {
                display: inline !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            /* Saat sidebar collapsed, sembunyikan nav-item dengan submenu */
            .sidebar.collapsed .nav-item {
                display: none !important;
            }

            /* ================= DROPDOWN TOGGLE ================= */
            .nav-item > .dropdown-toggle {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
            }

            .nav-item > .dropdown-toggle::after {
                content: '\f107';
                font-family: 'Font Awesome 6 Free';
                font-weight: 900;
                border: none !important;
                margin-left: auto;
                transition: transform 0.3s;
                font-size: 12px;
            }

            .nav-item > .dropdown-toggle[aria-expanded="true"]::after {
                transform: rotate(180deg);
            }

            /* Content */
            .content {
                margin-left: 220px;
                padding: 80px 20px 40px;
                flex: 1;
                transition: margin-left 0.4s ease-in-out;
            }
            .sidebar.collapsed ~ .content {
                margin-left: 70px;
            }

            /* Toggle */
            .toggle-btn {
                cursor: pointer;
                width: 25px;
                height: 20px;
                position: relative;
            }
            .toggle-btn span {
                background: #2c3e50;
                position: absolute;
                height: 3px;
                width: 100%;
                border-radius: 2px;
                transition: 0.3s;
            }
            .toggle-btn span:nth-child(1) { top: 0; }
            .toggle-btn span:nth-child(2) { top: 8px; }
            .toggle-btn span:nth-child(3) { top: 16px; }
            .toggle-btn.active span:nth-child(1) {
                transform: rotate(45deg);
                top: 8px;
            }
            .toggle-btn.active span:nth-child(2) {
                opacity: 0;
            }
            .toggle-btn.active span:nth-child(3) {
                transform: rotate(-45deg);
                top: 8px;
            }

            /* Footer */
            footer {
                position: relative;
                bottom: 0;
                left: 0;
                width: 100%;
                background: #fff;
                border-top: 1px solid #ddd;
                color: #555;
                padding: 14px;
                font-size: 0.85rem;
                text-align: center;
                box-shadow: 0 -2px 6px rgba(0,0,0,0.05);
                z-index: 1000;
                margin-top: auto;
            }

            /* Responsif */
            @media (max-width: 768px) {
                .sidebar {
                    width: 100%;
                    height: auto;
                    position: relative;
                    top: 0;
                }
                .content {
                    margin-left: 0;
                    padding: 80px 15px 40px;
                }
                footer {
                    margin-left: 0;
                    width: 100%;
                }
            }

            /* ===== FILTER DROPDOWN INVENTARIS ===== */
            .filter-form select {
                border-radius: 8px;
                border: 1px solid #ddd;
                padding: 6px 12px;
                font-size: 0.9rem;
                font-weight: 600;
                background-color: #ffffff !important;
                color: #2c3e50 !important;
                min-width: 170px;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }

            .filter-form select:focus {
                outline: none;
                border-color: #e74c3c;
                box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.25);
            }

            .filter-form select option {
                background-color: #ffffff !important;
                color: #2c3e50 !important;
            }

        </style>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    </head>
    <body>

    <!-- Header -->
        <nav class="navbar navbar-custom shadow-sm fixed-top">
            <div class="d-flex align-items-center">
                <div id="sidebarToggle" class="toggle-btn me-3">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <!-- Logo + Nama Brand -->
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/ppa-logo.png') }}" alt="Logo PPA">
                    <span></span>
                </a>
            </div>

            <div class="user-info-section">
                @if(Auth::user()->isAdmin() || Auth::user()->isPimpinan())
                <div class="dropdown notif-dropdown">
                    <button class="btn btn-notif" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
                        <i class="fas fa-bell"></i>
                        @if(($unreadNotificationsCount ?? 0) > 0)
                            <span class="notif-badge">{{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end notif-menu shadow">
                        <li><h6 class="dropdown-header">Notifikasi</h6></li>
                        @forelse($latestNotifications ?? [] as $notification)
                            @php $data = $notification->data; @endphp
                            <li>
                                <a class="dropdown-item {{ $notification->read_at ? '' : 'unread' }}"
                                   href="{{ route('notifications.read', $notification->id) }}">
                                    <strong class="d-block">{{ Str::limit($data['title'] ?? 'Notifikasi', 40) }}</strong>
                                    <small>{{ Str::limit($data['message'] ?? '', 60) }}</small>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item text-muted">Belum ada notifikasi</span></li>
                        @endforelse
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center fw-bold" href="{{ route('notifications.index') }}">Lihat semua</a></li>
                    </ul>
                </div>
                @endif

                @if(Auth::user()->isKaryawan() && (($h1Warnings->count() ?? 0) > 0 || ($overdueItems->count() ?? 0) > 0))
                <div class="dropdown notif-dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Peringatan Pengembalian" style="background:#fff3cd; border:1px solid #ffc107; border-radius:50%; width:38px; height:38px; display:flex; align-items:center; justify-content:center; color:#856404; position:relative;">
                        <i class="fas fa-exclamation-triangle"></i>
                        @php $totalWarnings = ($h1Warnings->count() ?? 0) + ($overdueItems->count() ?? 0); @endphp
                        @if($totalWarnings > 0)
                            <span class="notif-badge" style="background:#dc3545;">{{ $totalWarnings }}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end notif-menu shadow">
                        <li><h6 class="dropdown-header" style="color:#856404;">⚠️ Peringatan Pengembalian</h6></li>
                        @forelse($overdueItems ?? [] as $item)
                            <li>
                                <span class="dropdown-item unread">
                                    <strong class="d-block text-danger">Terlambat!</strong>
                                    <small>{{ $item->nama_perangkat }} - Deadline: {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') }}</small>
                                </span>
                            </li>
                        @empty
                        @endforelse
                        @forelse($h1Warnings ?? [] as $item)
                            <li>
                                <span class="dropdown-item unread">
                                    <strong class="d-block text-warning">H-1 Besok Deadline</strong>
                                    <small>{{ $item->nama_perangkat }} - Kembalikan besok: {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') }}</small>
                                </span>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                @endif

                <!-- User Info -->
                <div class="user-info">
                    <div class="user-avatar {{ Auth::user()->isAdmin() ? 'admin' : '' }}">
                        @if(Auth::user()->isAdmin())
                            <i class="fas fa-user-shield"></i>
                        @elseif(Auth::user()->isPimpinan())
                            <i class="fas fa-user-tie"></i>
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
                    </div>
                </div>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-logout btn-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            @php
                $role = Auth::user()->role;
                $isAdmin = Auth::user()->isAdmin();
                $isPimpinan = Auth::user()->isPimpinan();
                $isKaryawan = Auth::user()->isKaryawan();
            @endphp

            @if($isAdmin)
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="link-text">Dashboard ICT</span>
                </a>

                <a href="{{ route('registrasi.index') }}" class="{{ request()->routeIs('registrasi.*') ? 'active' : '' }}">
                    <i class="fas fa-broadcast-tower"></i>
                    <span class="link-text">Radio</span>
                </a>

                <a href="{{ route('inventaris.index') }}" class="{{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span class="link-text">Peminjaman</span>
                </a>

                <a href="{{ route('gudang-barang.index') }}" class="{{ request()->routeIs('gudang*') ? 'active' : '' }}">
                    <i class="fas fa-warehouse"></i>
                    <span class="link-text">Gudang IT</span>
                </a>

                <a href="{{ route('barang-maintenance.index') }}" class="{{ request()->routeIs('barang-maintenance.*') ? 'active' : '' }}">
                    <i class="fas fa-tools"></i>
                    <span class="link-text">Barang Maintenance</span>
                </a>

                <a href="{{ route('inventaris.riwayat') }}" class="{{ request()->routeIs('inventaris.riwayat') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span class="link-text">Riwayat Peminjaman</span>
                </a>

                <a href="{{ route('admin.daftar-akun') }}" class="{{ request()->routeIs('admin.daftar-akun') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span class="link-text">Daftar Akun</span>
                </a>

                <a href="{{ route('pengajuan.index') }}" class="{{ request()->routeIs('pengajuan.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span class="link-text">Pengajuan</span>
                </a>

                <a href="{{ route('bukutamu.index') }}" class="{{ request()->routeIs('bukutamu.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span class="link-text">Buku Tamu</span>
                </a>

                <div class="nav-item">
                    <a href="#"
                    class="dropdown-toggle {{ request()->is('inspeksi*') && !request()->routeIs('inspeksiups.*') && !request()->routeIs('inspeksistavolt.*') && !request()->routeIs('inspeksimonitor.*') && !request()->routeIs('inspeksiproyektor.*') ? 'active' : '' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#submenu-inspeksi"
                    aria-expanded="{{ request()->is('inspeksi*') ? 'true' : 'false' }}">
                        <i class="fas fa-clipboard-check"></i>
                        <span class="link-text">Inspeksi</span>
                    </a>
                    <div id="submenu-inspeksi" class="collapse {{ request()->is('inspeksi*') ? 'show' : '' }}">
                        <ul class="list-unstyled submenu">
                            <li><a href="{{ route('inspeksiups.index') }}" class="{{ request()->routeIs('inspeksiups.*') ? 'active' : '' }}"><i class="fas fa-battery-full"></i><span class="submenu-text">UPS</span></a></li>
                            <li><a href="{{ route('inspeksistavolt.index') }}" class="{{ request()->routeIs('inspeksistavolt.*') ? 'active' : '' }}"><i class="fas fa-bolt"></i><span class="submenu-text">Stavolt</span></a></li>
                            <li><a href="{{ route('inspeksimonitor.index') }}" class="{{ request()->routeIs('inspeksimonitor.*') ? 'active' : '' }}"><i class="fas fa-tv"></i><span class="submenu-text">Monitor / TV</span></a></li>
                            <li><a href="{{ route('inspeksiproyektor.index') }}" class="{{ request()->routeIs('inspeksiproyektor.*') ? 'active' : '' }}"><i class="fas fa-video"></i><span class="submenu-text">Proyektor</span></a></li>
                        </ul>
                    </div>
                </div>

                <a href="{{ route('karyawan.index') }}" class="{{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span class="link-text">Data Karyawan</span>
                </a>

            @elseif($isPimpinan)
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="link-text">Dashboard</span>
                </a>

                <a href="{{ route('pengajuan.index') }}" class="{{ request()->routeIs('pengajuan.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span class="link-text">Pengajuan</span>
                </a>

                <a href="{{ route('inventaris.index') }}" class="{{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span class="link-text">Peminjaman</span>
                </a>

                <a href="{{ route('pimpinan.laporan') }}" class="{{ request()->routeIs('pimpinan.laporan*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span class="link-text">Laporan</span>
                </a>

            @elseif($isKaryawan)
                <a href="{{ route('inventaris.index') }}" class="{{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span class="link-text">Peminjaman Saya</span>
                </a>

            @else
                <a href="{{ route('bukutamu.index') }}" class="{{ request()->routeIs('bukutamu.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span class="link-text">Buku Tamu</span>
                </a>
            @endif
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer>
            © 2025 PT. PUTRA PERKASA ABADI - All Rights Reserved
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- AOS JS -->
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

        <script>
            AOS.init({
                once: true,
                duration: 700,
            });

            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("sidebarToggle");

            toggleBtn.addEventListener("click", function() {
                sidebar.classList.toggle("collapsed");
                toggleBtn.classList.toggle("active");
            });

            document.querySelectorAll('.sidebar .dropdown-toggle').forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            });

            // FORCE FIX untuk icon dan text submenu
            function fixSubmenuElements() {
                const submenuLinks = document.querySelectorAll('.submenu li a');
                submenuLinks.forEach(function(link) {
                    // Fix link styling dengan !important
                    link.style.setProperty('display', 'flex', 'important');
                    link.style.setProperty('align-items', 'center', 'important');
                    link.style.setProperty('gap', '12px', 'important');
                    link.style.setProperty('visibility', 'visible', 'important');

                    // Fix icon
                    const icon = link.querySelector('i');
                    if (icon) {
                        icon.style.setProperty('display', 'inline-block', 'important');
                        icon.style.setProperty('visibility', 'visible', 'important');
                        icon.style.setProperty('opacity', '1', 'important');
                        icon.style.setProperty('width', '20px', 'important');
                        icon.style.setProperty('min-width', '20px', 'important');
                        icon.style.setProperty('text-align', 'center', 'important');
                        icon.style.setProperty('font-size', '16px', 'important');
                        icon.style.setProperty('flex-shrink', '0', 'important');
                    }

                    // Fix text dengan !important
                    const text = link.querySelector('.submenu-text');
                    if (text) {
                        text.style.setProperty('display', 'inline', 'important');
                        text.style.setProperty('visibility', 'visible', 'important');
                        text.style.setProperty('opacity', '1', 'important');
                        text.style.setProperty('color', 'inherit', 'important');
                    }
                });

                console.log('Fixed', submenuLinks.length, 'submenu links (icons + text) with !important');
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Fix saat page load
                setTimeout(fixSubmenuElements, 100);

                // Fix lagi setiap kali submenu dibuka
                const submenuElement = document.getElementById('submenu-inspeksi');
                if (submenuElement) {
                    submenuElement.addEventListener('shown.bs.collapse', function() {
                        fixSubmenuElements();
                        console.log('Submenu opened, fixed icons and text');
                    });
                }
            });
        </script>
    </body>
    </html>
