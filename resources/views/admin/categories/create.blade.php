<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.categories.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Categories
                </a>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Add New Category</h1>
            <p class="text-slate-400">Create a new room category for organizing your inventory</p>
        </div>

        {{-- Form --}}
        <div class="max-w-2xl">
            <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-slate-900/50 border border-white/10 rounded-xl shadow-xl overflow-hidden">
                @csrf
                
                <div class="p-8 space-y-6">
                    {{-- Category Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-white mb-2">
                            Category Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}"
                               placeholder="e.g., Deluxe Suite, Standard Room"
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

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-white mb-2">
                            Description
                        </label>
                        <textarea name="description" 
                                  id="description"
                                  rows="4"
                                  placeholder="Brief description of this category..."
                                  class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-xs text-slate-500">Optional: Add details about this category type</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-8 py-5 bg-slate-800/50 border-t border-white/10 flex items-center justify-between gap-4">
                    <a href="{{ route('admin.categories.index') }}" 
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
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>