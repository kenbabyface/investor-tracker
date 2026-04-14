<x-app-layout>
    <x-slot name="title">Edit Feed Log</x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('feed-logs.index') }}" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Edit Feed Log</h2>
                <p class="text-xs text-gray-400">{{ $feedLog->pond->name }} — {{ $feedLog->log_date->format('d M Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow p-6">

            <script>
                const feedPrices = {
                    @foreach($feedSizes as $fs)
                    "{{ $fs->id }}": {{ $fs->price_per_kg }},
                    @endforeach
                };
            </script>

            <form action="{{ route('feed-logs.update', $feedLog) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Pond --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Pond <span class="text-red-500">*</span>
                    </label>
                    <select name="pond_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">— Select a pond —</option>
                        @foreach($ponds as $pond)
                            <option value="{{ $pond->id }}"
                                {{ old('pond_id', $feedLog->pond_id) == $pond->id ? 'selected' : '' }}>
                                {{ $pond->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Feed Type --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Feed Type <span class="text-red-500">*</span>
                    </label>
                    <select name="feed_size_id" id="feed_size_id" required onchange="updateCalc()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">— Select feed type —</option>
                        @foreach($feedSizes as $fs)
                            <option value="{{ $fs->id }}"
                                {{ old('feed_size_id', $feedLog->feed_size_id) == $fs->id ? 'selected' : '' }}>
                                {{ $fs->name }} {{ $fs->size ? "({$fs->size})" : '' }} — ₦{{ number_format($fs->price_per_kg, 2) }}/bag
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-amber-600 mt-1 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Changing the feed type will recalculate the cost using the current price.
                    </p>
                </div>

                {{-- Date + Quantity --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="log_date"
                               value="{{ old('log_date', $feedLog->log_date->format('Y-m-d')) }}"
                               max="{{ today()->format('Y-m-d') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                   <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Quantity (Bags) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quantity_kg" id="quantity_kg"
                            value="{{ old('quantity_kg',(int) $feedLog->quantity_kg) }}"
                            min="1" step="1" required
                            oninput="updateCalc()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- Live Cost Calculation Panel --}}
                <div id="calcPanel" class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl p-5">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Cost Calculation</p>
                    <div class="flex items-center justify-center gap-4 text-center">
                        <div class="bg-white rounded-xl px-4 py-3 shadow-sm flex-1">
                            <p class="text-xs text-gray-400 mb-1">Quantity</p>
                            <p class="text-xl font-bold text-blue-700">
                                <span id="calcQty">{{ number_format($feedLog->quantity_kg, 0) }}</span>
                                <span class="text-sm font-normal text-gray-400">bag</span>
                            </p>
                        </div>
                        <div class="text-2xl text-gray-300 font-light">×</div>
                        <div class="bg-white rounded-xl px-4 py-3 shadow-sm flex-1">
                            <p class="text-xs text-gray-400 mb-1">Price / Bag</p>
                            <p class="text-xl font-bold text-gray-700">₦<span id="calcPrice">{{ number_format($feedLog->price_per_kg, 2) }}</span></p>
                        </div>
                        <div class="text-2xl text-gray-300 font-light">=</div>
                        <div class="bg-white rounded-xl px-4 py-3 shadow-sm flex-1 border-2 border-purple-200">
                            <p class="text-xs text-gray-400 mb-1">Total Cost</p>
                            <p class="text-xl font-bold text-purple-700">₦<span id="calcTotal">{{ number_format($feedLog->total_cost, 2) }}</span></p>
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Notes <span class="text-gray-400 font-normal text-xs">(optional)</span>
                    </label>
                    <textarea name="notes" rows="2"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none text-sm">{{ old('notes', $feedLog->notes) }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition shadow-md shadow-blue-500/20">
                        Save Changes
                    </button>
                    <a href="{{ route('feed-logs.index') }}"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateCalc() {
            const fsId = document.getElementById('feed_size_id').value;
            const qty  = parseFloat(document.getElementById('quantity_kg').value) || 0;

            if (!fsId || !feedPrices[fsId]) return;

            const price = feedPrices[fsId];
            const total = qty * price;

            document.getElementById('calcQty').textContent   = qty.toFixed(0);
            document.getElementById('calcPrice').textContent = price.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            document.getElementById('calcTotal').textContent = total.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        document.addEventListener('DOMContentLoaded', updateCalc);
    </script>
</x-app-layout>