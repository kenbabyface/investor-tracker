<x-app-layout>
    <x-slot name="title">Pond History</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold bg-gradient-to-r from-amber-500 to-orange-500 bg-clip-text text-transparent">
                Pond Cycle History
            </h2>
            <a href="{{ route('ponds.index') }}"
               class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Ponds
            </a>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-amber-500">
                <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Total Cycles</p>
                <p class="text-3xl font-extrabold text-gray-800">{{ number_format($stats['total_cycles']) }}</p>
                <p class="text-xs text-gray-500 mt-1">Archived cycles</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-500">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Total Fish</p>
                <p class="text-3xl font-extrabold text-gray-800">{{ number_format($stats['total_fish']) }}</p>
                <p class="text-xs text-gray-500 mt-1">Fish stocked total</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-500">
                <p class="text-xs font-bold text-green-600 uppercase tracking-wider mb-1">Total Feed (KG)</p>
                <p class="text-3xl font-extrabold text-gray-800">{{ number_format($stats['total_kg'], 0) }}</p>
                <p class="text-xs text-gray-500 mt-1">Kilograms consumed</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-purple-500">
                <p class="text-xs font-bold text-purple-600 uppercase tracking-wider mb-1">Total Cost</p>
                <p class="text-3xl font-extrabold text-gray-800">₦{{ number_format($stats['total_cost'], 2) }}</p>
                <p class="text-xs text-gray-500 mt-1">Cumulative investment</p>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white rounded-2xl shadow p-4 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="relative flex-1 w-full max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="historySearch" placeholder="Search by pond name or species..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none">
            </div>
            <p class="text-sm text-gray-500 whitespace-nowrap">
                {{ $histories->total() }} record(s) found
            </p>
        </div>

        {{-- Table --}}
        @if($histories->isEmpty())
            <div class="bg-white rounded-2xl shadow p-16 text-center">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No archived cycles yet</h3>
                <p class="text-gray-500">Archive a pond cycle from the Ponds page to see its history here.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="background: linear-gradient(to right, #f59e0b, #f97316);">
                                <th class="text-left px-5 py-4 text-white font-bold uppercase tracking-wider text-xs">Pond</th>
                                <th class="text-left px-5 py-4 text-white font-bold uppercase tracking-wider text-xs">Species</th>
                                <th class="text-center px-5 py-4 text-white font-bold uppercase tracking-wider text-xs">Stock Count</th>
                                <th class="text-center px-5 py-4 text-white font-bold uppercase tracking-wider text-xs">Feed Bags</th>
                                <th class="text-center px-5 py-4 text-white font-bold uppercase tracking-wider text-xs">Total KG</th>
                                <th class="text-right px-5 py-4 text-white font-bold uppercase tracking-wider text-xs">Total Cost</th>
                                <th class="text-center px-5 py-4 text-white font-bold uppercase tracking-wider text-xs">Stocked</th>
                                <th class="text-center px-5 py-4 text-white font-bold uppercase tracking-wider text-xs">Archived</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody" class="divide-y divide-gray-100">
                            @foreach($histories as $history)
                            <tr class="history-row hover:bg-amber-50 transition-colors duration-150"
                                data-name="{{ strtolower($history->pond_name) }}"
                                data-species="{{ strtolower($history->species ?? '') }}">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-lg flex-shrink-0"
                                             style="background: linear-gradient(to right, #3b82f6, #22d3ee);">
                                            🏊
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $history->pond_name }}</p>
                                            <a href="{{ route('ponds.show', $history->pond_id) }}"
                                               class="text-xs text-blue-500 hover:underline">View pond →</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium">
                                        {{ $history->species ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="font-bold text-gray-800">{{ number_format($history->stock_count) }}</span>
                                    <span class="text-xs text-gray-400 block">fish</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="font-bold text-gray-800">{{ number_format($history->total_feed_bags, 0) }}</span>
                                    <span class="text-xs text-gray-400 block">bags</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="font-bold text-gray-800">{{ number_format($history->total_feed_kg, 0) }}</span>
                                    <span class="text-xs text-gray-400 block">kg</span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <span class="font-bold text-purple-700">₦{{ number_format($history->total_cost, 2) }}</span>
                                </td>
                                <td class="px-5 py-4 text-center text-gray-500 text-xs">
                                    {{ $history->stocked_at ? \Carbon\Carbon::parse($history->stocked_at)->format('M d, Y') : '—' }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold">
                                        {{ $history->archived_at->format('M d, Y') }}
                                    </span>
                                    <span class="text-xs text-gray-400 block mt-0.5">{{ $history->archived_at->diffForHumans() }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($histories->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $histories->links() }}
                </div>
                @endif
            </div>
        @endif
    </div>

    <script>
        document.getElementById('historySearch').addEventListener('input', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.history-row').forEach(row => {
                const name = row.getAttribute('data-name');
                const species = row.getAttribute('data-species');
                row.style.display = (name.includes(term) || species.includes(term)) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>