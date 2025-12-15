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

        .navbar-custom .btn-logout {
            background: #e74c3c;
            border: none;
            color: #fff;
            border-radius: 20px;
            padding: 5px 14px;
            transition: 0.3s;
            font-size: 0.9rem;
        }
        .navbar-custom .btn-logout:hover {
            background: #c0392b;
            box-shadow: 0 3px 8px rgba(231, 76, 60, 0.3);
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            min-height: calc(100vh - 60px);
            background: #fff;
            border-right: 1px solid #ddd;
            color: #2c3e50;
            position: fixed;
            top: 60px;
            left: 0;
          
            overflow-y: auto;
            box-shadow: 2px 0 6px rgba(0,0,0,0.05);
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #2c3e50;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 0.95rem;
         
            white-space: nowrap;
            margin: 4px 6px;
            border-radius: 6px;
        }
        .sidebar a:hover {
            background: #f1f1f1;
            transform: translateX(4px);
        }
        .sidebar a.active {
            background: #e74c3c;
            color: #fff;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .sidebar span {
            opacity: 1;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .sidebar.collapsed span {
            opacity: 0;
            transform: translateX(-10px);
            pointer-events: none;
        }

        /* Icon default */
        .sidebar a i {
            font-size: 18px;
            min-width: 22px;
            text-align: center;
            color: #2c3e50;
        }

        /* Teks default tampil */
        .sidebar .link-text {
            display: inline;
      
        }

        /* Kalau collapsed: sembunyikan teks */
        .sidebar.collapsed .link-text {
            display: none;
        }

        /* Kalau collapsed: icon rata tengah */
        .sidebar.collapsed a {
            justify-content: center;
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


        /* Footer (✅ diperbaiki) */
       footer {
        position: relative;  /* bukan fixed */
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
        margin-top: auto; /* biar dorong ke bawah */
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
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-logout btn-sm">Logout</button>
        </form>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        @if(Auth::user()->name=='USER')
            <a href="{{ route('bukutamu.index') }}"
            class="{{ request()->routeIs('bukutamu.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span class="link-text">Buku Tamu</span>
            </a>
        @elseif(Auth::user()->name=='ICT')
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" >
            <i class="fas fa-home"></i>
            <span class="link-text">Beranda</span>
        </a>

        <a href="{{ route('registrasi.index') }}" class="{{ request()->routeIs('registrasi.*') ? 'active' : '' }}" >
            <i class="fas fa-broadcast-tower"></i>
            <span class="link-text">Radio</span>
        </a>

        <a href="{{ route('inventaris.index') }}"
            class="{{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                <i class="fas fa-solid fa-box"></i>
                <span class="link-text">Inventaris </span>
        </a>

        <a href="{{ route('bukutamu.index') }}"
            class="{{ request()->routeIs('bukutamu.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span class="link-text">Buku Tamu</span>
        </a>

        <!-- Inspeksi (Static parent + static children) -->
        <a 
            class="">
            <i class="fas fa-tools"></i>
            <span class="link-text">Inspeksi</span>
        </a>
        <div class="link-text">
            <!-- Permanent child menu (always visible) -->
            <ul class="ps-10 mt-1 space-y-1">
                <li>
                    <a href="{{ route('inspeksiups.index') }}"
                    class="flex items-center gap-2 py-1 px-2 rounded 
                    {{ request()->routeIs('inspeksiups.*') ? 'bg-blue-500 text-white' : 'hover:bg-gray-200' }}">
                        <i class="fas fa-battery-full text-sm"></i> UPS
                    </a>
                </li>
                <li>
                    <a href="{{ route('inspeksistavolt.index') }}"
                    class="flex items-center gap-2 py-1 px-2 rounded 
                    {{ request()->routeIs('inspeksistavolt.*') ? 'bg-blue-500 text-white' : 'hover:bg-gray-200' }}">
                        <i class="fas fa-bolt text-sm"></i> Stavolt
                    </a>
                </li>
                <li>
                    <a href="{{ route('inspeksimonitor.index') }}"
                    class="flex items-center gap-2 py-1 px-2 rounded 
                    {{ request()->routeIs('inspeksimonitor.*') ? 'bg-blue-500 text-white' : 'hover:bg-gray-200' }}">
                        <i class="fas fa-tv text-sm"></i> Monitor / TV
                    </a>
                </li>
                <li>
                    <a href="{{ route('inspeksiproyektor.index') }}"
                    class="flex items-center gap-2 py-1 px-2 rounded 
                    {{ request()->routeIs('inspeksiproyektor.*') ? 'bg-blue-500 text-white' : 'hover:bg-gray-200' }}">
                        <i class="fas fa-video text-sm"></i> Proyektor
                    </a>
                </li>
            </ul>
        </div>
        <a href="{{ route('karyawan.index') }}" 
            class="{{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="link-text">Data Karyawan</span>
        </a>
        @endif
    </div>


    <!-- Content -->
    <div class="content" data-aos="fade-up">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        © 2025 PT. PUTRA PERKASA ABADI - All Rights Reserved
    </footer>

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
    </script>

    {{-- Bootstrap JS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>