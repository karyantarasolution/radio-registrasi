<x-guest-layout>
    <style>
        body {
            background: #f5f7fb;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        /* Logo */
        .login-logo {
            width: 90px;
            margin: 0 auto 1rem;
        }

        /* Title */
        .login-title {
            font-size: 1.7rem;
            font-weight: 700;
            color: #1f3c88;
            text-align: center;
        }

        .login-subtitle {
            font-size: 0.95rem;
            color: #6b7280;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Input */
        .login-input {
            border-radius: 14px;
            border: 1px solid #d1d5db;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            background: #ffffff;
        }

        .login-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        /* Button */
        .login-btn {
            border-radius: 14px;
            padding: 0.85rem;
            font-weight: 600;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        /* Register link */
        .register-text {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .register-text a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .register-text a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="login-wrapper">
        <div class="login-container">

            <!-- Logo -->
            <img src="{{ asset('images/LogoPPA.png') }}" alt="Logo" class="login-logo">

            <!-- Title -->
            <h2 class="login-title">Selamat Datang</h2>
            <p class="login-subtitle">Silakan login untuk melanjutkan</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama
                    </label>
                    <x-text-input
                        id="name"
                        class="login-input block w-full"
                        type="text"
                        name="name"
                        required
                        autofocus
                    />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kata Sandi
                    </label>
                    <x-text-input
                        id="password"
                        class="login-input block w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Button -->
                <div class="mt-6">
                    <x-primary-button class="login-btn w-full justify-center text-white">
                        MASUK
                    </x-primary-button>
                </div>
            </form>

            <!-- Register -->
            @if (Route::has('register'))
           
            @endif

        </div>
    </div>
</x-guest-layout>
