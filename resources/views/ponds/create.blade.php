<x-app-layout>
    <x-slot name="title">Add Pond</x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('ponds.index') }}" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Add New Pond</h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-sm text-gray-400 mb-6">Fill in the details for your new pond. You can start logging feed immediately after creating it.</p>

            <form action="{{ route('ponds.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Pond Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g. Pond Alpha, North Pond, Tank 1..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Fish Species</label>
                    <input type="text" name="species" value="{{ old('species') }}"
                           placeholder="e.g. Catfish, Tilapia, Salmon..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Optional — helps identify pond content at a glance.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Stock Count <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock_count" value="{{ old('stock_count') }}"
                               placeholder="e.g. 2000" min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stock_count') border-red-400 @enderror">
                        <p class="text-xs text-gray-400 mt-1">Number of fish currently in this pond.</p>
                        @error('stock_count') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Date Stocked</label>
                        <input type="date" name="stocked_at" value="{{ old('stocked_at') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                    <textarea name="notes" rows="3"
                              placeholder="Any additional notes about this pond..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition shadow-md shadow-blue-500/20">
                        Create Pond
                    </button>
                    <a href="{{ route('ponds.index') }}"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>