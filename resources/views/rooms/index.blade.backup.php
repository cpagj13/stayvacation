<x-app-layout>
    @push('styles')
    <style>
        /* Hide elements before Alpine loads */
        [x-cloak] { display: none !important; }
        
        /* Scroll animations */
        .scroll-animate {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .scroll-animate.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stagger animations */
        .scroll-animate:nth-child(1) { transition-delay: 0.1s; }
        .scroll-animate:nth-child(2) { transition-delay: 0.2s; }
        .scroll-animate:nth-child(3) { transition-delay: 0.3s; }
        .scroll-animate:nth-child(4) { transition-delay: 0.4s; }
        .scroll-animate:nth-child(5) { transition-delay: 0.5s; }
        .scroll-animate:nth-child(6) { transition-delay: 0.6s; }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Bidirectional scroll animation observer
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.15,
                rootMargin: '0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    } else {
                        entry.target.classList.remove('visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.scroll-animate').forEach(el => {
                observer.observe(el);
            });
        });

        // Alpine.js component for rooms filter
        document.addEventListener('alpine:init', () => {
            Alpine.data('roomsFilter', () => ({
                priceRange: 'all',
                
                init() {
                    console.log('=== PRICE FILTER INITIALIZED ===');
                    console.log('Price range:', this.priceRange);
                },
                
                shouldShowRoom(price) {
                    if (this.priceRange === 'all') {
                        return true;
                    }
                    
                    const roomPrice = Number(price);
                    
                    switch(this.priceRange) {
                        case '0-2000':
                            return roomPrice <= 2000;
                        case '2000-3000':
                            return roomPrice > 2000 && roomPrice <= 3000;
                        case '3000-5000':
                            return roomPrice > 3000 && roomPrice <= 5000;
                        case '5000+':
                            return roomPrice > 5000;
                        default:
                            return true;
                    }
                },
                
                get visibleCount() {
                    const rooms = @json($rooms->pluck('price')->toArray());
                    if (this.priceRange === 'all') {
                        return rooms.length;
                    }
                    return rooms.filter(price => this.shouldShowRoom(price)).length;
                }
            }))
        });
    </script>
    @endpush

    <div class="min-h-screen bg-slate-950 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Page Header --}}
            <div class="mb-12 scroll-animate">
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-4">
                    Browse Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">Rooms</span>
                </h1>
                <p class="text-slate-400 text-lg max-w-3xl">
                    Discover the perfect accommodation for your stay. Each room is designed for comfort and elegance.
                </p>
            </div>

            {{-- Filters and Rooms Grid --}}
            <div x-data="roomsFilter" x-cloak>
                {{-- Filters --}}
                <div class="mb-8 scroll-animate">
                    <div class="bg-slate-900/30 border border-white/10 rounded-2xl p-6">
                        <div class="flex flex-wrap gap-4 items-end">
                            {{-- Price Filter --}}
                            <div class="flex-1 min-w-[250px]">
                                <label class="block text-sm font-semibold text-white mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Price Range
                                </label>
                                <select x-model="priceRange"
                                        class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30 transition cursor-pointer hover:border-slate-600">
                                    <option value="all">All Prices</option>
                                    <option value="0-2000">₱0 - ₱2,000</option>
                                    <option value="2000-3000">₱2,000 - ₱3,000</option>
                                    <option value="3000-5000">₱3,000 - ₱5,000</option>
                                    <option value="5000+">₱5,000+</option>
                                </select>
                            </div>

                            {{-- Results Count --}}
                            <div class="px-5 py-3 bg-gradient-to-br from-primary-500/10 to-purple-500/10 border border-primary-500/20 rounded-xl">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <div>
                                        <span class="text-2xl font-bold text-white" x-text="visibleCount"></span>
                                        <span class="text-slate-400 text-sm ml-1">rooms</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Rooms Grid --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($rooms as $room)
                        <div class="scroll-animate" 
                             x-show="shouldShowRoom({{ $room->price }})"
                             style="display: none;">
                            <a href="{{ route('rooms.show', $room) }}" class="group bg-slate-900/50 border border-white/10 rounded-2xl overflow-hidden hover:border-primary-500/40 transition-all duration-300 hover:shadow-card-hover hover:-translate-y-1 block">
                                {{-- Room Image --}}
                                <div class="relative h-56 bg-gradient-to-br from-slate-800 to-slate-900 overflow-hidden">
                                    @php
                                        $hotelImages = [
                                            'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80',
                                            'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80',
                                            'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80',
                                            'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                                            'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80',
                                            'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80',
                                            'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80',
                                            'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80',
                                        ];
                                        $imageUrl = $hotelImages[$room->id % count($hotelImages)];
                                    @endphp
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $room->name }}" 
                                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                         loading="lazy">

                                    {{-- Badges --}}
                                    <div class="absolute top-3 left-3 flex gap-2 z-10">
                                        @if($room->id % 3 === 0)
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

                                    {{-- Overlay --}}
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
                        </div>
                    @endforeach

                    {{-- Empty State --}}
                    <div class="col-span-full text-center py-20" x-show="visibleCount === 0">
                        <div class="max-w-md mx-auto">
                            <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-3">No rooms found</h3>
                            <p class="text-slate-400 text-lg mb-8">Try adjusting your filters to see more options</p>
                            <button @click="priceRange = 'all'" 
                                    class="inline-flex items-center gap-2 px-8 py-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset All Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Back to Home --}}
            <div class="mt-16 text-center scroll-animate">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white/5 hover:bg-white/10 text-white font-semibold rounded-xl border border-white/10 hover:border-white/20 transition-all duration-300 group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Home
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
