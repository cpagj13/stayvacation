<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Rooms
                </a>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Add New Room</h1>
            <p class="text-slate-400">Create a new room in your inventory</p>
        </div>

        {{-- Form --}}
        <div class="max-w-3xl">
            <form method="POST" action="{{ route('admin.products.store') }}" class="bg-slate-900/50 border border-white/10 rounded-xl shadow-xl overflow-hidden">
                @csrf
                
                <div class="p-8 space-y-6">
                    {{-- Room Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-white mb-2">
                            Room Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}"
                               placeholder="e.g., Ocean View Suite 101"
                               required
                               class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        @error('name')
                            <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="room_category_id" class="block text-sm font-semibold text-white mb-2">
                            Category <span class="text-red-400">*</span>
                        </label>
                        <select name="room_category_id"
                                id="room_category_id"
                                required
                                class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <option value="" class="bg-slate-900">-- Select a category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" class="bg-slate-900" {{ old('room_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_category_id')
                            <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Price & Capacity --}}
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-white mb-2">
                                Price per Night <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">₱</span>
                                <input type="number" 
                                       name="price" 
                                       id="price"
                                       step="0.01"
                                       min="0"
                                       value="{{ old('price') }}"
                                       placeholder="2500.00"
                                       required
                                       class="w-full pl-8 pr-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            </div>
                            @error('price')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="capacity" class="block text-sm font-semibold text-white mb-2">
                                Guest Capacity <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="capacity" 
                                       id="capacity"
                                       min="1"
                                       value="{{ old('capacity', 2) }}"
                                       required
                                       class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center gap-1 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-xs">guests</span>
                                </div>
                            </div>
                            @error('capacity')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-white mb-2">
                            Description
                        </label>
                        <textarea name="description" 
                                  id="description"
                                  rows="4"
                                  placeholder="Describe the room features, amenities, and highlights..."
                                  class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-xs text-slate-500">Optional: Add details about amenities, view, size, etc.</p>
                    </div>

                    {{-- Amenities --}}
                    <div>
                        <label class="block text-sm font-semibold text-white mb-3">
                            Room Amenities
                        </label>
                        <div class="grid sm:grid-cols-2 gap-4">
                            @php
                                $availableAmenities = [
                                    'wifi' => 'Free WiFi',
                                    'tv' => 'Flat Screen TV',
                                    'ac' => 'Air Conditioning',
                                    'room_service' => 'Room Service',
                                    'safe' => 'Safe Box',
                                    'front_desk' => '24/7 Front Desk',
                                    'mini_bar' => 'Mini Bar',
                                    'housekeeping' => 'Daily Housekeeping',
                                ];
                            @endphp
                            @foreach($availableAmenities as $key => $label)
                                <label class="flex items-center gap-3 px-4 py-3 bg-slate-800 border border-white/10 rounded-lg hover:border-indigo-500/50 cursor-pointer transition group">
                                    <input type="checkbox" 
                                           name="amenities[]" 
                                           value="{{ $key }}"
                                           {{ is_array(old('amenities')) && in_array($key, old('amenities')) ? 'checked' : '' }}
                                           class="w-5 h-5 text-indigo-600 bg-slate-700 border-slate-600 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer">
                                    <span class="text-white group-hover:text-indigo-400 transition">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Select all amenities available in this room</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-8 py-5 bg-slate-800/50 border-t border-white/10 flex items-center justify-between gap-4">
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-semibold rounded-lg transition shadow-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>