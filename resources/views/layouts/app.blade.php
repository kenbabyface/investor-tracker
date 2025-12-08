<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Investor Tracker') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .sidebar-link {
                transition: all 0.3s ease;
            }
            .sidebar-link:hover {
                transform: translateX(5px);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-900 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl">
                <div class="flex flex-col h-full">
                    <!-- Logo/Brand -->
                    <div class="flex items-center justify-between p-6 border-b border-blue-700">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold">Investor Tracker</h1>
                                <p class="text-xs text-blue-200">Manage Investments</p>
                            </div>
                        </div>
                        <button id="closeSidebar" class="lg:hidden text-white hover:text-blue-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
                        <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('investors.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('investors.*') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="font-medium">All Investors</span>
                        </a>

                        <a href="javascript:void(0)"  onclick="openPasswordModal('{{ route('investors.create') }}')" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <span class="font-medium">Add Investor</span>
                        </a>

                        <a href="{{ route('investments.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('investments.*') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Investments</span>
                        </a>

                        <a href="{{ route('investments.history') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('investments.history') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Investment History</span>
                        </a>

                        <div class="pt-4 mt-4 border-t border-blue-700">
                            <p class="px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-3">Account</p>
                            
                            <a href="{{ route('profile.show') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium">Profile</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="sidebar-link w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-500/20 text-left">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="font-medium">Logout</span>
                                </button>
                            </form>
                        </div>
                    </nav>

                    <!-- User Info at Bottom -->
                    <div class="p-4 border-t border-blue-700 bg-blue-950/50">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-600 rounded-full p-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-blue-200 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col lg:ml-64">
                <!-- Top Navigation Bar -->
                <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">
                        <button id="openSidebar" class="lg:hidden text-gray-600 hover:text-blue-600 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        @isset($header)
                            <div class="flex-1">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Overlay for mobile -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

        <script>
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const openSidebar = document.getElementById('openSidebar');
            const closeSidebar = document.getElementById('closeSidebar');

            openSidebar?.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            });

            closeSidebar?.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });

            overlay?.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        </script>

     <!-- Admin Password Modal - REPLACE the entire modal div -->
<div id="adminPasswordModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50 p-4">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl transform transition-all">
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        🔐 Admin Verification
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Enter password to continue</p>
                </div>
                <button onclick="closePasswordModal()" 
                        class="text-gray-400 hover:text-gray-600 transition-colors rounded-lg p-1 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <form id="adminPasswordForm" onsubmit="verifyPassword(event)" class="space-y-5">
                @csrf
                
                <!-- Password Input -->
                <div>
                    <label for="admin_password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <input type="password" 
                           id="admin_password" 
                           name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="Enter admin password"
                           required
                           autocomplete="off">
                </div>

                <!-- Error Message -->
                <div id="passwordError" class="hidden p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span id="passwordErrorMessage" class="text-sm font-medium"></span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="submit" 
                            id="verifyButton"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40">
                        <span id="verifyButtonText">Verify</span>
                        <span id="verifyButtonSpinner" class="hidden flex items-center justify-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verifying...
                        </span>
                    </button>
                    <button type="button" 
                            onclick="closePasswordModal()"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-xl transition-all duration-200">
                        Cancel
                    </button>
                </div>
            </form>

            
        </div>
    </div>
</div>

<script>
let redirectUrl = '';

function openPasswordModal(targetUrl) {
    redirectUrl = targetUrl;
    const modal = document.getElementById('adminPasswordModal');
    modal.classList.remove('hidden');
    
    // Add animation class
    setTimeout(() => {
        modal.querySelector('.relative').classList.add('scale-100', 'opacity-100');
    }, 10);
    
    document.getElementById('admin_password').focus();
    
    // Clear previous state
    document.getElementById('passwordError').classList.add('hidden');
    document.getElementById('admin_password').value = '';
}

function closePasswordModal() {
    const modal = document.getElementById('adminPasswordModal');
    modal.classList.add('hidden');
    document.getElementById('admin_password').value = '';
    document.getElementById('passwordError').classList.add('hidden');
    redirectUrl = '';
}

async function verifyPassword(event) {
    event.preventDefault();
    
    const password = document.getElementById('admin_password').value;
    const verifyButton = document.getElementById('verifyButton');
    const verifyButtonText = document.getElementById('verifyButtonText');
    const verifyButtonSpinner = document.getElementById('verifyButtonSpinner');
    const errorDiv = document.getElementById('passwordError');
    const errorMessage = document.getElementById('passwordErrorMessage');
    
    // Show loading state
    verifyButton.disabled = true;
    verifyButtonText.classList.add('hidden');
    verifyButtonSpinner.classList.remove('hidden');
    errorDiv.classList.add('hidden');
    
    try {
        const response = await fetch('{{ route("admin.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ password: password })
        });

        const data = await response.json();

        if (data.success) {
            // Success! Redirect to target page
            window.location.href = redirectUrl;
        } else {
            // Show error
            errorMessage.textContent = data.message || 'Incorrect password. Please try again.';
            errorDiv.classList.remove('hidden');
            
            // Shake animation
            errorDiv.classList.add('animate-shake');
            setTimeout(() => errorDiv.classList.remove('animate-shake'), 500);
            
            // Reset button
            verifyButton.disabled = false;
            verifyButtonText.classList.remove('hidden');
            verifyButtonSpinner.classList.add('hidden');
            
            // Clear password field and focus
            document.getElementById('admin_password').value = '';
            document.getElementById('admin_password').focus();
        }
    } catch (error) {
        console.error('Error:', error);
        errorMessage.textContent = 'Network error. Please check your connection.';
        errorDiv.classList.remove('hidden');
        
        // Reset button
        verifyButton.disabled = false;
        verifyButtonText.classList.remove('hidden');
        verifyButtonSpinner.classList.add('hidden');
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && !document.getElementById('adminPasswordModal').classList.contains('hidden')) {
        closePasswordModal();
    }
});

// Close modal when clicking outside
document.getElementById('adminPasswordModal')?.addEventListener('click', function(event) {
    if (event.target === this) {
        closePasswordModal();
    }
});
</script>

<style>
/* Modal styling */
#adminPasswordModal {
    z-index: 9999;
    backdrop-filter: blur(4px);
}

#adminPasswordModal > div {
    animation: modalScaleIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes modalScaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.animate-shake {
    animation: shake 0.5s;
}
</style>
    </body>
</html>