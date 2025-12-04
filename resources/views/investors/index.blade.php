<x-app-layout :title="'Investors - Twintiamiyu Investor Tracker'">
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
                <a href="{{ route('investors.create') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2.5 px-4 sm:px-6 rounded-lg shadow-md transition flex items-center justify-center text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Investor
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
                                                    <!-- Show email on mobile only -->
                                                    <div class="text-xs text-gray-500 sm:hidden">{{ $investor->email }}</div>
                                                    <!-- Show status on mobile/tablet -->
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
                                            <div class="text-xs sm:text-sm font-bold text-green-600">${{ number_format($investor->investment_amount, 2) }}</div>
                                            <!-- Show company on mobile -->
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 mb-4 text-base sm:text-lg">No investors found. Add your first investor!</p>
                                            <a href="{{ route('investors.create') }}" class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition shadow-md text-sm sm:text-base">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Add Investor
                                            </a>
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
                                
                                <!-- Pagination links -->
                                <div class="order-1 sm:order-2">
                                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
                                        <div class="flex items-center space-x-1">
                                            {{-- Previous Page Link --}}
                                            @if ($investors->onFirstPage())
                                                <span class="relative inline-flex items-center px-2 sm:px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 cursor-not-allowed rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                    <span class="hidden sm:inline ml-1">Prev</span>
                                                </span>
                                            @else
                                                <a href="{{ $investors->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 sm:px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                    <span class="hidden sm:inline ml-1">Prev</span>
                                                </a>
                                            @endif

                                            {{-- Page Numbers --}}
                                            @foreach ($investors->getUrlRange(1, $investors->lastPage()) as $page => $url)
                                                @if ($page == $investors->currentPage())
                                                    <span class="relative inline-flex items-center px-3 sm:px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border border-blue-600 rounded-lg shadow-sm">
                                                        {{ $page }}
                                                    </span>
                                                @else
                                                    <a href="{{ $url }}" class="relative hidden sm:inline-flex items-center px-3 sm:px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition">
                                                        {{ $page }}
                                                    </a>
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($investors->hasMorePages())
                                                <a href="{{ $investors->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 sm:px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition">
                                                    <span class="hidden sm:inline mr-1">Next</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            @else
                                                <span class="relative inline-flex items-center px-2 sm:px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 cursor-not-allowed rounded-lg">
                                                    <span class="hidden sm:inline mr-1">Next</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            event.stopPropagation();
            const dropdown = document.getElementById('dropdown-menu-' + id);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-menu-"]');
            
            // Close all other dropdowns
            allDropdowns.forEach(d => {
                if (d.id !== 'dropdown-menu-' + id) {
                    d.classList.add('hidden');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            const allDropdowns = document.querySelectorAll('[id^="dropdown-menu-"]');
            allDropdowns.forEach(d => d.classList.add('hidden'));
        });

        // Prevent dropdown from closing when clicking inside it
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