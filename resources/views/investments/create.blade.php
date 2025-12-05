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
                    <li class="flex items-center text-gray-500">Add Investment</li>
                </ol>
            </nav>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Investment') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="w-full ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-blue-100">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('investments.store') }}">
                        @csrf

                        <!-- Investor Selection -->
                        <div class="mb-6">
                            <label for="investor_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Investor <span class="text-red-500">*</span>
                            </label>
                            <select name="investor_id" id="investor_id" required
                                    class="block w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Investor</option>
                                @foreach($investors as $investor)
                                    <option value="{{ $investor->id }}" {{ old('investor_id') == $investor->id ? 'selected' : '' }}>
                                        {{ $investor->name }} ({{ $investor->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('investor_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Investment Amount -->
                        <div class="mb-6">
                            <label for="investment_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Investment Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" name="investment_amount" id="investment_amount" 
                                       value="{{ old('investment_amount') }}"
                                       step="0.01" min="0" required
                                       class="block w-full pl-8 border border-gray-300 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="10000.00">
                            </div>
                            @error('investment_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">ROI will be calculated automatically (20%)</p>
                        </div>

                        <!-- Investment Date -->
                        <div class="mb-6">
                            <label for="investment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Investment Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="investment_date" id="investment_date" 
                                   value="{{ old('investment_date', date('Y-m-d')) }}"
                                   required
                                   class="block w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('investment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">ROI date will be calculated automatically (+6 months)</p>
                        </div>

                        <!-- Investment Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Investment Type <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-start p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="investment_type" value="single_cycle" 
                                           {{ old('investment_type') == 'single_cycle' ? 'checked' : '' }}
                                           required
                                           class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3">
                                        <span class="block font-medium text-gray-900">Single Cycle (6 Months)</span>
                                        <span class="block text-sm text-gray-600 mt-1">Collect ROI (20%) + Capital (100%) after 6 months</span>
                                    </div>
                                </label>

                                <label class="flex items-start p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="investment_type" value="double_cycle"
                                           {{ old('investment_type') == 'double_cycle' ? 'checked' : '' }}
                                           required
                                           class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3">
                                        <span class="block font-medium text-gray-900">Double Cycle (12 Months)</span>
                                        <span class="block text-sm text-gray-600 mt-1">
                                            First 6 months: Collect ROI (20%) only<br>
                                            Second 6 months: Collect ROI (20%) + Capital (100%)
                                        </span>
                                    </div>
                                </label>
                            </div>
                            @error('investment_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Investment Details</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>ROI Rate: 20% per cycle</li>
                                            <li>Cycle Duration: 6 months</li>
                                            <li>ROI Date: Automatically calculated</li>
                                            <li>ROI Amount: Automatically calculated</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Investment
                            </button>
                            <a href="{{ route('investments.index') }}" 
                               class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>