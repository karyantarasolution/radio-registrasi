<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal PT. Putra Perkasa Abadi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 40%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 70% 60%, rgba(147, 51, 234, 0.06) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(1deg); }
            66% { transform: translate(-20px, 20px) rotate(-1deg); }
        }

        .portal-container {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 2rem;
            width: 100%;
            max-width: 900px;
        }

        .logo-section {
            margin-bottom: 1rem;
        }

        .logo-section img {
            height: 80px;
            filter: drop-shadow(0 4px 20px rgba(59, 130, 246, 0.3));
        }

        .company-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 0.25rem;
            letter-spacing: -0.02em;
        }

        .company-subtitle {
            font-size: 0.875rem;
            color: #94a3b8;
            margin-bottom: 0.25rem;
        }

        .portal-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.5rem;
            letter-spacing: -0.03em;
        }

        .portal-desc {
            font-size: 1.05rem;
            color: #94a3b8;
            margin-bottom: 2.5rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 2rem 1.25rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            backdrop-filter: blur(10px);
        }

        .card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .card-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            transition: transform 0.3s;
        }

        .card:hover .card-icon {
            transform: scale(1.1);
        }

        .card-icon.blue { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
        .card-icon.purple { background: rgba(147, 51, 234, 0.15); color: #a78bfa; }
        .card-icon.green { background: rgba(34, 197, 94, 0.15); color: #4ade80; }
        .card-icon.orange { background: rgba(249, 115, 22, 0.15); color: #fb923c; }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #f1f5f9;
        }

        .card-desc {
            font-size: 0.8rem;
            color: #94a3b8;
            line-height: 1.4;
        }

        .footer-text {
            font-size: 0.75rem;
            color: #475569;
        }

        @media (max-width: 768px) {
            .cards-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
            .portal-title { font-size: 1.75rem; }
        }

        @media (max-width: 480px) {
            .cards-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="portal-container">
        <div class="logo-section">
            <img src="{{ asset('images/logo.PNG') }}" alt="Logo PPA">
        </div>
        <div class="company-name">PT. Putra Perkasa Abadi</div>
        <div class="company-subtitle">Sistem Manajemen ICT</div>
        <div class="portal-title">Portal Akses</div>
        <div class="portal-desc">Pilih layanan yang ingin Anda akses untuk melanjutkan ke halaman login.</div>

        <div class="cards-grid">
            <a href="{{ route('login.pimpinan') }}" class="card">
                <div class="card-icon purple"><i class="bi bi-person-badge"></i></div>
                <div class="card-title">Pimpinan</div>
                <div class="card-desc">Persetujuan pengajuan & monitoring</div>
            </a>
            <a href="{{ route('login.admin') }}" class="card">
                <div class="card-icon blue"><i class="bi bi-shield-lock"></i></div>
                <div class="card-title">Admin ICT</div>
                <div class="card-desc">Verifikasi & manajemen data</div>
            </a>
            <a href="{{ route('login.inventaris') }}" class="card">
                <div class="card-icon green"><i class="bi bi-box-seam"></i></div>
                <div class="card-title">Inventaris</div>
                <div class="card-desc">Peminjaman & pengembalian barang</div>
            </a>
            <a href="{{ route('login') }}" class="card">
                <div class="card-icon orange"><i class="bi bi-journal-bookmark"></i></div>
                <div class="card-title">Buku Tamu</div>
                <div class="card-desc">Pencatatan kunjungan tamu</div>
            </a>
        </div>

        <div class="footer-text">&copy; {{ date('Y') }} PT. Putra Perkasa Abadi &mdash; Department ICT</div>
    </div>
</body>
</html>
