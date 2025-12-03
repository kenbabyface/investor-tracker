<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-6">
        <div class="w-full max-w-md bg-white/20 backdrop-blur-lg shadow-xl rounded-2xl p-8 border border-white/30">

            <!-- Logo or Title -->
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-white drop-shadow-lg">Welcome Back</h2>
                <p class="text-white/80 text-sm mt-1">Login to continue</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" class="text-white" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg bg-white/40 border-white/30 text-white placeholder-white/70 focus:bg-white/50"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-yellow-300" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" class="text-white" :value="__('Password')" />

                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-lg bg-white/40 border-white/30 text-white placeholder-white/70 focus:bg-white/50"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-yellow-300" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-4">
                    <label for="remember_me" class="inline-flex items-center text-white">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-white/30 bg-white/20 text-indigo-600 shadow-sm focus:ring-white" name="remember">
                        <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Login Button + Forgot Password -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-white/80 hover:text-white underline"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button
                        class="ms-3 px-6 py-2 bg-white text-indigo-600 font-semibold rounded-lg shadow hover:bg-gray-100">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
