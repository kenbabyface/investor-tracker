<x-app-layout>
    <x-slot name="title">Edit Pond</x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('ponds.index') }}" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Edit Pond</h2>
                <p class="text-xs text-gray-400">{{ $pond->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="p-6 max-w-2xl mx-auto space-y-5">

        {{-- Edit Form --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <form action="{{ route('ponds.update', $pond) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Pond Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $pond->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Fish Species</label>
                    <input type="text" name="species" value="{{ old('species', $pond->species) }}"
                           placeholder="e.g. Catfish, Tilapia..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Stock Count <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock_count" value="{{ old('stock_count', $pond->stock_count) }}"
                               min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stock_count') border-red-400 @enderror">
                        @error('stock_count') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Date Stocked</label>
                        <input type="date" name="stocked_at" value="{{ old('stocked_at', $pond->stocked_at?->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('notes', $pond->notes) }}</textarea>
                </div>

                <div class="flex items-center gap-3 py-1">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           {{ $pond->is_active ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                    <label for="is_active" class="text-sm font-semibold text-gray-700">Pond is active</label>
                </div>

                <div class="flex gap-3 pt-1">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition shadow-md shadow-blue-500/20">
                        Save Changes
                    </button>
                    <a href="{{ route('ponds.index') }}"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-white rounded-2xl shadow p-6 border border-red-100">
            <h3 class="text-sm font-bold text-red-600 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                Danger Zone
            </h3>
            <p class="text-sm text-gray-500 mb-4">
                Deleting this pond will permanently remove <strong>all {{ $pond->feedLogs()->count() }} feed log(s)</strong> associated with it. This cannot be undone.
            </p>
            <form action="{{ route('ponds.destroy', $pond) }}" method="POST"
                  onsubmit="return confirm('Delete pond \'{{ addslashes($pond->name) }}\' and ALL its feed logs? This CANNOT be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete Pond
                </button>
            </form>
        </div>
    </div>
</x-app-layout>