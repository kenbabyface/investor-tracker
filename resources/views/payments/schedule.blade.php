<x-app-layout title="Payment Schedule">
    <x-slot name="header">
        <div class="space-y-2">
            <!-- Breadcrumb -->
           <nav class="text-sm">
                <ol class="list-none p-0 inline-flex flex-wrap items-center">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                        </svg>
                    </li>
                    <li class="flex items-center text-gray-500 font-medium">Payment Schedule</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        {{ __('Payment Schedule') }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Track all upcoming ROI payments by month</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Capital to Return -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Total Capital</p>
                    <p class="text-3xl font-bold text-gray-900">₦{{ number_format($summary['total_capital'], 2) }}</p>
                    <p class="text-gray-500 text-xs mt-2">To be returned to investors</p>
                </div>

                <!-- Total ROI to Pay -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Total ROI</p>
                    <p class="text-3xl font-bold text-green-600">₦{{ number_format($summary['total_roi'], 2) }}</p>
                    <p class="text-gray-500 text-xs mt-2">Profit to investors</p>
                </div>

                <!-- Grand Total -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Grand Total</p>
                    <p class="text-3xl font-bold text-gray-900">₦{{ number_format($summary['grand_total'], 2) }}</p>
                    <p class="text-gray-500 text-xs mt-2">All payments combined</p>
                </div>

                <!-- Total Months -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-orange-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Payment Months</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $summary['total_months'] }}</p>
                    <p class="text-gray-500 text-xs mt-2">Months with payments</p>
                </div>
            </div>

            <!-- Month Filter -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-200">
                <form method="GET" action="{{ route('payments.schedule') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-1">
                        <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">
                            Select Month
                        </label>
                        <input type="month" 
                               id="month" 
                               name="month" 
                               value="{{ $selectedDate->format('Y-m') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition duration-200 shadow-lg">
                        View Month
                    </button>
                    <a href="{{ route('payments.schedule') }}" 
                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition duration-200 text-center">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Monthly Payment Breakdown -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">
                        {{ $selectedDate->format('F Y') }} - Payment Breakdown
                    </h3>
                </div>

                <div class="p-6 space-y-8">
                    
                    <!-- Single Cycle Payments -->
                    @if(count($monthlyPayments['single_cycle']) > 0)
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 ml-3">Single Cycle Payments (Capital + ROI)</h4>
                        </div>

                        <div class="bg-blue-50 rounded-xl overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-blue-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Investor</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Capital</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">ROI (20%)</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Total Payment</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Due Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-blue-200">
                                    @foreach($monthlyPayments['single_cycle'] as $payment)
                                    <tr class="hover:bg-blue-100 transition">
                                        <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                            {{ $payment['investor_name'] }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-700">
                                            ₦{{ number_format($payment['capital'], 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-green-600 font-semibold">
                                            ₦{{ number_format($payment['roi'], 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right font-bold text-gray-900">
                                            ₦{{ number_format($payment['total'], 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center text-gray-600">
                                            {{ $payment['due_date']->format('M d, Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-blue-200 font-bold">
                                        <td class="px-4 py-3 text-sm">SUBTOTAL</td>
                                        <td class="px-4 py-3 text-sm text-right">
                                            ₦{{ number_format(collect($monthlyPayments['single_cycle'])->sum('capital'), 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-green-700">
                                            ₦{{ number_format(collect($monthlyPayments['single_cycle'])->sum('roi'), 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">
                                            ₦{{ number_format($monthlyPayments['totals']['single_cycle_total'], 2) }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Double Cycle - First Payment (ROI Only) -->
                    @if(count($monthlyPayments['double_cycle_first']) > 0)
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 ml-3">Double Cycle - First Payment (ROI Only)</h4>
                        </div>

                        <div class="bg-green-50 rounded-xl overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-green-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Investor</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">ROI (20%)</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Due Date</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Note</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-green-200">
                                    @foreach($monthlyPayments['double_cycle_first'] as $payment)
                                    <tr class="hover:bg-green-100 transition">
                                        <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                            {{ $payment['investor_name'] }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right font-bold text-green-600">
                                            ₦{{ number_format($payment['roi'], 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center text-gray-600">
                                            {{ $payment['due_date']->format('M d, Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-center text-gray-500 italic">
                                            Capital reinvested
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-green-200 font-bold">
                                        <td class="px-4 py-3 text-sm">SUBTOTAL</td>
                                        <td class="px-4 py-3 text-sm text-right text-green-700">
                                            ₦{{ number_format($monthlyPayments['totals']['double_cycle_first_total'], 2) }}
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Double Cycle - Second Payment (Capital + ROI) -->
                    @if(count($monthlyPayments['double_cycle_second']) > 0)
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 ml-3">Double Cycle - Second Payment (Capital + ROI)</h4>
                        </div>

                        <div class="bg-purple-50 rounded-xl overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-purple-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Investor</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Capital</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">ROI (20%)</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Total Payment</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Due Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-purple-200">
                                    @foreach($monthlyPayments['double_cycle_second'] as $payment)
                                    <tr class="hover:bg-purple-100 transition">
                                        <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                            {{ $payment['investor_name'] }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-700">
                                            ₦{{ number_format($payment['capital'], 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-green-600 font-semibold">
                                            ₦{{ number_format($payment['roi'], 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right font-bold text-gray-900">
                                            ₦{{ number_format($payment['total'], 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center text-gray-600">
                                            {{ $payment['due_date']->format('M d, Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-purple-200 font-bold">
                                        <td class="px-4 py-3 text-sm">SUBTOTAL</td>
                                        <td class="px-4 py-3 text-sm text-right">
                                            ₦{{ number_format(collect($monthlyPayments['double_cycle_second'])->sum('capital'), 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-green-700">
                                            ₦{{ number_format(collect($monthlyPayments['double_cycle_second'])->sum('roi'), 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">
                                            ₦{{ number_format($monthlyPayments['totals']['double_cycle_second_total'], 2) }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- No Payments -->
                    @if(count($monthlyPayments['single_cycle']) == 0 && count($monthlyPayments['double_cycle_first']) == 0 && count($monthlyPayments['double_cycle_second']) == 0)
                    <div class="text-center py-12">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No Payments Due</h3>
                        <p class="text-gray-500">No payments scheduled for {{ $selectedDate->format('F Y') }}</p>
                    </div>
                    @endif

                    <!-- Month Total -->
                    @if($monthlyPayments['totals']['grand_total'] > 0)
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl p-6 text-white">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                            <div>
                                <h4 class="text-lg font-bold mb-2">{{ $selectedDate->format('F Y') }} TOTAL</h4>
                                <div class="flex gap-6 text-sm">
                                    <div>
                                        <span class="text-gray-300">Capital:</span>
                                        <span class="font-semibold ml-2">₦{{ number_format($monthlyPayments['totals']['total_capital'], 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-300">ROI:</span>
                                        <span class="font-semibold ml-2 text-green-400">₦{{ number_format($monthlyPayments['totals']['total_roi'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center md:text-right">
                                <p class="text-sm text-gray-300 mb-1">Grand Total</p>
                                <p class="text-4xl font-bold">₦{{ number_format($monthlyPayments['totals']['grand_total'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- All Months Overview -->
            @if(count($paymentsByMonth) > 0)
            <div class="mt-8 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">All Months Overview</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($paymentsByMonth as $month => $data)
                        <a href="{{ route('payments.schedule', ['month' => $month]) }}" 
                           class="block p-4 rounded-xl border-2 {{ $month === $selectedDate->format('Y-m') ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300 bg-gray-50' }} transition">
                            <div class="flex justify-between items-start mb-2">
                                <h5 class="font-bold text-gray-800">{{ Carbon\Carbon::parse($month . '-01')->format('F Y') }}</h5>
                                @if($data['totals']['grand_total'] > 0)
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                    {{ count($data['single_cycle']) + count($data['double_cycle_first']) + count($data['double_cycle_second']) }} payments
                                </span>
                                @endif
                            </div>
                            <p class="text-2xl font-bold text-gray-900">₦{{ number_format($data['totals']['grand_total'], 2) }}</p>
                            <div class="mt-2 text-xs text-gray-600 space-y-1">
                                @if(count($data['single_cycle']) > 0)
                                <p>• Single Cycle: ₦{{ number_format($data['totals']['single_cycle_total'], 2) }}</p>
                                @endif
                                @if(count($data['double_cycle_first']) > 0)
                                <p>• Double (1st): ₦{{ number_format($data['totals']['double_cycle_first_total'], 2) }}</p>
                                @endif
                                @if(count($data['double_cycle_second']) > 0)
                                <p>• Double (2nd): ₦{{ number_format($data['totals']['double_cycle_second_total'], 2) }}</p>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>