<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' - ' : '' }} Twintiamiyu Investor Tracker</title>
        
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root { --sidebar-w: 288px; }

            /* ── Desktop: main content offset ── */
            @media (min-width: 1024px) {
                #main-content {
                    margin-left: var(--sidebar-w);
                    width: calc(100% - var(--sidebar-w));
                    transition: margin-left 0.3s ease, width 0.3s ease;
                }
                #sidebar {
                    transition: transform 0.3s ease;
                }
            }

            /* ── Desktop: collapsed state ── */
            @media (min-width: 1024px) {
                body.sidebar-collapsed #sidebar {
                    transform: translateX(-100%);
                }
                body.sidebar-collapsed #main-content {
                    margin-left: 0;
                    width: 100%;
                }
            }

            /* ── Sidebar links ── */
            .sidebar-link {
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }
            .sidebar-link::before {
                content: '';
                position: absolute;
                left: 0; top: 0; bottom: 0;
                width: 3px;
                background: #60a5fa;
                transform: scaleY(0);
                transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .sidebar-link:hover::before  { transform: scaleY(0.3); }
            .sidebar-link.active::before { transform: scaleY(1); }
            .sidebar-link:hover  { transform: translateX(4px); background: rgba(255,255,255,0.08); }
            .sidebar-link.active { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); }

            .nav-group-btn { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
            .nav-group-btn:hover { background: rgba(255,255,255,0.08); }
            .nav-group-btn.group-open { background: rgba(255,255,255,0.1); }

            .nav-chevron { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
            .nav-chevron.rotated { transform: rotate(180deg); }

            .nav-dropdown {
                overflow: hidden;
                max-height: 0;
                opacity: 0;
                transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s ease;
            }
            .nav-dropdown.open { max-height: 500px; opacity: 1; }

            .nav-sub-link { transition: all 0.2s ease; position: relative; }
            .nav-sub-link::before {
                content: '';
                position: absolute;
                left: 0; top: 0; bottom: 0;
                width: 2px;
                background: #93c5fd;
                transform: scaleY(0);
                transition: transform 0.2s ease;
            }
            .nav-sub-link:hover::before  { transform: scaleY(0.5); }
            .nav-sub-link.active::before { transform: scaleY(1); }
            .nav-sub-link:hover  { background: rgba(255,255,255,0.07); transform: translateX(3px); }
            .nav-sub-link.active { background: rgba(96,165,250,0.18); }

            .group-dot { opacity: 0; transition: opacity 0.2s ease; }
            .nav-group-btn.group-open .group-dot { opacity: 1; }

            .glass-panel {
                background: rgba(30, 58, 138, 0.95);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }
            .header-shadow {
                box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06), 0 4px 6px -1px rgba(0,0,0,0.05);
            }
            .custom-scrollbar::-webkit-scrollbar { width: 6px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }

            .icon-container { transition: all 0.2s ease; }
            .sidebar-link:hover .icon-container,
            .nav-group-btn:hover .icon-container,
            .nav-group-btn.group-open .icon-container { transform: scale(1.1); background: rgba(255,255,255,0.2); }

            @keyframes shake {
                0%,100% { transform: translateX(0); }
                10%,30%,50%,70%,90% { transform: translateX(-5px); }
                20%,40%,60%,80% { transform: translateX(5px); }
            }
            .animate-shake { animation: shake 0.5s; }

            [x-cloak] { display: none !important; }

            /* ── Desktop toggle button ── */
            #desktopToggleSidebar {
                transition: background 0.2s ease, transform 0.15s ease, color 0.2s ease;
            }
            #desktopToggleSidebar:hover {
                background: #eff6ff;
                color: #2563eb;
                transform: scale(1.05);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">

        <div class="relative min-h-screen">

            <!-- ═══════════════════ SIDEBAR ═══════════════════ -->
            <aside id="sidebar"
                   class="fixed inset-y-0 left-0 z-50 w-72 glass-panel text-white
                          transform -translate-x-full lg:translate-x-0
                          shadow-2xl border-r border-blue-700/30">
                <div class="flex flex-col h-full">

                    <!-- Brand -->
                    <div class="flex items-center justify-between p-6 border-b border-blue-700/50 bg-gradient-to-r from-blue-900/50 to-transparent">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="icon-container bg-white/20 p-2.5 rounded-xl shadow-lg flex-shrink-0">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h1 class="text-lg font-bold tracking-tight truncate">Investor Tracker</h1>
                                <p class="text-xs text-blue-200 font-medium tracking-wide uppercase truncate">Portfolio Management</p>
                            </div>
                        </div>
                        {{-- Mobile close --}}
                        <button id="closeSidebar" class="lg:hidden text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition-colors flex-shrink-0 ml-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 overflow-y-auto custom-scrollbar py-5 px-3 space-y-1">

                        <div class="px-3 mt-4">
                            <p class="text-xs font-semibold text-blue-300/80 uppercase tracking-wider">Main Menu</p>
                        </div>

                        <a href="{{ route('dashboard') }}"
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <div class="icon-container p-1.5 rounded-lg bg-white/10 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <span class="font-medium text-sm">Dashboard</span>
                        </a>

                        <a href="{{ route('investors.index') }}"
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('investors.*') ? 'active' : '' }}">
                            <div class="icon-container p-1.5 rounded-lg bg-white/10 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-sm">All Investors</span>
                        </a>

                        @php $investOpen = request()->routeIs('investments.*') || request()->routeIs('payments.schedule'); @endphp
                        <div>
                            <button type="button" id="btn-investments" onclick="toggleNav('investments')"
                                    class="nav-group-btn {{ $investOpen ? 'group-open' : '' }} w-full flex items-center justify-between px-4 py-3 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="icon-container p-1.5 rounded-lg bg-white/10 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-sm">Investments</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="group-dot w-1.5 h-1.5 bg-blue-300 rounded-full"></span>
                                    <svg id="chevron-investments" class="nav-chevron w-4 h-4 text-blue-300 {{ $investOpen ? 'rotated' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </button>
                            <div id="dropdown-investments" class="nav-dropdown {{ $investOpen ? 'open' : '' }} ml-4 mt-1">
                                <div class="pl-3 border-l border-blue-600/40 space-y-0.5 pb-1">
                                    <a href="javascript:void(0)" onclick="openPasswordModal('{{ route('investors.create') }}')"
                                       class="nav-sub-link flex items-center space-x-3 px-3 py-2.5 rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/70 flex-shrink-0"></span>
                                        <span class="text-sm text-blue-100">Add Investor</span>
                                    </a>
                                    <a href="{{ route('investments.index') }}"
                                       class="nav-sub-link flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('investments.index') ? 'active' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/70 flex-shrink-0"></span>
                                        <span class="text-sm text-blue-100">All Investments</span>
                                    </a>
                                    <a href="{{ route('investments.history') }}"
                                       class="nav-sub-link flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('investments.history') ? 'active' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/70 flex-shrink-0"></span>
                                        <span class="text-sm text-blue-100">Investment History</span>
                                    </a>
                                    <a href="{{ route('payments.schedule') }}"
                                       class="nav-sub-link flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('payments.schedule') ? 'active' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/70 flex-shrink-0"></span>
                                        <span class="text-sm text-blue-100">Payment Schedule</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        @php $fishOpen = request()->routeIs('ponds.*') || request()->routeIs('feed-logs.*') || request()->routeIs('feed-sizes.*'); @endphp
                        <div>
                            <button type="button" id="btn-fish" onclick="toggleNav('fish')"
                                    class="nav-group-btn {{ $fishOpen ? 'group-open' : '' }} w-full flex items-center justify-between px-4 py-3 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="icon-container p-1.5 rounded-lg bg-white/10 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12c-2-4-6-7-9-7S5 8 3 12c2 4 6 7 9 7s7-3 9-7z"/>
                                            <circle cx="15.5" cy="11" r="1" fill="currentColor" stroke="none"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12C2 10.5 1.5 8.5 2 7M3 12c-1 1.5-1.5 3.5-1 5"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-sm">Fish Management</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="group-dot w-1.5 h-1.5 bg-blue-300 rounded-full"></span>
                                    <svg id="chevron-fish" class="nav-chevron w-4 h-4 text-blue-300 {{ $fishOpen ? 'rotated' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </button>
                            <div id="dropdown-fish" class="nav-dropdown {{ $fishOpen ? 'open' : '' }} ml-4 mt-1">
                                <div class="pl-3 border-l border-blue-600/40 space-y-0.5 pb-1">
                                    <a href="{{ route('feed-logs.overview') }}"
                                       class="nav-sub-link flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('feed-logs.overview') ? 'active' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/70 flex-shrink-0"></span>
                                        <span class="text-sm text-blue-100">Fish Overview</span>
                                    </a>
                                    <a href="{{ route('ponds.index') }}"
                                       class="nav-sub-link flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('ponds.*') ? 'active' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/70 flex-shrink-0"></span>
                                        <span class="text-sm text-blue-100">Ponds</span>
                                    </a>
                                    <a href="{{ route('feed-logs.create') }}"
                                       class="nav-sub-link flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('feed-logs.create') ? 'active' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/70 flex-shrink-0"></span>
                                        <span class="text-sm text-blue-100">Log Feed Today</span>
                                    </a>
                                    <a href="{{ route('feed-logs.index') }}"
                                       class="nav-sub-link flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('feed-logs.index') || request()->routeIs('feed-logs.edit') ? 'active' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/70 flex-shrink-0"></span>
                                        <span class="text-sm text-blue-100">Feed Logs</span>
                                    </a>
                                    <a href="{{ route('feed-sizes.index') }}"
                                       class="nav-sub-link flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('feed-sizes.*') ? 'active' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/70 flex-shrink-0"></span>
                                        <span class="text-sm text-blue-100">Feed Settings</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 pt-5 border-t border-blue-700/50">
                            <div class="px-3 mb-2">
                                <p class="text-xs font-semibold text-blue-300/80 uppercase tracking-wider">Account</p>
                            </div>
                            <a href="{{ route('profile.show') }}"
                               class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <div class="icon-container p-1.5 rounded-lg bg-white/10 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-sm">Profile</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="sidebar-link w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-left group">
                                    <div class="icon-container p-1.5 rounded-lg bg-white/10 group-hover:bg-red-500/20 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-sm">Logout</span>
                                </button>
                            </form>
                        </div>
                    </nav>

                    <!-- User Info -->
                    <div class="p-4 border-t border-blue-700/50 bg-gradient-to-t from-blue-950/80 to-transparent">
                        <div class="flex items-center space-x-3 p-3 rounded-xl bg-white/5 border border-white/10">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-full p-2 shadow-lg flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-blue-200 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="w-2 h-2 bg-green-400 rounded-full shadow-lg shadow-green-400/50 flex-shrink-0"></div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- ═══════════════════ MAIN CONTENT ═══════════════════ -->
            <div id="main-content" class="flex flex-col min-h-screen bg-gray-50">
                <header class="bg-white header-shadow border-b border-gray-200 sticky top-0 z-40">
                    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">
                        <div class="flex items-center gap-3 flex-1">

                            {{-- Mobile: open sidebar --}}
                            <button id="openSidebar"
                                    class="lg:hidden text-gray-500 hover:text-blue-600 p-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>

                            {{-- Desktop: collapse / expand toggle --}}
                            <button id="desktopToggleSidebar"
                                    class="hidden lg:flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-gray-500 focus:outline-none"
                                    title="Toggle sidebar">
                                {{-- Shown when sidebar is EXPANDED (click to collapse) --}}
                                <svg id="iconCollapse" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                {{-- Shown when sidebar is COLLAPSED (click to expand) --}}
                                <svg id="iconExpand" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>

                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <span class="hover:text-gray-700 cursor-pointer transition-colors">Home</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span class="font-semibold text-gray-900">{{ $title ?? 'Dashboard' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="relative p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                            </button>
                            @isset($header)
                                <div class="hidden sm:block border-l border-gray-200 pl-4 ml-2">{{ $header }}</div>
                            @endisset
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto bg-gray-50/50">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Mobile overlay -->
        <div id="overlay" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 hidden lg:hidden"></div>

        <!-- ═══════════════════ ADMIN PASSWORD MODAL ═══════════════════ -->
        <div id="adminPasswordModal" class="hidden fixed inset-0 bg-gray-900/70 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <span class="bg-blue-100 p-2 rounded-lg">🔐</span>
                                Admin Verification
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Enter password to continue</p>
                        </div>
                        <button onclick="closePasswordModal()" class="text-gray-400 hover:text-gray-600 transition-colors rounded-lg p-2 hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <form id="adminPasswordForm" onsubmit="verifyPassword(event)" class="space-y-5">
                        @csrf
                        <div>
                            <label for="admin_password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <input type="password" id="admin_password" name="password"
                                       class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                       placeholder="Enter admin password" required autocomplete="off">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div id="passwordError" class="hidden p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span id="passwordErrorMessage" class="text-sm font-medium"></span>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" id="verifyButton"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5">
                                <span id="verifyButtonText">Verify</span>
                                <span id="verifyButtonSpinner" class="hidden flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Verifying...
                                </span>
                            </button>
                            <button type="button" onclick="closePasswordModal()"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-xl transition-all">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Toast Container -->
        <div id="toastContainer" class="fixed top-4 right-4 z-[99999] space-y-3 pointer-events-none"></div>

        <!-- ═══════════════════ SCRIPTS ═══════════════════ -->
        <script>
            // ── Mobile sidebar ──
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            document.getElementById('openSidebar')?.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            });
            document.getElementById('closeSidebar')?.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
            overlay?.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });

            // ── Desktop collapse / expand ──
            const desktopToggle = document.getElementById('desktopToggleSidebar');
            const iconCollapse  = document.getElementById('iconCollapse');
            const iconExpand    = document.getElementById('iconExpand');
            const STORAGE_KEY   = 'sidebarCollapsed';

            function setSidebarCollapsed(collapsed, animate) {
                const mainContent = document.getElementById('main-content');

                if (!animate) {
                    // Disable transitions for instant restore on page load
                    sidebar.style.transition      = 'none';
                    mainContent.style.transition  = 'none';
                }

                if (collapsed) {
                    document.body.classList.add('sidebar-collapsed');
                    iconCollapse.classList.add('hidden');
                    iconExpand.classList.remove('hidden');
                } else {
                    document.body.classList.remove('sidebar-collapsed');
                    iconCollapse.classList.remove('hidden');
                    iconExpand.classList.add('hidden');
                }

                if (!animate) {
                    // Force reflow then re-enable transitions
                    sidebar.offsetHeight;
                    sidebar.style.transition     = '';
                    mainContent.style.transition = '';
                }

                localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
            }

            // Restore persisted state instantly (no animation) on every page load
            setSidebarCollapsed(localStorage.getItem(STORAGE_KEY) === '1', false);

            desktopToggle?.addEventListener('click', () => {
                const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                setSidebarCollapsed(!isCollapsed, true);
            });

            // ── Nav dropdown toggle ──
            function toggleNav(name) {
                const btn      = document.getElementById('btn-' + name);
                const dropdown = document.getElementById('dropdown-' + name);
                const chevron  = document.getElementById('chevron-' + name);
                const isOpen   = dropdown.classList.contains('open');
                if (isOpen) {
                    dropdown.classList.remove('open');
                    chevron.classList.remove('rotated');
                    btn.classList.remove('group-open');
                } else {
                    dropdown.classList.add('open');
                    chevron.classList.add('rotated');
                    btn.classList.add('group-open');
                }
            }

            // ── Toast ──
            function showToast(message, type = 'success') {
                const container = document.getElementById('toastContainer');
                const icons = {
                    success: `<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`,
                    error:   `<svg class="w-5 h-5 text-red-500"   fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`,
                    warning: `<svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>`,
                    info:    `<svg class="w-5 h-5 text-blue-500"  fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
                };
                const borders = { success:'border-green-500', error:'border-red-500', warning:'border-yellow-500', info:'border-blue-500' };
                const toast = document.createElement('div');
                toast.className = `pointer-events-auto flex items-center gap-3 bg-white border-l-4 ${borders[type]} rounded-xl shadow-lg px-4 py-3 min-w-[280px] max-w-sm transform translate-x-full transition-transform duration-300 ease-out`;
                toast.innerHTML = `${icons[type]}<p class="text-sm font-medium text-gray-800 flex-1">${message}</p><button onclick="removeToast(this.parentElement)" class="text-gray-400 hover:text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>`;
                container.appendChild(toast);
                requestAnimationFrame(() => requestAnimationFrame(() => toast.classList.remove('translate-x-full')));
                setTimeout(() => removeToast(toast), 4000);
            }
            function removeToast(toast) {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }

            // ── Admin password modal ──
            let redirectUrl = '';
            function openPasswordModal(targetUrl) {
                redirectUrl = targetUrl;
                document.getElementById('adminPasswordModal').classList.remove('hidden');
                document.getElementById('passwordError').classList.add('hidden');
                document.getElementById('admin_password').value = '';
                document.getElementById('admin_password').focus();
            }
            function closePasswordModal() {
                document.getElementById('adminPasswordModal').classList.add('hidden');
                document.getElementById('admin_password').value = '';
                document.getElementById('passwordError').classList.add('hidden');
                redirectUrl = '';
            }
            async function verifyPassword(event) {
                event.preventDefault();
                const password   = document.getElementById('admin_password').value;
                const btn        = document.getElementById('verifyButton');
                const btnText    = document.getElementById('verifyButtonText');
                const btnSpinner = document.getElementById('verifyButtonSpinner');
                const errorDiv   = document.getElementById('passwordError');
                const errorMsg   = document.getElementById('passwordErrorMessage');

                btn.disabled = true;
                btnText.classList.add('hidden');
                btnSpinner.classList.remove('hidden');
                errorDiv.classList.add('hidden');

                try {
                    const res  = await fetch('{{ route("admin.verify") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ password })
                    });
                    const data = await res.json();
                    if (data.success) {
                        window.location.href = redirectUrl;
                    } else {
                        errorMsg.textContent = data.message || 'Incorrect password. Please try again.';
                        errorDiv.classList.remove('hidden');
                        errorDiv.classList.add('animate-shake');
                        setTimeout(() => errorDiv.classList.remove('animate-shake'), 500);
                        btn.disabled = false;
                        btnText.classList.remove('hidden');
                        btnSpinner.classList.add('hidden');
                        document.getElementById('admin_password').value = '';
                        document.getElementById('admin_password').focus();
                    }
                } catch (err) {
                    errorMsg.textContent = 'Network error. Please check your connection.';
                    errorDiv.classList.remove('hidden');
                    btn.disabled = false;
                    btnText.classList.remove('hidden');
                    btnSpinner.classList.add('hidden');
                }
            }
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && !document.getElementById('adminPasswordModal').classList.contains('hidden')) {
                    closePasswordModal();
                }
            });
            document.getElementById('adminPasswordModal')?.addEventListener('click', function(e) {
                if (e.target === this) closePasswordModal();
            });
        </script>

        @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded', () => showToast('{{ session('success') }}', 'success'));</script>
        @endif
        @if(session('error'))
        <script>document.addEventListener('DOMContentLoaded', () => showToast('{{ session('error') }}', 'error'));</script>
        @endif
        @if(session('warning'))
        <script>document.addEventListener('DOMContentLoaded', () => showToast('{{ session('warning') }}', 'warning'));</script>
        @endif
        @if(session('info'))
        <script>document.addEventListener('DOMContentLoaded', () => showToast('{{ session('info') }}', 'info'));</script>
        @endif
    </body>
</html>