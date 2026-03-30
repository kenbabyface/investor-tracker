<x-app-layout>
    <x-slot name="title">Fish Overview</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">🐟 Fish & Feed Overview</h2>
            <a href="{{ route('feed-logs.create') }}"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-xl shadow transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Log Feed Today
            </a>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- Overall Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-500">
                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Today — All Ponds</p>
                <p class="text-3xl font-bold text-green-700 mt-1">{{ number_format($overallStats['total_kg_today'], 2) }} <span class="text-base font-normal text-gray-400">kg</span></p>
                <p class="text-sm text-gray-500 mt-0.5">₦{{ number_format($overallStats['total_cost_today'], 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-yellow-500">
                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">This Month</p>
                <p class="text-3xl font-bold text-yellow-700 mt-1">{{ number_format($overallStats['total_kg_month'], 2) }} <span class="text-base font-normal text-gray-400">kg</span></p>
                <p class="text-sm text-gray-500 mt-0.5">₦{{ number_format($overallStats['total_cost_month'], 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-purple-500">
                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">All Time</p>
                <p class="text-3xl font-bold text-purple-700 mt-1">{{ number_format($overallStats['total_kg_alltime'], 2) }} <span class="text-base font-normal text-gray-400">kg</span></p>
                <p class="text-sm text-gray-500 mt-0.5">₦{{ number_format($overallStats['total_cost_alltime'], 2) }}</p>
            </div>
        </div>

        {{-- No ponds empty state --}}
        @if($ponds->isEmpty())
            <div class="bg-white rounded-2xl shadow p-12 text-center">
                <div class="text-6xl mb-4">🏊</div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No ponds set up yet</h3>
                <p class="text-gray-500 mb-6">Start by creating your ponds, then add feed types and start logging daily feed.</p>
                <div class="flex gap-3 justify-center flex-wrap">
                    <a href="{{ route('ponds.create') }}"
                       class="bg-blue-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-blue-700 transition shadow">
                        Add Pond
                    </a>
                    <a href="{{ route('feed-sizes.index') }}"
                       class="bg-gray-100 text-gray-700 font-semibold px-5 py-2.5 rounded-xl hover:bg-gray-200 transition">
                        Feed Settings
                    </a>
                </div>
            </div>
        @else
            {{-- Per Pond Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($ponds as $pond)
                <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden flex flex-col">

                    {{-- Pond Header --}}
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-white font-bold text-lg leading-tight">{{ $pond->name }}</h3>
                                <p class="text-blue-200 text-xs mt-0.5">
                                    {{ $pond->species ?? 'Fish' }} &mdash; {{ number_format($pond->stock_count) }} stocked
                                </p>
                            </div>
                            <span class="bg-white/20 rounded-xl px-2.5 py-1 text-white text-xs font-semibold whitespace-nowrap mt-0.5">
                                {{ $pond->feedLogs->count() }} log{{ $pond->feedLogs->count() !== 1 ? 's' : '' }} today
                            </span>
                        </div>
                        @if($pond->stocked_at)
                            <p class="text-blue-300 text-xs mt-2">Stocked {{ $pond->stocked_at->format('d M Y') }}</p>
                        @endif
                    </div>

                    {{-- Today's Logs --}}
                    <div class="p-5 flex-1 space-y-3">
                        @if($pond->feedLogs->isEmpty())
                            <div class="flex flex-col items-center justify-center py-6 text-gray-400">
                                <svg class="w-8 h-8 mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm">No feed logged today</p>
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach($pond->feedLogs as $log)
                                <div class="flex items-center justify-between bg-gray-50 rounded-xl px-3 py-2.5">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">{{ $log->feedSize->name }}</p>
                                        @if($log->feedSize->size)
                                            <p class="text-xs text-gray-400">{{ $log->feedSize->size }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-green-700">{{ number_format($log->quantity_kg, 2) }} kg</p>
                                        <p class="text-xs text-purple-600 font-semibold">₦{{ number_format($log->total_cost, 2) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="pt-3 border-t border-gray-100 flex justify-between items-center">
                                <span class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Today's Total</span>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-purple-700">₦{{ number_format($pond->feedLogs->sum('total_cost'), 2) }}</span>
                                    <span class="text-xs text-gray-400 ml-1">({{ number_format($pond->feedLogs->sum('quantity_kg'), 2) }} kg)</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="px-5 pb-5 flex gap-2">
                        <a href="{{ route('feed-logs.create') }}?pond_id={{ $pond->id }}"
                           class="flex-1 text-center text-xs bg-green-500 text-white font-semibold py-2.5 rounded-xl hover:bg-green-600 transition shadow-sm">
                            + Log Feed
                        </a>
                        <a href="{{ route('ponds.show', $pond) }}"
                           class="flex-1 text-center text-xs bg-blue-50 text-blue-700 font-semibold py-2.5 rounded-xl hover:bg-blue-100 transition border border-blue-200">
                            Full History
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>