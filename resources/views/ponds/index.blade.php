<x-app-layout>
    <x-slot name="title">Ponds</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">
                Pond Management
            </h2>
            <a href="{{ route('ponds.create') }}"
               class="group inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-blue-500/30 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Pond
            </a>
        </div>
    </x-slot>

    <div class="p-6 space-y-5 max-w-7l mx-auto">

       
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-200 shadow-sm">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Manage Your Ponds</h3>
                <p class="text-sm text-gray-600 mt-1">Create ponds to track feed consumption and monitor your aquaculture operations.</p>
            </div>
            <a href="{{ route('ponds.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-blue-500/30 transition-all duration-300 hover:scale-105 hover:shadow-xl whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create New Pond
            </a>
        </div>

      
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="relative overflow-hidden bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-100 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Total Ponds</p>
                        <span class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-4xl font-extrabold text-gray-800">{{ $ponds->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">Active water bodies</p>
                </div>
            </div>

            <div class="relative overflow-hidden bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-green-100 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Total Fish Stocked</p>
                        <span class="p-2 bg-green-100 rounded-lg text-green-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-4xl font-extrabold text-gray-800">{{ number_format($ponds->sum('stock_count')) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Fish population</p>
                </div>
            </div>

            <div class="relative overflow-hidden bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-purple-100 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-purple-600 uppercase tracking-wider">Total Feed Cost</p>
                        <span class="p-2 bg-purple-100 rounded-lg text-purple-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-4xl font-extrabold text-gray-800">₦{{ number_format($ponds->sum('feed_logs_sum_total_cost'), 2) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Cumulative investment</p>
                </div>
            </div>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="bg-white rounded-2xl shadow-md p-4 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="relative flex-1 w-full max-w-md">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="pondSearch" placeholder="Search ponds by name or species..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
            </div>
            <div class="flex gap-2">
                <select id="statusFilter" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white text-sm font-medium text-gray-700 cursor-pointer hover:border-gray-300 transition-colors">
                    <option value="all">All Status</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Inactive Only</option>
                </select>
            </div>
        </div>

        {{-- Ponds Grid --}}
        @if($ponds->isEmpty())
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl shadow-xl p-16 text-center border border-gray-100">
                <div class="relative inline-block mb-6">
                    <div class="absolute inset-0 bg-blue-200 rounded-full blur-xl opacity-30 animate-pulse"></div>
                    <div class="relative text-8xl transform hover:scale-110 transition-transform duration-300 cursor-default">🏊</div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No ponds found</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Start your aquaculture journey by creating your first pond.</p>
                
                {{-- BIG VISIBLE BUTTON IN EMPTY STATE --}}
                <a href="{{ route('ponds.create') }}"
                   class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold px-10 py-5 rounded-2xl shadow-lg shadow-blue-500/30 transition-all duration-300 hover:scale-105 hover:shadow-xl text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Your First Pond
                </a>
            </div>
        @else
            <div id="pondsGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($ponds as $pond)
                <div class="pond-card group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col overflow-hidden transform hover:-translate-y-1" 
                     data-name="{{ strtolower($pond->name) }}" 
                     data-species="{{ strtolower($pond->species ?? '') }}"
                     data-status="{{ $pond->is_active ? 'active' : 'inactive' }}">
                    
                    {{-- Card Header with Gradient --}}
                    <div class="relative h-24 bg-gradient-to-r from-blue-500 to-cyan-400 overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-10"></div>
                        <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-white opacity-10 rounded-full"></div>
                        <div class="absolute top-4 left-4 flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-2xl shadow-lg">
                                🏊
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white drop-shadow-md">{{ $pond->name }}</h3>
                                @if($pond->species)
                                    <p class="text-xs text-blue-50 font-medium">{{ $pond->species }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="absolute top-4 right-4 flex gap-2">
                            @if(!$pond->is_active)
                                <span class="px-2 py-1 bg-gray-800/50 backdrop-blur-sm text-gray-100 text-xs font-bold rounded-lg border border-gray-600/30">
                                    Inactive
                                </span>
                            @else
                                <span class="px-2 py-1 bg-green-500/50 backdrop-blur-sm text-white text-xs font-bold rounded-lg border border-green-400/30 animate-pulse">
                                    Active
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-5 flex-1">
                        {{-- Stats Grid --}}
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-3 text-center border border-blue-200 group-hover:border-blue-300 transition-colors">
                                <p class="text-xs text-blue-600 font-bold uppercase tracking-wide mb-1">Stock Count</p>
                                <p class="text-2xl font-black text-blue-700">{{ number_format($pond->stock_count) }}</p>
                                <p class="text-[10px] text-blue-500 font-medium">fish</p>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-3 text-center border border-green-200 group-hover:border-green-300 transition-colors">
                                <p class="text-xs text-green-600 font-bold uppercase tracking-wide mb-1">Feed Used</p>
                                <p class="text-2xl font-black text-green-700">{{ number_format($pond->feed_logs_sum_quantity_kg ?? 0, 0) }}</p>
                                <p class="text-[10px] text-green-500 font-medium">Bags</p>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-3 text-center col-span-2 border border-purple-200 group-hover:border-purple-300 transition-colors relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-16 h-16 bg-purple-200 rounded-full -mr-8 -mt-8 opacity-20"></div>
                                <p class="text-xs text-purple-600 font-bold uppercase tracking-wide mb-1 relative z-10">Total Investment</p>
                                <p class="text-2xl font-black text-purple-700 relative z-10">₦{{ number_format($pond->feed_logs_sum_total_cost ?? 0, 2) }}</p>
                            </div>
                             <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-3 text-center col-span-2 border border-purple-200 group-hover:border-purple-300 transition-colors relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-16 h-16 bg-purple-200 rounded-full -mr-8 -mt-8 opacity-20"></div>
                                <p class="text-xs text-purple-600 font-bold uppercase tracking-wide mb-1 relative z-10">Total KG</p>
                                <p class="text-2xl font-black text-purple-700 relative z-10">{{ number_format($pond->feed_logs_sum_quantity_kg?? 0, 2) }}</p>
                            </div>
                        </div>

                        {{-- Meta Info --}}
                        <div class="flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                @if($pond->stocked_at)
                                    <span>Stocked {{ $pond->stocked_at->diffForHumans() }}</span>
                                @else
                                    <span>Not stocked yet</span>
                                @endif
                            </div>
                            <a href="{{ route('ponds.edit', $pond) }}" 
                               class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200" 
                               title="Edit Pond">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="px-5 pb-5 flex gap-3">
                        <a href="{{ route('ponds.show', $pond) }}"
                           class="flex-1 flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold py-3 rounded-xl transition-all duration-200 hover:shadow-lg transform hover:scale-[1.02]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Details
                        </a>
                        <a href="{{ route('feed-logs.create') }}?pond_id={{ $pond->id }}"
                           class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-sm font-bold py-3 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-green-500/30 transform hover:scale-[1.02]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Log Feed
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- FLOATING ACTION BUTTON (Mobile) - Always visible --}}
    <a href="{{ route('ponds.create') }}" 
       class="fixed bottom-6 right-6 md:hidden z-50 w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg shadow-blue-500/40 flex items-center justify-center transition-transform hover:scale-110 active:scale-95">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
    </a>

    @push('scripts')
    <script>
        // Search functionality
        document.getElementById('pondSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.pond-card');
            
            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const species = card.getAttribute('data-species');
                
                if (name.includes(searchTerm) || species.includes(searchTerm)) {
                    card.style.display = 'flex';
                    card.classList.add('animate-fade-in');
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            const filter = e.target.value;
            const cards = document.querySelectorAll('.pond-card');
            
            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                
                if (filter === 'all' || status === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
    @endpush
</x-app-layout>