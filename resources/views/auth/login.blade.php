<x-guest-layout>
    <style>
        /* Background hijau lembut */
        body {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            font-family: "Poppins", sans-serif;
        }
        /* Card tengah */
        .login-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 420px;
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
        .forgot {
            color: #27ae60;
        }
        .forgot:hover {
            color: #1f8a4d;
        }
    </style>

            <h2 class="text-center text-2xl mb-6 title">Login ke Lokalicious</h2>

            <!-- Alert status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-700"/>
                    <x-text-input id="email"
                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                        type="email" name="email" :value="old('email')" required autofocus />
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

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                            name="remember">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-4">

                    @if (Route::has('password.request'))
                        <a class="text-sm forgot" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif

                    <x-primary-button class="btn-green ms-3">
                        Login
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
