@props(['name', 'location', 'rating' => 5, 'review', 'initial' => 'J'])

<div class="bg-slate-900/50 border border-white/10 rounded-2xl p-6 hover:border-primary-500/30 transition-all duration-300 hover:shadow-card">
    {{-- Rating Stars --}}
    <div class="flex items-center gap-1 mb-4">
        @for($i = 0; $i < 5; $i++)
            <svg class="w-5 h-5 {{ $i < $rating ? 'text-accent-400 fill-current' : 'text-slate-600' }}" viewBox="0 0 20 20">
                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
            </svg>
        @endfor
    </div>

    {{-- Review Text --}}
    <p class="text-slate-300 leading-relaxed mb-6 text-sm">
        "{{ $review }}"
    </p>

    {{-- Reviewer Info --}}
    <div class="flex items-center gap-3 pt-4 border-t border-white/10">
        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
            {{ $initial }}
        </div>
        <div>
            <p class="font-semibold text-white text-sm">{{ $name }}</p>
            <p class="text-slate-400 text-xs flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ $location }}
            </p>
        </div>
        <svg class="w-5 h-5 text-emerald-500 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
</div>
