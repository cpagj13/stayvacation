<x-app-layout>
    @push('styles')
    <style>
        html { scroll-behavior: smooth; }
        
        /* Image hover zoom effect */
        .room-image-wrapper { overflow: hidden; }
        .room-image { transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
        .room-image-wrapper:hover .room-image { transform: scale(1.1); }

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
        
        .scroll-animate-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .scroll-animate-left.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        .scroll-animate-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .scroll-animate-right.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        .scroll-animate-scale {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .scroll-animate-scale.visible {
            opacity: 1;
            transform: scale(1);
        }

        /* Stagger animations */
        .scroll-animate:nth-child(1) { transition-delay: 0.1s; }
        .scroll-animate:nth-child(2) { transition-delay: 0.2s; }
        .scroll-animate:nth-child(3) { transition-delay: 0.3s; }
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
                        // Element is entering viewport - animate in
                        entry.target.classList.add('visible');
                    } else {
                        // Element is leaving viewport - animate out
                        entry.target.classList.remove('visible');
                    }
                });
            }, observerOptions);

            // Observe all elements with scroll animation classes
            document.querySelectorAll('.scroll-animate, .scroll-animate-left, .scroll-animate-right, .scroll-animate-scale').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
    @endpush

    <div class="min-h-screen bg-slate-950 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Back Button --}}
            <div class="mb-8">
                <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to all rooms
                </a>
            </div>

            {{-- Room Details --}}
            <div class="grid lg:grid-cols-2 gap-12 mb-16">
                
                {{-- Image Gallery --}}
                <div class="space-y-4 scroll-animate-left">
                    @php
                        // Array of beautiful hotel room images
                        $hotelImages = [
                            'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                            'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80',
                            'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                            'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                            'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=80',
                            'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80',
                            'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80',
                            'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=1200&q=80',
                        ];
                        
                        $thumbnailImages = [
                            'https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=400&q=80',
                            'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=400&q=80',
                            'https://images.unsplash.com/photo-1571508601936-6b46d48be12c?auto=format&fit=crop&w=400&q=80',
                            'https://images.unsplash.com/photo-1631049552240-59c37f38802b?auto=format&fit=crop&w=400&q=80',
                        ];
                        
                        // Select main image based on room ID
                        $mainImage = $hotelImages[$room->id % count($hotelImages)];
                    @endphp

                    <div class="relative room-image-wrapper aspect-[4/3] rounded-2xl overflow-hidden border border-white/10 shadow-2xl">
                        <img src="{{ $mainImage }}" 
                             alt="{{ $room->name }}" 
                             class="absolute inset-0 w-full h-full object-cover room-image">
                    </div>

                    {{-- Thumbnail Gallery --}}
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($thumbnailImages as $thumb)
                            <div class="aspect-square rounded-lg border border-white/10 bg-slate-900/50 overflow-hidden cursor-pointer hover:border-primary-500/50 transition">
                                <img src="{{ $thumb }}" 
                                     alt="Room view" 
                                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Room Info --}}
                <div class="scroll-animate-right">
                    {{-- Category Badge --}}
                    @if($room->category)
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-primary-500/10 text-primary-400 border border-primary-500/20 rounded-full mb-4">
                            {{ $room->category->name }}
                        </span>
                    @endif

                    {{-- Room Name --}}
                    <h1 class="text-4xl font-display font-bold text-white mb-4">{{ $room->name }}</h1>

                    {{-- Rating --}}
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center gap-1">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 {{ $i < 4 ? 'text-accent-400 fill-current' : 'text-slate-600' }}" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-slate-400 text-sm">(128 reviews)</span>
                    </div>

                    {{-- Price --}}
                    <div class="flex items-baseline gap-2 mb-8">
                        <span class="text-4xl font-bold text-white">₱{{ number_format($room->price, 0) }}</span>
                        <span class="text-slate-400">/ night</span>
                    </div>

                    {{-- Key Features --}}
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center gap-3 p-4 bg-slate-900/50 border border-white/10 rounded-xl">
                            <div class="w-10 h-10 bg-primary-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-400">Max Guests</p>
                                <p class="font-semibold text-white">{{ $room->capacity }} People</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-slate-900/50 border border-white/10 rounded-xl">
                            <div class="w-10 h-10 bg-primary-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-400">Room Type</p>
                                <p class="font-semibold text-white">{{ $room->type ?? 'Standard' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-4 mb-8">
                        <a href="{{ auth()->check() ? route('booking.step1') : route('login') }}" 
                           class="flex-1 px-8 py-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105 text-center">
                            Book Now
                        </a>
                        <button class="px-6 py-4 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white rounded-xl transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>

                    {{-- Trust Indicators --}}
                    <div class="flex flex-wrap gap-6 text-sm text-slate-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Free Cancellation</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Instant Confirmation</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Best Price Guarantee</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description & Amenities --}}
            <div class="grid lg:grid-cols-3 gap-8 mb-16">
                {{-- Description --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-slate-900/30 border border-white/10 rounded-2xl p-8 scroll-animate">
                        <h2 class="text-2xl font-bold text-white mb-4">Description</h2>
                        <p class="text-slate-300 leading-relaxed">
                            {{ $room->description ?? 'Experience comfort and luxury in this beautifully appointed room. Perfect for both business and leisure travelers, featuring modern amenities and elegant design. Enjoy a relaxing stay with premium bedding, spacious layout, and stunning views.' }}
                        </p>
                    </div>

                    {{-- Amenities --}}
                    <div class="bg-slate-900/30 border border-white/10 rounded-2xl p-8 scroll-animate">
                        <h2 class="text-2xl font-bold text-white mb-6">Amenities</h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            @php
                                // Default amenities with icons
                                $defaultAmenities = [
                                    'wifi' => ['icon' => 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0', 'name' => 'Free WiFi'],
                                    'tv' => ['icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'name' => 'Flat Screen TV'],
                                    'ac' => ['icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3', 'name' => 'Air Conditioning'],
                                    'room_service' => ['icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'name' => 'Room Service'],
                                    'safe' => ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'name' => 'Safe Box'],
                                    'front_desk' => ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'name' => '24/7 Front Desk'],
                                    'mini_bar' => ['icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z', 'name' => 'Mini Bar'],
                                    'housekeeping' => ['icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'name' => 'Daily Housekeeping'],
                                ];

                                // Use room amenities if available, otherwise use defaults
                                $displayAmenities = $room->amenities && is_array($room->amenities) && count($room->amenities) > 0
                                    ? array_intersect_key($defaultAmenities, array_flip($room->amenities))
                                    : $defaultAmenities;
                            @endphp

                            @forelse($displayAmenities as $amenity)
                                <div class="flex items-center gap-3 text-slate-300">
                                    <svg class="w-5 h-5 text-primary-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $amenity['icon'] }}" />
                                    </svg>
                                    <span>{{ $amenity['name'] }}</span>
                                </div>
                            @empty
                                <p class="text-slate-400 col-span-2">No amenities specified</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Booking Card (Sticky) --}}
                <div class="lg:sticky lg:top-24 h-fit scroll-animate-scale">
                    <div class="bg-slate-900/50 border border-white/10 rounded-2xl p-6 space-y-6">
                        <div>
                            <p class="text-slate-400 text-sm mb-1">Price per night</p>
                            <p class="text-3xl font-bold text-white">₱{{ number_format($room->price, 0) }}</p>
                        </div>

                        <div class="border-t border-white/10 pt-6 space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-400">₱{{ number_format($room->price, 0) }} x 1 night</span>
                                <span class="text-white">₱{{ number_format($room->price, 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-400">Service fee</span>
                                <span class="text-white">₱0</span>
                            </div>
                        </div>

                        <div class="border-t border-white/10 pt-6">
                            <div class="flex items-center justify-between font-semibold">
                                <span class="text-white">Total</span>
                                <span class="text-white text-xl">₱{{ number_format($room->price, 0) }}</span>
                            </div>
                        </div>

                        <a href="{{ auth()->check() ? route('booking.step1') : route('login') }}" 
                           class="block w-full px-6 py-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg text-center">
                            Reserve Now
                        </a>

                        <p class="text-xs text-slate-400 text-center">You won't be charged yet</p>
                    </div>
                </div>
            </div>

            {{-- Reviews Section --}}
            <div class="mb-16">
                <div class="bg-slate-900/30 border border-white/10 rounded-2xl p-8 scroll-animate">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-white mb-2">Guest Reviews</h2>
                            @php
                                $avgRating = $room->averageRating();
                                $reviewCount = $room->reviewsCount();
                            @endphp
                            @if($reviewCount > 0)
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-4xl font-bold text-white">{{ number_format($avgRating, 1) }}</span>
                                        <div>
                                            <div class="flex items-center gap-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'text-yellow-400 fill-current' : 'text-slate-600' }}" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <p class="text-sm text-slate-400 mt-1">Based on {{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-slate-400">No reviews yet. Be the first to review this room!</p>
                            @endif
                        </div>
                    </div>

                    {{-- Reviews List --}}
                    @if($room->approvedReviews()->count() > 0)
                        <div class="space-y-6">
                            @foreach($room->approvedReviews()->with('user')->latest()->take(5)->get() as $review)
                                <div class="border-t border-white/10 pt-6 first:border-0 first:pt-0">
                                    <div class="flex items-start gap-4">
                                        {{-- User Avatar --}}
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            {{-- User Name & Date --}}
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <p class="font-semibold text-white">{{ $review->user->name }}</p>
                                                    <p class="text-sm text-slate-400">{{ $review->created_at->format('M d, Y') }}</p>
                                                </div>
                                                {{-- Rating --}}
                                                <div class="flex items-center gap-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-slate-600' }}" viewBox="0 0 20 20">
                                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>

                                            {{-- Review Comment --}}
                                            <p class="text-slate-300 leading-relaxed">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- View All Reviews Link --}}
                        @if($room->approvedReviews()->count() > 5)
                            <div class="mt-8 text-center">
                                <button class="inline-flex items-center gap-2 px-6 py-3 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white font-medium rounded-xl transition">
                                    View All {{ $room->approvedReviews()->count() }} Reviews
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            <h3 class="text-xl font-semibold text-slate-400 mb-2">No Reviews Yet</h3>
                            <p class="text-slate-500">Be the first to share your experience with this room!</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Related Rooms --}}
            @if($relatedRooms->count() > 0)
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-white mb-8 scroll-animate">Similar Rooms</h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($relatedRooms as $relatedRoom)
                            <div class="scroll-animate">
                                <x-modern-room-card :room="$relatedRoom" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
