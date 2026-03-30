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

    <div class="p-6 space-y-5">

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-500">
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Total Feed {{ request()->hasAny(['pond_id','feed_size_id','date_from','date_to']) ? '(filtered)' : '(all)' }}</p>
                <p class="text-3xl font-bold text-green-700 mt-1">{{ number_format($summaryData['total_kg'], 2) }} <span class="text-base font-normal text-gray-400">kg</span></p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-purple-500">
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Total Cost {{ request()->hasAny(['pond_id','feed_size_id','date_from','date_to']) ? '(filtered)' : '(all)' }}</p>
                <p class="text-3xl font-bold text-purple-700 mt-1">₦{{ number_format($summaryData['total_cost'], 2) }}</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-2xl shadow p-5">
            <form method="GET" action="{{ route('feed-logs.index') }}">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 items-end">
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
                    <div class="flex gap-2">
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

        {{-- Logs Table --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            @if($logs->isEmpty())
                <div class="p-12 text-center text-gray-400">
                    <div class="text-4xl mb-3">📋</div>
                    <p class="font-medium">No feed logs found.</p>
                    <p class="text-sm mt-1">Try adjusting your filters or log feed for a pond.</p>
                </div>
            @else
                <div class="overflow-x-auto">
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
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('feed-logs.edit', $log) }}"
                                           class="text-blue-500 hover:text-blue-700 text-xs font-semibold hover:underline">
                                            Edit
                                        </a>
                                        <form action="{{ route('feed-logs.destroy', $log) }}" method="POST"
                                              onsubmit="return confirm('Delete this feed log entry?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-400 hover:text-red-600 text-xs font-semibold hover:underline">
                                                Delete
                                            </button>
                                        </form>
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