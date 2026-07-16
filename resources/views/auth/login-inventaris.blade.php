<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Inventaris</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 50%, #0a1929 100%);
            padding: 1.5rem;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo {
            width: 80px;
            height: auto;
            margin-bottom: 1.25rem;
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e3a5f;
            margin-bottom: 0.35rem;
        }
        .login-subtitle {
            font-size: 0.9rem;
            color: #6b7280;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            font-family: inherit;
            color: #111827;
            background: #f9fafb;
            border: 1.5px solid #d1d5db;
            border-radius: 12px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            background: #fff;
        }
        .form-input::placeholder {
            color: #9ca3af;
        }
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            color: #ffffff;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 0.5rem;
            letter-spacing: 0.5px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .error-msg {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 0.5rem;
        }
        .alert-danger {
            padding: 0.7rem 1rem; border-radius: 10px; margin-bottom: 1.25rem;
            font-size: 0.85rem; color: #dc2626; background: #fef2f2;
            border: 1px solid #fecaca;
        }
        .back-link {
            display: block; text-align: center; margin-top: 1.25rem;
            font-size: 0.85rem; color: #9ca3af; text-decoration: none;
            transition: color 0.2s;
        }
        .back-link:hover { color: #6b7280; }
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/LogoPPA.png') }}" alt="Logo PPA" class="login-logo">
            <h1 class="login-title">Login Inventaris</h1>
            <p class="login-subtitle">Masukkan NRP dan kata sandi Anda</p>
        </div>

        @if ($errors->any())
            <div class="alert-danger" style="border-radius:10px; margin-bottom:1.25rem; padding:0.7rem 1rem;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.inventaris.post') }}">
            @csrf

            <div class="form-group">
                <label for="nrp" class="form-label">NRP</label>
                <input
                    id="nrp"
                    type="text"
                    name="nrp"
                    class="form-input"
                    placeholder="Masukkan NRP Anda"
                    value="{{ old('nrp') }}"
                    required
                    autofocus
                />
                @error('nrp')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Kata Sandi</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="Masukkan kata sandi"
                    required
                    autocomplete="current-password"
                />
                @error('password')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-login">MASUK</button>
        </form>

        <a href="{{ route('register.inventaris') }}" class="back-link" style="color:#2563eb; font-weight:600;">Belum punya akun? Daftar di sini</a>
        <a href="{{ route('portal') }}" class="back-link">&larr; Kembali ke Portal</a>

        <div class="login-footer">
            &copy; {{ date('Y') }} PT. Putra Perkasa Abadi
        </div>
    </div>
</body>
</html>
