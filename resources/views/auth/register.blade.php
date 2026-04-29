<x-guest-layout :title="'Register - Twintiamiyu Agroservices'">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 2s infinite',
                        'float-slow': 'float 8s ease-in-out 4s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'sway': 'sway 4s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(3deg)' },
                        },
                        sway: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%': { transform: 'rotate(3deg)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .bg-animated {
            background: linear-gradient(135deg, #1e3a5f 0%, #1e40af 25%, #2563eb 50%, #3b82f6 75%, #60a5fa 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.15;
            pointer-events: none;
        }

        .input-group:focus-within .input-icon {
            color: #2563eb;
            transform: scale(1.1);
        }

        .input-group:focus-within input {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        .btn-shine:hover::before {
            left: 100%;
        }

        .leaf-deco {
            position: absolute;
            opacity: 0.06;
            pointer-events: none;
        }

        .wave-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        .wave-bottom svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 80px;
        }
    </style>

    <div class="bg-animated min-h-screen flex items-center justify-center relative py-8">

        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-blue-400 rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-float"></div>
            <div class="absolute -bottom-32 -left-20 w-80 h-80 bg-cyan-400 rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-float-delayed"></div>
            <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-indigo-400 rounded-full mix-blend-overlay filter blur-3xl opacity-15 animate-float-slow"></div>

            <svg class="leaf-deco absolute top-10 left-10 w-32 h-32 text-white animate-sway" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
            </svg>
            <svg class="leaf-deco absolute bottom-20 right-10 w-24 h-24 text-white animate-sway" style="animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
            </svg>

            <div class="particle w-2 h-2 bg-white top-1/4 left-1/4 animate-float"></div>
            <div class="particle w-1.5 h-1.5 bg-cyan-300 top-1/3 right-1/3 animate-float-delayed"></div>
            <div class="particle w-2.5 h-2.5 bg-blue-300 bottom-1/3 left-1/3 animate-float-slow"></div>
            <div class="particle w-1 h-1 bg-white top-2/3 right-1/4 animate-float"></div>
        </div>

        <!-- Main Container -->
        <div class="w-full max-w-md px-4 sm:px-6 relative z-10">

            <!-- Glass Card -->
            <div class="glass-card rounded-3xl p-8 sm:p-10 relative overflow-hidden">

                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-cyan-500 to-blue-600"></div>

                <!-- Logo Section -->
                <div class="flex flex-col items-center mb-6">
                    <div class="relative mb-4">
                        <div class="absolute inset-0 bg-blue-500 rounded-2xl blur-lg opacity-30 animate-pulse-slow"></div>
                        <div class="relative bg-gradient-to-br from-blue-600 to-blue-800 p-4 rounded-2xl shadow-xl border border-blue-400/30">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0-3 2.5-5.5 5.5-5.5S23 8 23 11c0 2.5-2 4.5-4.5 4.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0-3-2.5-5.5-5.5-5.5S1 8 1 11c0 2.5 2 4.5 4.5 4.5"/>
                            </svg>
                        </div>
                    </div>
                    <h1 class="font-serif text-2xl font-bold text-gray-800 tracking-tight">Twintiamiyu</h1>
                    <p class="text-blue-600 font-medium text-sm tracking-widest uppercase mt-0.5">Agroservices</p>
                </div>

                <!-- Welcome Text -->
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-1.5">Create Account</h2>
                    <p class="text-gray-500 text-sm">Join us and start managing your agro services</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Full Name -->
                    <div class="input-group">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user input-icon text-gray-400 transition-all duration-300 text-sm"></i>
                            </div>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white transition-all duration-300 text-sm"
                                placeholder="John Doe"
                                autocomplete="name"
                            >
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="input-group">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope input-icon text-gray-400 transition-all duration-300 text-sm"></i>
                            </div>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white transition-all duration-300 text-sm"
                                placeholder="you@example.com"
                                autocomplete="email"
                            >
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock input-icon text-gray-400 transition-all duration-300 text-sm"></i>
                            </div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                class="block w-full pl-11 pr-12 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white transition-all duration-300 text-sm"
                                placeholder="Enter your password"
                                autocomplete="new-password"
                            >
                            <button
                                type="button"
                                onclick="togglePassword('password', 'toggleIcon1')"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-600 transition-colors cursor-pointer"
                            >
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="input-group">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock input-icon text-gray-400 transition-all duration-300 text-sm"></i>
                            </div>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                class="block w-full pl-11 pr-12 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white transition-all duration-300 text-sm"
                                placeholder="Re-enter your password"
                                autocomplete="new-password"
                            >
                            <button
                                type="button"
                                onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-600 transition-colors cursor-pointer"
                            >
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Register Button -->
                    <button
                        type="submit"
                        class="btn-shine w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-xl hover:shadow-blue-500/25 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 mt-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Create Account
                    </button>
                </form>

                <!-- Login Link -->
                <div class="pt-5 border-t border-gray-100 mt-5">
                    <p class="text-center text-gray-500 text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition-colors ml-1 relative group inline-flex items-center gap-1">
                            Sign In
                            <i class="fas fa-arrow-right text-xs opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-200"></i>
                        </a>
                    </p>
                </div>

                <!-- Footer Info -->
                <div class="mt-5 flex items-center justify-center gap-4 text-xs text-gray-400">
                    <span class="flex items-center gap-1">
                        <i class="fas fa-shield-alt text-blue-500"></i>
                        SSL Secured
                    </span>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-lock text-blue-500"></i>
                        Encrypted
                    </span>
                </div>
            </div>

            <!-- Bottom Branding -->
            <div class="text-center mt-6 space-y-2">
                <div class="flex items-center justify-center gap-3 text-white/70 text-sm">
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-seedling text-cyan-300"></i>
                        Growing Together
                    </span>
                    <span class="w-1 h-1 bg-white/40 rounded-full"></span>
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-leaf text-blue-300"></i>
                        Sustainable Future
                    </span>
                </div>
                <p class="text-white/50 text-xs">
                    © 2024 Twintiamiyu Agroservices. All rights reserved.
                </p>
            </div>
        </div>

        <!-- Wave decoration at bottom -->
        <div class="wave-bottom pointer-events-none">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="rgba(255,255,255,0.05)"></path>
            </svg>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, iconId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</x-guest-layout>