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
                    <li class="flex items-center text-gray-500">Details</li>
                </ol>
            </nav>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Investment Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Investor Info Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-blue-100 mb-6">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                    <h3 class="text-lg font-semibold text-blue-900">Investor Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">{{ substr($investment->investor->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-900">{{ $investment->investor->name }}</h4>
                            <p class="text-gray-600">{{ $investment->investor->email }}</p>
                            @if($investment->investor->phone)
                                <p class="text-gray-600">{{ $investment->investor->phone }}</p>
                            @endif
                        </div>
                    </div>
                    @if($investment->investor->company)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <span class="text-sm font-medium text-gray-500">Company:</span>
                            <span class="text-sm text-gray-900 ml-2">{{ $investment->investor->company }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Investment Details Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-blue-100 mb-6">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                    <h3 class="text-lg font-semibold text-blue-900">Investment Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Investment Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Investment Amount</label>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($investment->investment_amount, 2) }}</p>
                        </div>

                        <!-- ROI Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">ROI Amount (20%)</label>
                            <p class="text-2xl font-bold text-green-600">${{ number_format($investment->roi_amount, 2) }}</p>
                        </div>

                        <!-- Investment Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Investment Date</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $investment->investment_date->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $investment->investment_date->diffForHumans() }}</p>
                        </div>

                        <!-- ROI Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">ROI Due Date</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $investment->roi_date->format('M d, Y') }}</p>
                            @php
                                $daysUntil = $investment->daysUntilRoi();
                            @endphp
                            @if($daysUntil < 0)
                                <p class="text-sm font-semibold text-red-600">Overdue by {{ abs($daysUntil) }} days</p>
                            @elseif($daysUntil == 0)
                                <p class="text-sm font-semibold text-orange-600">Due Today!</p>
                            @elseif($daysUntil <= 30)
                                <p class="text-sm text-yellow-600">Due in {{ $daysUntil }} days</p>
                            @else
                                <p class="text-sm text-gray-500">Due in {{ $daysUntil }} days</p>
                            @endif
                        </div>

                        <!-- Investment Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Investment Type</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                {{ $investment->investment_type == 'single_cycle' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                @if($investment->investment_type == 'single_cycle')
                                    Single Cycle (6 Months)
                                @else
                                    Double Cycle (12 Months) - Cycle {{ $investment->cycle_number }}/2
                                @endif
                            </span>
                            <p class="text-sm text-gray-500 mt-2">
                                @if($investment->investment_type == 'single_cycle')
                                    ROI + Capital at end of 6 months
                                @else
                                    @if($investment->cycle_number == 1)
                                        First 6 months: ROI only
                                    @else
                                        Second 6 months: ROI + Capital
                                    @endif
                                @endif
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Payment Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                {{ $investment->roi_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($investment->roi_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expected Returns Card -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 overflow-hidden shadow-xl sm:rounded-xl border-2 border-green-200 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4">Expected Returns</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow">
                            <p class="text-sm text-gray-600 mb-1">Total Return</p>
                            @if($investment->investment_type == 'single_cycle')
                                <p class="text-2xl font-bold text-green-600">${{ number_format($investment->investment_amount + $investment->roi_amount, 2) }}</p>
                                <p class="text-xs text-gray-500 mt-1">Capital + ROI</p>
                            @else
                                @if($investment->cycle_number == 1)
                                    <p class="text-2xl font-bold text-green-600">${{ number_format($investment->roi_amount, 2) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">ROI Only (Cycle 1)</p>
                                @else
                                    <p class="text-2xl font-bold text-green-600">${{ number_format($investment->investment_amount + $investment->roi_amount, 2) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Capital + ROI (Cycle 2)</p>
                                @endif
                            @endif
                        </div>

                        @if($investment->investment_type == 'double_cycle' && $investment->cycle_number == 1)
                            <div class="bg-white rounded-lg p-4 shadow">
                                <p class="text-sm text-gray-600 mb-1">Next Cycle Return</p>
                                <p class="text-2xl font-bold text-blue-600">${{ number_format($investment->investment_amount + $investment->roi_amount, 2) }}</p>
                                <p class="text-xs text-gray-500 mt-1">After Cycle 2</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Generate Agreement Button (Only for pending ROI) -->
                @if($investment->roi_status == 'pending')
                    <a href="{{ route('investments.generate-agreement', $investment) }}" 
                       class="flex-1 text-center bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-3 px-6 rounded-lg shadow-md transition flex items-center justify-center transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Generate Agreement
                    </a>
                @endif

                <!-- Mark as Paid Button -->
                @if($investment->roi_status == 'pending')
                    <form action="{{ route('investments.markAsPaid', $investment) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" onclick="return confirm('Mark this ROI as paid?')" 
                                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow-md transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mark as Paid
                        </button>
                    </form>
                @endif

                <!-- Back Button -->
                <a href="{{ route('investments.index') }}" 
                   class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg transition flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Investments
                </a>

                <!-- Delete Button -->
                <form action="{{ route('investments.destroy', $investment) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this investment?')" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>