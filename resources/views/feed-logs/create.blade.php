<x-app-layout>
    <x-slot name="title">Log Daily Feed</x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('feed-logs.index') }}" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Log Daily Feed</h2>
                <p class="text-xs text-gray-400">Record today's feeding for a pond</p>
            </div>
        </div>
    </x-slot>

    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow p-6">

            {{-- Feed prices for JS --}}
            <script>
                const feedPrices = {
                    @foreach($feedSizes as $fs)
                    "{{ $fs->id }}": {{ $fs->price_per_kg }},
                    @endforeach
                };
            </script>

            <form action="{{ route('feed-logs.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Pond --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Pond <span class="text-red-500">*</span>
                    </label>
                    <select name="pond_id" id="pond_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white @error('pond_id') border-red-400 @enderror">
                        <option value="">— Select a pond —</option>
                        @foreach($ponds as $pond)
                            <option value="{{ $pond->id }}"
                                {{ old('pond_id', request('pond_id')) == $pond->id ? 'selected' : '' }}>
                                {{ $pond->name }}
                                @if($pond->species) ({{ $pond->species }}) @endif
                                — {{ number_format($pond->stock_count) }} fish
                            </option>
                        @endforeach
                    </select>
                    @error('pond_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @if($ponds->isEmpty())
                        <p class="text-xs text-orange-500 mt-1">
                            No ponds available. <a href="{{ route('ponds.create') }}" class="underline font-medium">Create a pond first</a>.
                        </p>
                    @endif
                </div>

                {{-- Feed Type --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Feed Type <span class="text-red-500">*</span>
                    </label>
                    <select name="feed_size_id" id="feed_size_id" required onchange="updateCalc()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white @error('feed_size_id') border-red-400 @enderror">
                        <option value="">— Select feed type —</option>
                        @foreach($feedSizes as $fs)
                            <option value="{{ $fs->id }}"
                                {{ old('feed_size_id') == $fs->id ? 'selected' : '' }}>
                                {{ $fs->name }}
                                @if($fs->size) ({{ $fs->size }}) @endif
                                — ₦{{ number_format($fs->price_per_kg, 2) }}/kg
                            </option>
                        @endforeach
                    </select>
                    @error('feed_size_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">
                        Don't see your feed type?
                        <a href="{{ route('feed-sizes.index') }}" class="text-blue-500 hover:underline font-medium">Add it in Feed Settings →</a>
                    </p>
                </div>

                {{-- Date + Quantity --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="log_date"
                               value="{{ old('log_date', today()->format('Y-m-d')) }}"
                               max="{{ today()->format('Y-m-d') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 @error('log_date') border-red-400 @enderror">
                        @error('log_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Quantity (kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quantity_kg" id="quantity_kg"
                               value="{{ old('quantity_kg') }}"
                               placeholder="e.g. 5.50" min="0.01" step="0.01" required
                               oninput="updateCalc()"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 @error('quantity_kg') border-red-400 @enderror">
                        @error('quantity_kg') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Live Cost Calculation Panel --}}
                <div id="calcPanel" class="hidden bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl p-5">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Cost Calculation</p>
                    <div class="flex items-center justify-center gap-4 text-center">
                        <div class="bg-white rounded-xl px-4 py-3 shadow-sm flex-1">
                            <p class="text-xs text-gray-400 mb-1">Quantity</p>
                            <p class="text-xl font-bold text-blue-700"><span id="calcQty">0</span> <span class="text-sm font-normal text-gray-400">kg</span></p>
                        </div>
                        <div class="text-2xl text-gray-300 font-light">×</div>
                        <div class="bg-white rounded-xl px-4 py-3 shadow-sm flex-1">
                            <p class="text-xs text-gray-400 mb-1">Price / kg</p>
                            <p class="text-xl font-bold text-gray-700">₦<span id="calcPrice">0</span></p>
                        </div>
                        <div class="text-2xl text-gray-300 font-light">=</div>
                        <div class="bg-white rounded-xl px-4 py-3 shadow-sm flex-1 border-2 border-purple-200">
                            <p class="text-xs text-gray-400 mb-1">Total Cost</p>
                            <p class="text-xl font-bold text-purple-700">₦<span id="calcTotal">0</span></p>
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Notes <span class="text-gray-400 font-normal text-xs">(optional)</span>
                    </label>
                    <textarea name="notes" rows="2"
                              placeholder="e.g. Fish were very active, fed twice in the morning..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none text-sm">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-xl transition shadow-md shadow-green-500/20">
                        💾 Save Feed Log
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
            const fsId  = document.getElementById('feed_size_id').value;
            const qty   = parseFloat(document.getElementById('quantity_kg').value) || 0;
            const panel = document.getElementById('calcPanel');

            if (!fsId || !feedPrices[fsId] || qty <= 0) {
                panel.classList.add('hidden');
                return;
            }

            const price = feedPrices[fsId];
            const total = qty * price;

            document.getElementById('calcQty').textContent   = qty.toFixed(2);
            document.getElementById('calcPrice').textContent = price.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            document.getElementById('calcTotal').textContent = total.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            panel.classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', updateCalc);
    </script>
</x-app-layout>