<x-app-layout>
    <x-slot name="title">Feed Settings</x-slot>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">⚙️ Feed Settings</h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto space-y-6">

        {{-- Add Feed Type Form --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-1">Add Feed Type</h3>
            <p class="text-sm text-gray-400 mb-5">Define the feed name, size label, and price per kg. These will appear as options when logging daily feed.</p>

            <form action="{{ route('feed-sizes.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                            Feed Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="e.g. Grower Pellet"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-400 @enderror">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Size / Label</label>
                        <input type="text" name="size" value="{{ old('size') }}"
                               placeholder="e.g. 2mm, 4mm, Starter"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                            Price per kg (₦) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="price_per_kg" value="{{ old('price_per_kg') }}"
                               placeholder="e.g. 1500.00" min="0" step="0.01"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price_per_kg') border-red-400 @enderror">
                        @error('price_per_kg') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Description</label>
                        <input type="text" name="description" value="{{ old('description') }}"
                               placeholder="Optional notes..."
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition shadow-md shadow-blue-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Feed Type
                </button>
            </form>
        </div>

        {{-- Existing Feed Types --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800">Existing Feed Types</h3>
                <span class="text-xs text-gray-400">{{ $feedSizes->count() }} type(s)</span>
            </div>

            @if($feedSizes->isEmpty())
                <div class="p-12 text-center text-gray-400">
                    <!-- <div class="text-4xl mb-3">🐟</div> -->
                    <p class="font-medium">No feed types added yet.</p>
                    <p class="text-sm mt-1">Add your first feed type using the form above.</p>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($feedSizes as $feedSize)
                    <div id="row-{{ $feedSize->id }}" class="px-6 py-4">

                        {{-- VIEW MODE --}}
                        <div id="view-{{ $feedSize->id }}" class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                <div class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-full whitespace-nowrap flex-shrink-0">
                                    {{ $feedSize->size ?? 'No size' }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 truncate">{{ $feedSize->name }}</p>
                                    @if($feedSize->description)
                                        <p class="text-xs text-gray-400 truncate">{{ $feedSize->description }}</p>
                                    @endif
                                </div>
                                <div class="ml-auto text-right flex-shrink-0">
                                    <p class="font-bold text-green-700">
                                        ₦{{ number_format($feedSize->price_per_kg, 2) }}
                                        <span class="text-xs font-normal text-gray-400">/kg</span>
                                    </p>
                                    @if(!$feedSize->is_active)
                                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Inactive</span>
                                    @else
                                        <span class="text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded-full">Active</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-1 flex-shrink-0">
                                <button onclick="showEdit({{ $feedSize->id }})"
                                        class="text-sm text-blue-500 hover:text-blue-700 font-medium px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                                    Edit
                                </button>
                                <form action="{{ route('feed-sizes.destroy', $feedSize) }}" method="POST"
                                      onsubmit="return confirm('Delete {{ addslashes($feedSize->name) }}? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="text-sm text-red-400 hover:text-red-600 font-medium px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- EDIT MODE --}}
                        <div id="edit-{{ $feedSize->id }}" class="hidden">
                            <form action="{{ route('feed-sizes.update', $feedSize) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Feed Name *</label>
                                        <input type="text" name="name" value="{{ $feedSize->name }}"
                                               placeholder="Feed Name" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Size / Label</label>
                                        <input type="text" name="size" value="{{ $feedSize->size }}"
                                               placeholder="e.g. 2mm"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Price per kg (₦) *</label>
                                        <input type="number" name="price_per_kg" value="{{ $feedSize->price_per_kg }}"
                                               min="0" step="0.01" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Description</label>
                                        <input type="text" name="description" value="{{ $feedSize->description }}"
                                               placeholder="Optional"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 flex-wrap">
                                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1"
                                               {{ $feedSize->is_active ? 'checked' : '' }}
                                               class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                                        Active
                                    </label>
                                    <button type="submit"
                                            class="bg-blue-600 text-white text-sm font-semibold px-5 py-2 rounded-xl hover:bg-blue-700 transition shadow">
                                        Save Changes
                                    </button>
                                    <button type="button" onclick="hideEdit({{ $feedSize->id }})"
                                            class="bg-gray-100 text-gray-600 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-gray-200 transition">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <script>
        function showEdit(id) {
            document.getElementById('view-' + id).classList.add('hidden');
            document.getElementById('edit-' + id).classList.remove('hidden');
        }
        function hideEdit(id) {
            document.getElementById('edit-' + id).classList.add('hidden');
            document.getElementById('view-' + id).classList.remove('hidden');
        }
    </script>
</x-app-layout>