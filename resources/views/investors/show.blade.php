<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <nav class="text-sm">
                <ol class="list-none p-0 inline-flex flex-wrap">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('investors.index') }}" class="text-blue-600 hover:text-blue-800">Investors</a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
                    </li>
                    <li class="flex items-center text-gray-500">View Details</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Investor Details') }}
                </h2>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('investors.edit', $investor) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow-sm">
                        Edit
                    </a>
                    <a href="{{ route('investors.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow-sm">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Header Card -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-xl p-6 md:p-8 mb-6 text-white">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="bg-white/20 backdrop-blur-sm p-6 rounded-2xl">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-3xl font-bold mb-2">{{ $investor->name }}</h3>
                        <p class="text-blue-100 text-lg mb-4">{{ $investor->company ?? 'Independent Investor' }}</p>
                        <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                            <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-sm font-semibold">
                                💼 {{ $investor->email }}
                            </span>
                            @if($investor->phone)
                                <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-sm font-semibold">
                                    📞 {{ $investor->phone }}
                                </span>
                            @endif
                            <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-sm font-semibold
                                @if($investor->status == 'active') bg-green-500/30
                                @elseif($investor->status == 'pending') bg-yellow-500/30
                                @else bg-red-500/30 @endif">
                                @if($investor->status == 'active') ✅
                                @elseif($investor->status == 'pending') ⏳
                                @else ❌ @endif
                                {{ ucfirst($investor->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Investment Summary Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-blue-100">
                        <div class="text-center">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl mb-4 inline-block">
                                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Total Investment</h4>
                            <p class="text-4xl font-bold text-blue-600 mb-4">${{ number_format($investor->investment_amount, 2) }}</p>
                            <div class="pt-4 border-t border-gray-200">
                                <p class="text-xs text-gray-500 mb-1">Member Since</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $investor->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-blue-100">
                        <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Contact Information
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Full Name</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $investor->name }}</p>
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                                <a href="mailto:{{ $investor->email }}" class="text-lg font-semibold text-blue-600 hover:text-blue-800 break-all">
                                    {{ $investor->email }}
                                </a>
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Phone Number</label>
                                @if($investor->phone)
                                    <a href="tel:{{ $investor->phone }}" class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                                        {{ $investor->phone }}
                                    </a>
                                @else
                                    <span class="text-lg text-gray-400 italic">Not provided</span>
                                @endif
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Company</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $investor->company ?? 'Not provided' }}</p>
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                                <span class="inline-flex px-4 py-2 text-sm font-bold rounded-lg
                                    @if($investor->status == 'active') bg-green-100 text-green-800
                                    @elseif($investor->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($investor->status == 'active') ✅
                                    @elseif($investor->status == 'pending') ⏳
                                    @else ❌ @endif
                                    {{ ucfirst($investor->status) }}
                                </span>
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Last Updated</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $investor->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($investor->notes)
                <div class="mt-6 bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-blue-100">
                    <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Additional Notes
                    </h4>
                    <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl border border-blue-100">
                        <p class="text-base text-gray-700 whitespace-pre-line leading-relaxed">{{ $investor->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('investors.edit', $investor) }}" class="flex-1 sm:flex-none bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Investor
                </a>
                
                <form action="{{ route('investors.destroy', $investor) }}" method="POST" class="flex-1 sm:flex-none">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center" 
                        onclick="return confirm('Are you sure you want to delete this investor? This action cannot be undone.')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Investor
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>