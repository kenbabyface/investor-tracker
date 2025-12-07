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

            <!-- Consolidated ROI Dashboard Card -->
            <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200 mb-6 sm:mb-8">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        ROI Dashboard
                    </h3>
                </div>

                <div class="p-6">
                    <!-- Top Row: Key Metrics -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <!-- This Month -->
                        <div class="text-center p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <p class="text-xs font-medium text-gray-600 uppercase">This Month</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($totalRoiThisMonth, 2) }}</p>
                            <p class="text-xs text-blue-600 mt-1">{{ $roiThisMonth->count() }} payments</p>
                        </div>

                        <!-- Overdue -->
                        <div class="text-center p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                            <p class="text-xs font-medium text-gray-600 uppercase">Overdue</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($totalOverdue, 2) }}</p>
                            <p class="text-xs text-red-600 mt-1">{{ $overdueRoi->count() }} payments</p>
                        </div>

                        <!-- Next 30 Days -->
                        <div class="text-center p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                            <p class="text-xs font-medium text-gray-600 uppercase">Next 30 Days</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $upcomingRoi->count() }}</p>
                            <p class="text-xs text-green-600 mt-1">upcoming</p>
                        </div>

                        <!-- Total Pending -->
                        <div class="text-center p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                            <p class="text-xs font-medium text-gray-600 uppercase">Total Pending</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($totalRoiPending, 2) }}</p>
                            <p class="text-xs text-purple-600 mt-1">all unpaid</p>
                        </div>
                    </div>

                    <!-- Middle Row: Investment Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg mb-6">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Active Investments</p>
                            <p class="text-xl font-bold text-gray-900">${{ number_format($totalActiveInvestments, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">ROI Paid (All-Time)</p>
                            <p class="text-xl font-bold text-green-600">${{ number_format($totalRoiPaid, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Total ROI Generated</p>
                            <p class="text-xl font-bold text-purple-600">${{ number_format($totalRoiGenerated, 2) }}</p>
                        </div>
                    </div>

                    <!-- Bottom Row: Progress Bar & Actions -->
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex-1 w-full">
                            <div class="flex items-center justify-between text-sm mb-2">
                                <span class="text-gray-600">ROI Completion Rate</span>
                                @php
                                    $completionRate = $totalRoiGenerated > 0 ? ($totalRoiPaid / $totalRoiGenerated) * 100 : 0;
                                @endphp
                                <span class="font-bold text-purple-600">{{ number_format($completionRate, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-3 rounded-full transition-all" style="width: {{ $completionRate }}%"></div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('investments.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                                View All
                            </a>
                            <a href="{{ route('investments.history') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold rounded-lg transition">
                                History
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming ROI List -->
            @if($upcomingRoi->count() > 0)
                <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-blue-100 mb-6 sm:mb-8">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-900">Upcoming ROI Payments (Next 30 Days)</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($upcomingRoi as $investment)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $investment->investor->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $investment->investor->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right mr-6">
                                        <p class="font-bold text-green-600 text-lg">${{ number_format($investment->roi_amount, 2) }}</p>
                                        <p class="text-sm text-gray-500">ROI Amount</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">{{ $investment->roi_date->format('M d, Y') }}</p>
                                        @php
                                            $daysUntil = $investment->daysUntilRoi();
                                        @endphp
                                        @if($daysUntil == 0)
                                            <p class="text-sm text-orange-600 font-semibold">Due Today!</p>
                                        @elseif($daysUntil < 0)
                                            <p class="text-sm text-red-600 font-semibold">Overdue</p>
                                        @else
                                            <p class="text-sm text-yellow-600">In {{ $daysUntil }} days</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('investments.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                                View all investments
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Charts Section -->
            @if($totalInvestors > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 sm:mb-8">
                    <!-- Investment Trends Chart (2/3 width on desktop) -->
                    <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl rounded-xl border border-blue-100 p-5 sm:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Investment Trends</h3>
                            <span class="text-sm text-gray-500">Last 6 Months</span>
                        </div>
                        <div class="relative" style="height: 300px;">
                            <canvas id="investmentTrendsChart"></canvas>
                        </div>
                    </div>

                    <!-- Status Distribution Chart (1/3 width on desktop) -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-blue-100 p-5 sm:p-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Status Distribution</h3>
                            <p class="text-sm text-gray-500">Investor breakdown</p>
                        </div>
                        <div class="relative flex items-center justify-center" style="height: 250px;">
                            <canvas id="statusDistributionChart"></canvas>
                        </div>
                        <!-- Legend -->
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></div>
                                    <span class="text-sm text-gray-700">Active</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $activeInvestors }} ({{ $totalInvestors > 0 ? number_format(($activeInvestors / $totalInvestors) * 100, 1) : 0 }}%)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                                    <span class="text-sm text-gray-700">Pending</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $pendingInvestors }} ({{ $totalInvestors > 0 ? number_format(($pendingInvestors / $totalInvestors) * 100, 1) : 0 }}%)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                                    <span class="text-sm text-gray-700">Inactive</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $inactiveInvestors }} ({{ $totalInvestors > 0 ? number_format(($inactiveInvestors / $totalInvestors) * 100, 1) : 0 }}%)</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

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

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @if($totalInvestors > 0)
    <script>
        // Investment Trends Chart
        const investmentCtx = document.getElementById('investmentTrendsChart');
        
        const investmentData = {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Investment Amount ($)',
                data: @json($chartData),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        };

        const investmentConfig = {
            type: 'line',
            data: investmentData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: '600'
                            },
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += '$' + context.parsed.y.toLocaleString();
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            },
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        };

        new Chart(investmentCtx, investmentConfig);

        // Status Distribution Chart (Donut)
        const statusCtx = document.getElementById('statusDistributionChart');
        
        const statusData = {
            labels: ['Active', 'Pending', 'Inactive'],
            datasets: [{
                data: [{{ $activeInvestors }}, {{ $pendingInvestors }}, {{ $inactiveInvestors }}],
                backgroundColor: [
                    'rgb(16, 185, 129)',
                    'rgb(234, 179, 8)',
                    'rgb(239, 68, 68)'
                ],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 10
            }]
        };

        const statusConfig = {
            type: 'doughnut',
            data: statusData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        };

        new Chart(statusCtx, statusConfig);
    </script>
    @endif
</x-app-layout>