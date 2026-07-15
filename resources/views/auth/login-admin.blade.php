<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Admin ICT</title>
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
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle at 30% 40%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 70% 60%, rgba(147, 51, 234, 0.06) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            33% { transform: translate(30px, -30px); }
            66% { transform: translate(-20px, 20px); }
        }
        .login-container {
            position: relative; z-index: 1;
            width: 100%; max-width: 420px; padding: 2rem;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            backdrop-filter: blur(20px);
        }
        .login-header {
            text-align: center; margin-bottom: 2rem;
        }
        .login-header .icon {
            width: 56px; height: 56px;
            background: rgba(59, 130, 246, 0.15);
            border-radius: 14px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: #60a5fa; margin-bottom: 1rem;
        }
        .login-header h1 {
            font-size: 1.35rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.25rem;
        }
        .login-header p {
            font-size: 0.85rem; color: #94a3b8;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-group label {
            display: block; font-size: 0.8rem; font-weight: 600;
            color: #cbd5e1; margin-bottom: 0.4rem;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper i {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            font-size: 1rem; color: #64748b;
        }
        .form-group input {
            width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px; color: #f1f5f9; font-size: 0.9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.2s;
        }
        .form-group input:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-group input::placeholder { color: #64748b; }
        .btn-login {
            width: 100%; padding: 0.8rem;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border: none; border-radius: 10px;
            color: white; font-size: 0.95rem; font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; transition: all 0.3s;
            margin-top: 0.5rem;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
        .back-link {
            display: block; text-align: center; margin-top: 1.25rem;
            font-size: 0.8rem; color: #64748b; text-decoration: none;
            transition: color 0.2s;
        }
        .back-link:hover { color: #94a3b8; }
        .alert {
            padding: 0.7rem 1rem; border-radius: 10px; margin-bottom: 1.25rem;
            font-size: 0.8rem; font-weight: 500;
        }
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="icon"><i class="bi bi-shield-lock"></i></div>
                <h1>Login Admin ICT</h1>
                <p>Masukkan kredensial administrator</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <input type="hidden" name="login_type" value="admin_ict">

                <div class="form-group">
                    <label for="name">Nama Pengguna</label>
                    <div class="input-wrapper">
                        <i class="bi bi-person"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock"></i>
                        <input id="password" type="password" name="password" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>

            <a href="{{ route('portal') }}" class="back-link"><i class="bi bi-arrow-left"></i> Kembali ke Portal</a>
        </div>
    </div>
</body>
</html>
