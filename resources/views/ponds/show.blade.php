<x-app-layout>
    <x-slot name="title">{{ $pond->name }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('ponds.index') }}" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">🏊 {{ $pond->name }}</h2>
                    @if($pond->species)
                        <p class="text-xs text-gray-400">{{ $pond->species }} &mdash; {{ number_format($pond->stock_count) }} fish stocked</p>
                    @endif
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('ponds.edit', $pond) }}"
                   class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-3 py-2 rounded-xl transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('feed-logs.create') }}?pond_id={{ $pond->id }}"
                   class="inline-flex items-center gap-1.5 bg-green-500 hover:bg-green-600 text-white font-semibold px-3 py-2 rounded-xl shadow transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Log Feed Today
                </a>
            </div>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-blue-500">
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Fish Stocked</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ number_format($pond->stock_count) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-green-500">
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Today</p>
                <p class="text-2xl font-bold text-green-700 mt-1">{{ number_format($stats['today_feed_kg'], 0) }} <span class="text-sm font-normal text-gray-400">Bag</span></p>
                <p class="text-xs text-gray-400 mt-0.5">₦{{ number_format($stats['today_cost'], 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-yellow-500">
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">This Month</p>
                <p class="text-2xl font-bold text-yellow-700 mt-1">{{ number_format($stats['this_month_kg'], 0) }} <span class="text-sm font-normal text-gray-400">Bag</span></p>
                <p class="text-xs text-gray-400 mt-0.5">₦{{ number_format($stats['this_month_cost'], 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-purple-500">
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">All Time</p>
                <p class="text-2xl font-bold text-purple-700 mt-1">{{ number_format($stats['total_feed_kg'], 0) }} <span class="text-sm font-normal text-gray-400">Bag</span></p>
                <p class="text-xs text-gray-400 mt-0.5">₦{{ number_format($stats['total_cost'], 2) }}</p>
            </div>
        </div>

        {{-- Feed Logs Table --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-800">Feed Log History</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $stats['log_days'] }} day(s) with recorded feed</p>
                </div>
                <a href="{{ route('feed-logs.create') }}?pond_id={{ $pond->id }}"
                   class="inline-flex items-center gap-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-3 py-2 rounded-xl transition shadow-sm">
                    + Add Entry
                </a>
            </div>

            @if($logs->isEmpty())
                <div class="p-12 text-center text-gray-400">
                    <div class="text-4xl mb-3">📋</div>
                    <p class="font-medium">No feed logs yet for this pond.</p>
                    <p class="text-sm mt-1">Click "Log Feed Today" to record the first entry.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Feed Type</th>
                                <th class="px-6 py-3 text-right">Qty (Bag)</th>
                                <th class="px-6 py-3 text-right">Price/Bag</th>
                                <th class="px-6 py-3 text-right">Total Cost</th>
                                <th class="px-6 py-3 text-left">Notes</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($logs as $log)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                                    {{ $log->log_date->format('d M Y') }}
                                    @if($log->log_date->isToday())
                                        <span class="ml-1.5 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-semibold">Today</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <span class="font-medium">{{ $log->feedSize->name }}</span>
                                    @if($log->feedSize->size)
                                        <span class="ml-1 text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">{{ $log->feedSize->size }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-green-700">
                                    {{ number_format($log->quantity_kg, 0) }}
                                </td>
                                <td class="px-6 py-4 text-right text-gray-500">
                                    ₦{{ number_format($log->price_per_kg, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-purple-700">
                                    ₦{{ number_format($log->total_cost, 2) }}
                                </td>
                                <td class="px-6 py-4 text-gray-400 max-w-[160px]">
                                    <span class="truncate block">{{ $log->notes ?? '—' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="relative inline-block" x-data="{ open: false }">
                                        <button @click="open = !open" @click.outside="open = false"
                                                class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="1.5"/>
                                                <circle cx="12" cy="12" r="1.5"/>
                                                <circle cx="12" cy="19" r="1.5"/>
                                            </svg>
                                        </button>

                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-95"
                                             class="absolute right-0 mt-1 w-36 bg-white rounded-xl shadow-lg border border-gray-100 z-10 overflow-hidden"
                                             style="display: none;">
                                            <a href="{{ route('feed-logs.edit', $log) }}"
                                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                                <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('feed-logs.destroy', $log) }}" method="POST"
                                                  onsubmit="return confirm('Delete this feed log entry?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- Totals footer --}}
                        <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                            <tr>
                                <td colspan="2" class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Page Total</td>
                                <td class="px-6 py-3 text-right font-bold text-green-700">
                                    {{ number_format($logs->sum('quantity_kg'), 0) }} Bag
                                </td>
                                <td class="px-6 py-3"></td>
                                <td class="px-6 py-3 text-right font-bold text-purple-700">
                                    ₦{{ number_format($logs->sum('total_cost'), 2) }}
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>