<x-app-layout title="All Investors">
    <x-slot name="header">
        <div class="space-y-2 px-4 sm:px-0">
            <nav class="text-sm">
                <ol class="list-none p-0 inline-flex flex-wrap">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
                    </li>
                    <li class="flex items-center text-gray-500">Investors</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Investors') }}
                </h2>
                <a href="javascript:void(0)"  onclick="openPasswordModal('{{ route('investors.create') }}')" class="w-full sm:w-auto text-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2.5 px-4 sm:px-6 rounded-lg shadow-md transition flex items-center justify-center text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Investor
                </a>
 
                <a href="{{ route('investors.export') }}" class="flex-1 sm:flex-none text-center bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 sm:px-6 rounded-lg shadow-md transition flex items-center justify-center text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export to Excel
                </a>
                
            </div>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-4 shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-xl shadow-md border border-blue-100 p-4 sm:p-6 mb-6">
                <form method="GET" action="{{ route('investors.index') }}" class="space-y-4">
                    <!-- Search Bar -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search by name, email, or company..." 
                                       class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition flex items-center justify-center text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </button>
                    </div>

                    <!-- Toggle Filters Button (Mobile Only) -->
                    <button type="button" 
                            onclick="toggleFilters()" 
                            class="lg:hidden w-full flex items-center justify-between bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold py-2.5 px-4 rounded-lg transition text-sm border border-gray-300">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Advanced Filters
                            @if(request()->hasAny(['status', 'min_investment', 'max_investment', 'sort']))
                                <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs font-bold rounded-full">
                                    Active
                                </span>
                            @endif
                        </span>
                        <svg id="filter-arrow" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Filters Row (Collapsible on Mobile) -->
                    <div id="filters-section" class="hidden lg:block space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" class="block w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Min Investment Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Min Investment</label>
                                <input type="number" 
                                       name="min_investment" 
                                       value="{{ request('min_investment') }}"
                                       placeholder="0.00" 
                                       step="0.01"
                                       class="block w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>

                            <!-- Max Investment Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Max Investment</label>
                                <input type="number" 
                                       name="max_investment" 
                                       value="{{ request('max_investment') }}"
                                       placeholder="0.00" 
                                       step="0.01"
                                       class="block w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>

                            <!-- Sort By -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                <select name="sort" class="block w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                    <option value="amount_high" {{ request('sort') == 'amount_high' ? 'selected' : '' }}>Investment (High-Low)</option>
                                    <option value="amount_low" {{ request('sort') == 'amount_low' ? 'selected' : '' }}>Investment (Low-High)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-2 pt-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Apply Filters
                            </button>
                            <a href="{{ route('investors.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear All
                            </a>
                            @if(request()->hasAny(['search', 'status', 'min_investment', 'max_investment', 'sort']))
                                <div class="text-sm text-gray-600 flex items-center justify-center sm:ml-auto">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Filters active
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Count -->
            @if($investors->total() > 0)
                <div class="mb-4 text-sm text-gray-600">
                    <span class="font-semibold text-gray-900">{{ $investors->total() }}</span> 
                    {{ $investors->total() == 1 ? 'investor' : 'investors' }} found
                    @if(request()->hasAny(['search', 'status', 'min_investment', 'max_investment']))
                        <span class="text-blue-600">with active filters</span>
                    @endif
                </div>
            @endif

            <!-- Responsive Table -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-blue-100">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                                <tr>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider w-16">#</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Name</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider hidden sm:table-cell">Email</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider hidden md:table-cell">Company</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Investment</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider hidden lg:table-cell">Status</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider w-16">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($investors as $index => $investor)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="text-xs sm:text-sm font-semibold text-gray-700">
                                                {{ $investors->firstItem() + $index }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                                    <span class="text-white font-bold text-xs sm:text-sm">{{ substr($investor->name, 0, 1) }}</span>
                                                </div>
                                                <div class="ml-2 sm:ml-4">
                                                    <div class="text-xs sm:text-sm font-semibold text-gray-900">{{ $investor->name }}</div>
                                                    <div class="text-xs text-gray-500 sm:hidden">{{ $investor->email }}</div>
                                                    <div class="lg:hidden mt-1">
                                                        <span class="px-2 py-0.5 inline-flex text-xs leading-4 font-bold rounded-full 
                                                            @if($investor->status == 'active') bg-green-100 text-green-800
                                                            @elseif($investor->status == 'pending') bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            {{ ucfirst($investor->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden sm:table-cell">
                                            <div class="text-xs sm:text-sm text-gray-900">{{ $investor->email }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden md:table-cell">
                                            <div class="text-xs sm:text-sm text-gray-900">{{ $investor->company ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="text-xs sm:text-sm font-bold text-green-600">₦{{ number_format($investor->investment_amount, 2) }}</div>
                                            <div class="text-xs text-gray-500 md:hidden mt-0.5">{{ $investor->company ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden lg:table-cell">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                                @if($investor->status == 'active') bg-green-100 text-green-800
                                                @elseif($investor->status == 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($investor->status) }}
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                            <div class="relative inline-block text-left dropdown-{{ $investor->id }}">
                                                <button type="button" onclick="toggleDropdown({{ $investor->id }})" class="text-gray-600 hover:text-blue-600 p-1.5 sm:p-2 hover:bg-blue-50 rounded-lg transition focus:outline-none">
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                    </svg>
                                                </button>
                                                
                                                <div id="dropdown-menu-{{ $investor->id }}" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                    <div class="py-1" role="menu">
                                                        <a href="{{ route('investors.show', $investor) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                            View Details
                                                        </a>
                                                        <a href="{{ route('investors.edit', $investor) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                            Edit Investor
                                                        </a>
                                                        <hr class="my-1">
                                                        <form action="{{ route('investors.destroy', $investor) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this investor?')" class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                                Delete Investor
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="bg-blue-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 mb-4 text-base sm:text-lg">
                                                @if(request()->hasAny(['search', 'status', 'min_investment', 'max_investment']))
                                                    No investors found matching your filters.
                                                @else
                                                    No investors found. Add your first investor!
                                                @endif
                                            </p>
                                            @if(request()->hasAny(['search', 'status', 'min_investment', 'max_investment']))
                                                <a href="{{ route('investors.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition text-sm">
                                                    Clear Filters
                                                </a>
                                            @else
                                                <a href="{{ route('investors.create') }}" class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition shadow-md text-sm sm:text-base">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                    Add Investor
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($investors->hasPages())
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                <div class="text-sm text-gray-700 order-2 sm:order-1">
                                    Showing 
                                    <span class="font-semibold text-gray-900">{{ $investors->firstItem() }}</span>
                                    to 
                                    <span class="font-semibold text-gray-900">{{ $investors->lastItem() }}</span>
                                    of 
                                    <span class="font-semibold text-gray-900">{{ $investors->total() }}</span>
                                    investors
                                </div>
                                
                                <div class="order-1 sm:order-2">
                                    {{ $investors->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle filters section on mobile
        function toggleFilters() {
            const filtersSection = document.getElementById('filters-section');
            const filterArrow = document.getElementById('filter-arrow');
            
            filtersSection.classList.toggle('hidden');
            filterArrow.classList.toggle('rotate-180');
        }

        // Auto-expand filters if any filter is active (except search and sort)
        document.addEventListener('DOMContentLoaded', function() {
            const hasActiveFilters = {{ request()->hasAny(['status', 'min_investment', 'max_investment']) ? 'true' : 'false' }};
            
            if (hasActiveFilters && window.innerWidth < 1024) {
                const filtersSection = document.getElementById('filters-section');
                const filterArrow = document.getElementById('filter-arrow');
                if (filtersSection && filterArrow) {
                    filtersSection.classList.remove('hidden');
                    filterArrow.classList.add('rotate-180');
                }
            }
        });

        function toggleDropdown(id) {
            event.stopPropagation();
            const dropdown = document.getElementById('dropdown-menu-' + id);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-menu-"]');
            
            allDropdowns.forEach(d => {
                if (d.id !== 'dropdown-menu-' + id) {
                    d.classList.add('hidden');
                }
            });
            
            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function(event) {
            const allDropdowns = document.querySelectorAll('[id^="dropdown-menu-"]');
            allDropdowns.forEach(d => d.classList.add('hidden'));
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('[id^="dropdown-menu-"]');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });
        });
    </script>
</x-app-layout>