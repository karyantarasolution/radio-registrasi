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
            width: 70px;
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

        @media (min-width: 1024px) {
            .login-container {
                max-width: 460px;
            }
        }
    </style>

    <div class="login-wrapper">
        <div class="login-container">

            <!-- Logo -->
            <img src="{{ asset('images/LogoPPA.png') }}" alt="Logo" class="login-logo">

            <!-- Title -->
            <h2 class="login-title">Buat Akun Baru ✨</h2>
            <p class="login-subtitle">Silakan isi data untuk mendaftar</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama
                    </label>
                    <x-text-input
                        id="name"
                        class="login-input block w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Konfirmasi Kata Sandi
                    </label>
                    <x-text-input
                        id="password_confirmation"
                        class="login-input block w-full"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Button -->
                <div class="mt-6">
                    <x-primary-button class="login-btn w-full justify-center text-white">
                        REGISTRASI
                    </x-primary-button>
                </div>

                <!-- Login Link -->
                <p class="text-center text-sm text-gray-600 mt-4">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                        Masuk di sini
                    </a>
                </p>

            </form>

        </div>
    </div>
</x-guest-layout>
