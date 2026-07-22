<x-app-layout>
    @push('styles')
    <style>
        /* Bidirectional scroll animations */
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
        .scroll-animate:nth-child(1) { transition-delay: 0.05s; }
        .scroll-animate:nth-child(2) { transition-delay: 0.1s; }
        .scroll-animate:nth-child(3) { transition-delay: 0.15s; }
        .scroll-animate:nth-child(4) { transition-delay: 0.2s; }
        .scroll-animate:nth-child(5) { transition-delay: 0.25s; }
        .scroll-animate:nth-child(6) { transition-delay: 0.3s; }

        /* Status badges */
        .status-pending { @apply bg-yellow-500/10 text-yellow-400 border-yellow-500/20; }
        .status-confirmed { @apply bg-emerald-500/10 text-emerald-400 border-emerald-500/20; }
        .status-cancelled { @apply bg-red-500/10 text-red-400 border-red-500/20; }
        .status-completed { @apply bg-blue-500/10 text-blue-400 border-blue-500/20; }
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
            
            {{-- Page Header --}}
            <div class="mb-12 scroll-animate">
                <div class="flex items-center gap-4 mb-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Home
                    </a>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-display font-bold text-white mb-4">
                            Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">Bookings</span>
                        </h1>
                        <p class="text-slate-400 text-lg">
                            View and manage all your hotel reservations
                        </p>
                    </div>
                    
                    <a href="{{ route('booking.step1') }}" class="hidden sm:inline-flex items-center gap-2 px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        New Booking
                    </a>
                </div>
            </div>

            {{-- Summary Stats --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="scroll-animate bg-slate-900/50 border border-white/10 rounded-xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $bookings->count() }}</p>
                            <p class="text-sm text-slate-400">Total Bookings</p>
                        </div>
                    </div>
                </div>

                <div class="scroll-animate bg-slate-900/50 border border-white/10 rounded-xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                            <p class="text-sm text-slate-400">Confirmed</p>
                        </div>
                    </div>
                </div>

                <div class="scroll-animate bg-slate-900/50 border border-white/10 rounded-xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $bookings->where('status', 'pending')->count() }}</p>
                            <p class="text-sm text-slate-400">Pending</p>
                        </div>
                    </div>
                </div>

                <div class="scroll-animate bg-slate-900/50 border border-white/10 rounded-xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $bookings->where('status', 'completed')->count() }}</p>
                            <p class="text-sm text-slate-400">Completed</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="mb-8 scroll-animate" x-data="{ activeFilter: 'all' }">
                <div class="flex flex-wrap gap-3">
                    <button @click="activeFilter = 'all'" 
                            :class="activeFilter === 'all' ? 'bg-primary-500 text-white' : 'bg-slate-900/50 border border-white/10 text-slate-300 hover:bg-white/5 hover:text-white'"
                            class="px-4 py-2 rounded-lg font-medium transition">
                        All Bookings
                    </button>
                    <button @click="activeFilter = 'confirmed'" 
                            :class="activeFilter === 'confirmed' ? 'bg-primary-500 text-white' : 'bg-slate-900/50 border border-white/10 text-slate-300 hover:bg-white/5 hover:text-white'"
                            class="px-4 py-2 rounded-lg font-medium transition">
                        Confirmed
                    </button>
                    <button @click="activeFilter = 'pending'" 
                            :class="activeFilter === 'pending' ? 'bg-primary-500 text-white' : 'bg-slate-900/50 border border-white/10 text-slate-300 hover:bg-white/5 hover:text-white'"
                            class="px-4 py-2 rounded-lg font-medium transition">
                        Pending
                    </button>
                    <button @click="activeFilter = 'completed'" 
                            :class="activeFilter === 'completed' ? 'bg-primary-500 text-white' : 'bg-slate-900/50 border border-white/10 text-slate-300 hover:bg-white/5 hover:text-white'"
                            class="px-4 py-2 rounded-lg font-medium transition">
                        Completed
                    </button>
                    <button @click="activeFilter = 'cancelled'" 
                            :class="activeFilter === 'cancelled' ? 'bg-primary-500 text-white' : 'bg-slate-900/50 border border-white/10 text-slate-300 hover:bg-white/5 hover:text-white'"
                            class="px-4 py-2 rounded-lg font-medium transition">
                        Cancelled
                    </button>
                </div>

                {{-- Bookings List --}}
                <div class="space-y-6 mt-8">
                    @forelse($bookings as $booking)
                        <div class="scroll-animate bg-slate-900/50 border border-white/10 rounded-2xl overflow-hidden hover:border-primary-500/40 transition-all duration-300"
                             x-show="activeFilter === 'all' || activeFilter === '{{ $booking->status }}'"
                             x-transition>
                        <div class="grid md:grid-cols-12 gap-6 p-6">
                            {{-- Room Image --}}
                            <div class="md:col-span-3">
                                @php
                                    $hotelImages = [
                                        'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=400&q=80',
                                        'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=400&q=80',
                                        'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=400&q=80',
                                        'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=400&q=80',
                                        'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=400&q=80',
                                        'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=400&q=80',
                                        'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=400&q=80',
                                        'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=400&q=80',
                                    ];
                                    $imageUrl = $hotelImages[$booking->room->id % count($hotelImages)];
                                @endphp
                                <div class="relative h-48 md:h-full rounded-xl overflow-hidden">
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $booking->room->name }}" 
                                         class="absolute inset-0 w-full h-full object-cover">
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1 text-xs font-semibold border rounded-full status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Booking Details --}}
                            <div class="md:col-span-6">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $booking->room->name }}</h3>
                                <p class="text-slate-400 text-sm mb-4">{{ $booking->room->category->name ?? 'Standard Room' }}</p>
                                
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-slate-300">
                                            <span class="font-medium text-white">Check-in:</span> 
                                            {{ $booking->check_in->format('M d, Y') }} (2:00 PM)
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-slate-300">
                                            <span class="font-medium text-white">Check-out:</span> 
                                            {{ $booking->check_out->format('M d, Y') }} (12:00 PM)
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="text-slate-300">
                                            <span class="font-medium text-white">Guests:</span> 
                                            {{ $booking->guests_count ?? 1 }} {{ Str::plural('Guest', $booking->guests_count ?? 1) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <span class="text-slate-300">
                                            <span class="font-medium text-white">Nights:</span> 
                                            {{ $booking->check_in->diffInDays($booking->check_out) }} {{ Str::plural('Night', $booking->check_in->diffInDays($booking->check_out)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Price and Actions --}}
                            <div class="md:col-span-3 flex flex-col justify-between">
                                <div>
                                    <p class="text-slate-400 text-sm mb-1">Total Price</p>
                                    <p class="text-3xl font-bold text-white mb-1">
                                        ₱{{ number_format($booking->total_price, 0) }}
                                    </p>
                                    <p class="text-xs text-slate-500">Booking #{{ $booking->id }}</p>
                                </div>

                                <div class="space-y-2 mt-4">
                                    <a href="{{ route('rooms.show', $booking->room) }}" 
                                       class="block w-full px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-center font-medium rounded-lg transition">
                                        View Room
                                    </a>
                                    
                                    @if($booking->status === 'pending')
                                        <button class="w-full px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-center font-medium rounded-lg transition border border-white/10">
                                            Cancel Booking
                                        </button>
                                    @endif

                                    @if($booking->status === 'confirmed')
                                        <button class="w-full px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-center font-medium rounded-lg transition border border-white/10">
                                            Download Receipt
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="scroll-animate text-center py-20">
                        <div class="w-20 h-20 bg-slate-900/50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">No Bookings Yet</h3>
                        <p class="text-slate-400 mb-6">You haven't made any reservations. Start exploring our rooms!</p>
                        <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105">
                            Browse Rooms
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
