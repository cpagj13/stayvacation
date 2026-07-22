@props(['room'])

@php
    // Array of beautiful hotel room images
    $hotelImages = [
        'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80', // Modern hotel room
        'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80', // Luxury bedroom
        'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80', // Hotel suite
        'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80', // Elegant room
        'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80', // Cozy bedroom
        'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80', // Modern suite
        'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80', // Luxury hotel
        'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80', // Beautiful bedroom
    ];
    
    // Select image based on room ID
    $imageUrl = $hotelImages[$room->id % count($hotelImages)];
@endphp

<a href="{{ route('rooms.show', $room) }}" class="group bg-slate-900/50 border border-white/10 rounded-2xl overflow-hidden hover:border-primary-500/40 transition-all duration-300 hover:shadow-card-hover hover:-translate-y-1 block">
    {{-- Room Image --}}
    <div class="relative room-image-wrapper h-56 bg-gradient-to-br from-slate-800 to-slate-900 overflow-hidden">
        <img src="{{ $imageUrl }}" 
             alt="{{ $room->name }}" 
             class="absolute inset-0 w-full h-full object-cover room-image"
             loading="lazy">

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex gap-2 z-10">
            @if($room->id % 3 == 0)
                <span class="px-3 py-1 text-xs font-semibold bg-accent-500 text-white rounded-full shadow-lg">
                    Popular
                </span>
            @endif
            @if($room->price < 3000)
                <span class="px-3 py-1 text-xs font-semibold bg-emerald-500 text-white rounded-full shadow-lg">
                    Best Value
                </span>
            @endif
        </div>

        {{-- Favorite Button --}}
        <button onclick="event.preventDefault(); event.stopPropagation();" class="absolute top-3 right-3 w-9 h-9 bg-slate-900/80 backdrop-blur-sm rounded-full flex items-center justify-center text-white/70 hover:text-red-400 hover:bg-slate-900 transition-all duration-200 opacity-0 group-hover:opacity-100 z-10">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
        </button>

        {{-- Overlay on hover --}}
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </div>

    {{-- Room Details --}}
    <div class="p-5">
        <div class="flex items-start justify-between mb-2">
            <div class="flex-1">
                <h3 class="font-semibold text-lg text-white group-hover:text-primary-400 transition-colors">{{ $room->name }}</h3>
                <p class="text-slate-400 text-sm">{{ $room->category->name ?? 'Standard Room' }}</p>
            </div>
            {{-- Star Rating --}}
            <div class="flex items-center gap-1 text-accent-400">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                </svg>
                <span class="text-sm font-medium text-white">4.8</span>
            </div>
        </div>

        {{-- Amenities --}}
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="inline-flex items-center gap-1.5 text-xs text-slate-400 bg-white/5 px-2 py-1 rounded-lg">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ $room->capacity }} Guests
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs text-slate-400 bg-white/5 px-2 py-1 rounded-lg">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                </svg>
                Free WiFi
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs text-slate-400 bg-white/5 px-2 py-1 rounded-lg">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                TV
            </span>
        </div>

        {{-- Price and CTA --}}
        <div class="flex items-end justify-between pt-4 border-t border-white/10">
            <div>
                <p class="text-slate-400 text-xs mb-1">Starting from</p>
                <p class="text-2xl font-bold text-white">
                    ₱{{ number_format($room->price, 0) }}
                    <span class="text-sm font-normal text-slate-400">/night</span>
                </p>
            </div>
            <span class="px-5 py-2.5 bg-primary-500 group-hover:bg-primary-600 text-white font-medium text-sm rounded-lg transition-all duration-200 group-hover:shadow-lg group-hover:scale-105 flex items-center gap-2">
                View Details
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </span>
        </div>
    </div>
</a>
