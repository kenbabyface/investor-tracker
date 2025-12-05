<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2 px-4 sm:px-0">
            <nav class="text-sm">
                <ol class="list-none p-0 inline-flex flex-wrap">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('investments.index') }}" class="text-blue-600 hover:text-blue-800">Investments</a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
                    </li>
                    <li class="flex items-center text-gray-500">History</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Investment History') }}
                </h2>
                <a href="{{ route('investments.index') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2.5 px-4 sm:px-6 rounded-lg shadow-md transition flex items-center justify-center text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Active Investments
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Results Count -->
            @if($history->total() > 0)
                <div class="mb-4 text-sm text-gray-600">
                    <span class="font-semibold text-gray-900">{{ $history->total() }}</span> 
                    completed {{ $history->total() == 1 ? 'investment' : 'investments' }}
                </div>
            @endif

            <!-- Responsive Table -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-green-100">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-green-50 to-green-100">
                                <tr>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-green-900 uppercase tracking-wider w-16">#</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-green-900 uppercase tracking-wider">Investor</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-green-900 uppercase tracking-wider hidden md:table-cell">Amount</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-green-900 uppercase tracking-wider hidden lg:table-cell">Inv. Date</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-green-900 uppercase tracking-wider hidden lg:table-cell">ROI Date</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-green-900 uppercase tracking-wider">ROI Paid</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-green-900 uppercase tracking-wider hidden sm:table-cell">Payment Date</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-green-900 uppercase tracking-wider hidden xl:table-cell">Cycle</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($history as $index => $record)
                                    <tr class="hover:bg-green-50 transition">
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="text-xs sm:text-sm font-semibold text-gray-700">
                                                {{ $history->firstItem() + $index }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="text-xs sm:text-sm font-semibold text-gray-900">{{ $record->investor->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $record->investor->email }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden md:table-cell">
                                            <div class="text-xs sm:text-sm font-bold text-gray-900">${{ number_format($record->investment_amount, 2) }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden lg:table-cell">
                                            <div class="text-xs sm:text-sm text-gray-900">{{ $record->investment_date->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden lg:table-cell">
                                            <div class="text-xs sm:text-sm text-gray-900">{{ $record->roi_date->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="text-xs sm:text-sm font-bold text-green-600">${{ number_format($record->roi_amount, 2) }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden sm:table-cell">
                                            <div class="text-xs sm:text-sm text-gray-900">{{ $record->payment_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $record->payment_date->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 hidden xl:table-cell">
                                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-800 font-semibold">
                                                {{ $record->cycle_completed }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <div class="bg-green-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 mb-4 text-base sm:text-lg">No completed investments yet.</p>
                                            <a href="{{ route('investments.index') }}" class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition shadow-md text-sm sm:text-base">
                                                View Active Investments
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($history->hasPages())
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-4"> 
                                <div class="order-1 sm:order-2">
                                    {{ $history->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>