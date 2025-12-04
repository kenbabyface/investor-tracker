<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">Here's what's happening with your investors today.</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <!-- Total Investors Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-blue-100 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Investors</p>
                                <p class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">{{ $totalInvestors }}</p>
                                @if($totalInvestors > 0)
                                    <p class="mt-2 text-xs sm:text-sm text-gray-500">
                                        <span class="text-green-600 font-semibold">↑ Active platform</span>
                                    </p>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-full p-3 sm:p-4 shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 px-5 sm:px-6 py-3">
                        <a href="{{ route('investors.index') }}" class="text-xs sm:text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                            View all investors
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Total Investment Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-green-100 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Investment</p>
                                <p class="mt-2 text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900">${{ number_format($totalInvestment, 0) }}</p>
                                @if($totalInvestment > 0)
                                    <p class="mt-2 text-xs sm:text-sm text-gray-500">
                                        <span class="text-green-600 font-semibold">{{ $totalInvestors }} investors</span>
                                    </p>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-full p-3 sm:p-4 shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 px-5 sm:px-6 py-3">
                        <div class="text-xs sm:text-sm font-medium text-green-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Total capital raised
                        </div>
                    </div>
                </div>

                <!-- Active Investors Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-emerald-100 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Active</p>
                                <p class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">{{ $activeInvestors }}</p>
                                @if($totalInvestors > 0)
                                    <p class="mt-2 text-xs sm:text-sm text-gray-500">
                                        <span class="text-emerald-600 font-semibold">{{ $totalInvestors > 0 ? number_format(($activeInvestors / $totalInvestors) * 100, 1) : 0 }}%</span> of total
                                    </p>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full p-3 sm:p-4 shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-emerald-50 px-5 sm:px-6 py-3">
                        <a href="{{ route('investors.index', ['status' => 'active']) }}" class="text-xs sm:text-sm font-medium text-emerald-600 hover:text-emerald-800 flex items-center">
                            View active investors
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Pending Investors Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-yellow-100 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Pending</p>
                                <p class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">{{ $pendingInvestors }}</p>
                                @if($totalInvestors > 0)
                                    <p class="mt-2 text-xs sm:text-sm text-gray-500">
                                        <span class="text-yellow-600 font-semibold">{{ $totalInvestors > 0 ? number_format(($pendingInvestors / $totalInvestors) * 100, 1) : 0 }}%</span> of total
                                    </p>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full p-3 sm:p-4 shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow-50 px-5 sm:px-6 py-3">
                        <a href="{{ route('investors.index', ['status' => 'pending']) }}" class="text-xs sm:text-sm font-medium text-yellow-600 hover:text-yellow-800 flex items-center">
                            View pending investors
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-blue-100 p-5 sm:p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <a href="{{ route('investors.create') }}" class="flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Investor
                    </a>
                    <a href="{{ route('investors.index') }}" class="flex items-center justify-center bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-lg shadow-md border-2 border-gray-300 transition transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View All Investors
                    </a>
                    <a href="{{ route('investors.index', ['status' => 'pending']) }}" class="flex items-center justify-center bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-lg shadow-md border-2 border-gray-300 transition transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Review Pending
                    </a>
                </div>
            </div>

            <!-- Empty State (if no investors) -->
            @if($totalInvestors == 0)
                <div class="mt-8 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 sm:p-12 text-center border border-blue-200">
                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Get Started with Your First Investor</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Start building your investor portfolio by adding your first investor to the system.</p>
                    <a href="{{ route('investors.create') }}" class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Your First Investor
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>