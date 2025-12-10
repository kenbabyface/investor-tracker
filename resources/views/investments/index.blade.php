<x-app-layout title="All Investments">
    <x-slot name="header">
        <div class="space-y-2 px-4 sm:px-0">
            <nav class="text-sm">
                <ol class="list-none p-0 inline-flex flex-wrap">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
                    </li>
                    <li class="flex items-center text-gray-500">Investments</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Active Investments') }}
                </h2>
                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="{{ route('investments.create') }}" class="flex-1 sm:flex-none text-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2.5 px-4 sm:px-6 rounded-lg shadow-md transition flex items-center justify-center text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Investment
                    </a>

                    <a href="{{ route('investments.export') }}" class="flex-1 sm:flex-none text-center bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-md transition flex items-center justify-center text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export
                    </a>
                    <a href="{{ route('investments.history') }}" class="flex-1 sm:flex-none text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2.5 px-4 rounded-lg transition flex items-center justify-center text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        History
                    </a>
                </div>
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

            <!-- Results Count -->
            @if($investments->total() > 0)
                <div class="mb-4 text-sm text-gray-600">
                    <span class="font-semibold text-gray-900">{{ $investments->total() }}</span> 
                    {{ $investments->total() == 1 ? 'investment' : 'investments' }} found
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
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Investor</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider hidden md:table-cell">Amount</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider hidden lg:table-cell">Inv. Date</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">ROI Date</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider hidden sm:table-cell">ROI Amount</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider hidden lg:table-cell">Type</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider hidden lg:table-cell">Status</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider w-16">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($investments as $index => $investment)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="text-xs sm:text-sm font-semibold text-gray-700">
                                                {{ $investments->firstItem() + $index }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="text-xs sm:text-sm font-semibold text-gray-900">{{ $investment->investor->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $investment->investor->email }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden md:table-cell">
                                            <div class="text-xs sm:text-sm font-bold text-gray-900">₦{{ number_format($investment->investment_amount, 2) }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden lg:table-cell">
                                            <div class="text-xs sm:text-sm text-gray-900">{{ $investment->investment_date->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="text-xs sm:text-sm font-semibold text-gray-900">{{ $investment->roi_date->format('M d, Y') }}</div>
                                            @php
                                                $daysUntil = $investment->daysUntilRoi();
                                            @endphp
                                            @if($daysUntil < 0)
                                                <div class="text-xs text-red-600 font-semibold">Overdue by {{ abs($daysUntil) }} days</div>
                                            @elseif($daysUntil == 0)
                                                <div class="text-xs text-orange-600 font-semibold">Due Today!</div>
                                            @elseif($daysUntil <= 30)
                                                <div class="text-xs text-yellow-600">Due in {{ $daysUntil }} days</div>
                                            @else
                                                <div class="text-xs text-gray-500">{{ $daysUntil }} days</div>
                                            @endif
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden sm:table-cell">
                                            <div class="text-xs sm:text-sm font-bold text-green-600">₦{{ number_format($investment->roi_amount, 2) }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden lg:table-cell">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $investment->investment_type == 'single_cycle' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                {{ $investment->investment_type == 'single_cycle' ? 'Single' : 'Double' }}
                                                @if($investment->investment_type == 'double_cycle')
                                                    ({{ $investment->cycle_number }}/2)
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden lg:table-cell">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $investment->roi_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($investment->roi_status) }}
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                            <div class="relative inline-block text-left dropdown-{{ $investment->id }}">
                                                <button type="button" onclick="toggleDropdown({{ $investment->id }})" class="text-gray-600 hover:text-blue-600 p-1.5 sm:p-2 hover:bg-blue-50 rounded-lg transition focus:outline-none">
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                    </svg>
                                                </button>
                                                
                                                <div id="dropdown-menu-{{ $investment->id }}" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                    <div class="py-1" role="menu">
                                                        <a href="{{ route('investments.show', $investment) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                            View Details
                                                        </a>
                                                        @if($investment->roi_status == 'pending')
                                                            <form action="{{ route('investments.markAsPaid', $investment) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" onclick="return confirm('Mark this ROI as paid?')" class="w-full flex items-center px-4 py-3 text-sm text-green-600 hover:bg-green-50 transition text-left">
                                                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                    </svg>
                                                                    Mark as Paid
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <hr class="my-1">
                                                        <form action="{{ route('investments.destroy', $investment) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Delete this investment?')" class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                                Delete Investment
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-12 text-center">
                                            <div class="bg-blue-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 mb-4 text-base sm:text-lg">No active investments found.</p>
                                            <a href="{{ route('investments.create') }}" class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition shadow-md text-sm sm:text-base">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Add Investment
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($investments->hasPages())
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                <div class="text-sm text-gray-700 order-2 sm:order-1">
                                    Showing 
                                    <span class="font-semibold text-gray-900">{{ $investments->firstItem() }}</span>
                                    to 
                                    <span class="font-semibold text-gray-900">{{ $investments->lastItem() }}</span>
                                    of 
                                    <span class="font-semibold text-gray-900">{{ $investments->total() }}</span>
                                    investments
                                </div>
                                
                                <div class="order-1 sm:order-2">
                                    {{ $investments->links() }}
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