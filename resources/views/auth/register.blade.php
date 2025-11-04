<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            font-family: "Poppins", sans-serif;
        }
        .register-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 32px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 460px;
            margin: auto;
        }
        .title {
            font-weight: 700;
            color: #27ae60;
        }
        .btn-green {
            background-color: #27ae60 !important;
            border: none;
        }
        .btn-green:hover {
            background-color: #1f8a4d !important;
        }
        .login-link {
            color: #27ae60;
        }
        .login-link:hover {
            color: #1f8a4d;
        }
    </style>

            <h2 class="text-center text-2xl mb-6 title">Daftar Akun Baru</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="font-semibold text-gray-700"/>
                    <x-text-input id="name"
                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                        type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-700"/>
                    <x-text-input id="email"
                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                        type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-700"/>
                    <x-text-input id="password"
                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                        type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="font-semibold text-gray-700"/>
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                        type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-between mt-5">
                    <a class="text-sm login-link" href="{{ route('login') }}">
                        Sudah punya akun?
                    </a>

                    <x-primary-button class="btn-green ms-3">
                        Daftar
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>
