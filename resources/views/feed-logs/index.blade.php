<x-app-layout>
    <x-slot name="title">Feed Logs</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">🗂 Feed Log History</h2>
            <a href="{{ route('feed-logs.create') }}"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-xl shadow transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Log Feed
            </a>
        </div>
    </x-slot>

    <div class="p-4 md:p-6 space-y-5">

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl shadow p-4 md:p-5 border-l-4 border-green-500">
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">
                    Total Feed {{ request()->hasAny(['pond_id','feed_size_id','date_from','date_to']) ? '(filtered)' : '(all)' }}
                </p>
                <p class="text-2xl md:text-3xl font-bold text-green-700 mt-1">
                    {{ number_format($summaryData['total_kg'], 2) }}
                    <span class="text-sm md:text-base font-normal text-gray-400">kg</span>
                </p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 md:p-5 border-l-4 border-purple-500">
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">
                    Total Cost {{ request()->hasAny(['pond_id','feed_size_id','date_from','date_to']) ? '(filtered)' : '(all)' }}
                </p>
                <p class="text-2xl md:text-3xl font-bold text-purple-700 mt-1">
                    ₦{{ number_format($summaryData['total_cost'], 2) }}
                </p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-2xl shadow p-4 md:p-5" x-data="{ open: window.innerWidth >= 768 }">
            <button @click="open = !open"
                    class="flex md:hidden items-center justify-between w-full text-sm font-semibold text-gray-500 mb-1">
                <span>Filters</span>
                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <form method="GET" action="{{ route('feed-logs.index') }}" x-show="open" x-cloak>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 items-end mt-2 md:mt-0">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Pond</label>
                        <select name="pond_id" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
                            <option value="">All Ponds</option>
                            @foreach($ponds as $pond)
                                <option value="{{ $pond->id }}" {{ request('pond_id') == $pond->id ? 'selected' : '' }}>
                                    {{ $pond->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Feed Type</label>
                        <select name="feed_size_id" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
                            <option value="">All Types</option>
                            @foreach($feedSizes as $fs)
                                <option value="{{ $fs->id }}" {{ request('feed_size_id') == $fs->id ? 'selected' : '' }}>
                                    {{ $fs->name }} {{ $fs->size ? "({$fs->size})" : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="flex gap-2 col-span-2 md:col-span-1">
                        <button type="submit"
                                class="flex-1 bg-blue-600 text-white text-sm font-semibold px-3 py-2.5 rounded-xl hover:bg-blue-700 transition">
                            Filter
                        </button>
                        <a href="{{ route('feed-logs.index') }}"
                           class="flex-1 text-center bg-gray-100 text-gray-600 text-sm font-semibold px-3 py-2.5 rounded-xl hover:bg-gray-200 transition">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Logs --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            @if($logs->isEmpty())
                <div class="p-12 text-center text-gray-400">
                    <div class="text-4xl mb-3">📋</div>
                    <p class="font-medium">No feed logs found.</p>
                    <p class="text-sm mt-1">Try adjusting your filters or log feed for a pond.</p>
                </div>
            @else

                {{-- ── Mobile card list (hidden on md+) ── --}}
                <div class="md:hidden divide-y divide-gray-100">
                    @foreach($logs as $log)
                    <div class="p-4 space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <a href="{{ route('ponds.show', $log->pond) }}"
                                   class="font-semibold text-blue-600 text-sm hover:underline">
                                    {{ $log->pond->name }}
                                </a>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $log->log_date->format('d M Y') }}
                                    @if($log->log_date->isToday())
                                        <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded-full font-semibold ml-1">Today</span>
                                    @endif
                                </p>
                            </div>

                            {{-- Dropdown action button --}}
                            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                                <button @click="open = !open"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/>
                                    </svg>
                                </button>
                                <div x-show="open" x-cloak
                                     class="absolute right-0 top-8 z-20 w-36 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                                    <a href="{{ route('feed-logs.edit', $log) }}"
                                       class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 text-xs">
                            <div>
                                <p class="text-gray-400">Feed type</p>
                                <p class="font-medium text-gray-700 mt-0.5">
                                    {{ $log->feedSize->name }}
                                    @if($log->feedSize->size)
                                        <span class="text-gray-400">({{ $log->feedSize->size }})</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-400">Quantity</p>
                                <p class="font-bold text-green-700 mt-0.5">{{ number_format($log->quantity_kg, 0) }} kg</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Total cost</p>
                                <p class="font-bold text-purple-700 mt-0.5">₦{{ number_format($log->total_cost, 2) }}</p>
                            </div>
                        </div>

                        @if($log->notes)
                            <p class="text-xs text-gray-400 truncate">{{ $log->notes }}</p>
                        @endif
                    </div>
                    @endforeach

                    {{-- Mobile page totals --}}
                    <div class="p-4 bg-gray-50 flex justify-between text-xs font-bold border-t-2 border-gray-200">
                        <span class="text-gray-400 uppercase tracking-wide">{{ $logs->count() }} entries</span>
                        <span class="text-green-700">{{ number_format($logs->sum('quantity_kg'), 0) }} kg</span>
                        <span class="text-purple-700">₦{{ number_format($logs->sum('total_cost'), 2) }}</span>
                    </div>
                </div>

                {{-- ── Desktop table (hidden below md) ── --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3.5 text-left">Date</th>
                                <th class="px-5 py-3.5 text-left">Pond</th>
                                <th class="px-5 py-3.5 text-left">Feed Type</th>
                                <th class="px-5 py-3.5 text-right">Quantity</th>
                                <th class="px-5 py-3.5 text-right">Price/kg</th>
                                <th class="px-5 py-3.5 text-right">Total Cost</th>
                                <th class="px-5 py-3.5 text-left">Notes</th>
                                <th class="px-5 py-3.5 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($logs as $log)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3.5 font-medium text-gray-800 whitespace-nowrap">
                                    {{ $log->log_date->format('d M Y') }}
                                    @if($log->log_date->isToday())
                                        <span class="ml-1.5 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-semibold">Today</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <a href="{{ route('ponds.show', $log->pond) }}"
                                       class="font-semibold text-blue-600 hover:underline">
                                        {{ $log->pond->name }}
                                    </a>
                                </td>
                                <td class="px-5 py-3.5 text-gray-700">
                                    <span class="font-medium">{{ $log->feedSize->name }}</span>
                                    @if($log->feedSize->size)
                                        <span class="ml-1 text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">{{ $log->feedSize->size }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right font-bold text-green-700">
                                    {{ number_format($log->quantity_kg, 0) }}
                                </td>
                                <td class="px-5 py-3.5 text-right text-gray-500">
                                    ₦{{ number_format($log->price_per_kg, 2) }}
                                </td>
                                <td class="px-5 py-3.5 text-right font-bold text-purple-700">
                                    ₦{{ number_format($log->total_cost, 2) }}
                                </td>
                                <td class="px-5 py-3.5 text-gray-400 max-w-[140px]">
                                    <span class="truncate block text-xs">{{ $log->notes ?? '—' }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    {{-- Desktop dropdown --}}
                                    <div class="relative inline-block" x-data="{ open: false }" @click.outside="open = false">
                                        <button @click="open = !open"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/>
                                            </svg>
                                        </button>
                                        <div x-show="open" x-cloak
                                             class="absolute right-0 z-20 w-36 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                                            <a href="{{ route('feed-logs.edit', $log) }}"
                                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        {{-- Page totals footer --}}
                        <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                            <tr>
                                <td colspan="3" class="px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">
                                    Page Total ({{ $logs->count() }} entries)
                                </td>
                                <td class="px-5 py-3 text-right font-bold text-green-700">
                                    {{ number_format($logs->sum('quantity_kg'), 0) }} Bags
                                </td>
                                <td class="px-5 py-3"></td>
                                <td class="px-5 py-3 text-right font-bold text-purple-700">
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