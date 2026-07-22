<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'StayVacation') }} - Luxury Hotel Booking</title>
    <meta name="description" content="Book your perfect stay at StayVacation. Modern rooms, instant confirmation, competitive rates.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=playfair-display:700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        section[id] { scroll-margin-top: 80px; }
        
        /* Image hover zoom effect */
        .room-image-wrapper { overflow: hidden; }
        .room-image { transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
        .room-image-wrapper:hover .room-image { transform: scale(1.1); }
        
        /* Skeleton loader */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        .skeleton {
            background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
        
        /* Gradient overlay for hero */
        .hero-gradient {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.85) 100%);
        }

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
        .scroll-animate:nth-child(4) { transition-delay: 0.4s; }
        .scroll-animate:nth-child(5) { transition-delay: 0.5s; }
        .scroll-animate:nth-child(6) { transition-delay: 0.6s; }
    </style>

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
</head>
<body class="font-sans antialiased bg-slate-950 text-white">

    {{-- Enhanced Navigation --}}
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" 
            x-data="{ scrolled: false, mobileMenu: false }" 
            x-init="window.addEventListener('scroll', () => { scrolled = (window.pageYOffset > 20) })"
            :class="scrolled ? 'bg-slate-950/95 backdrop-blur-xl border-b border-white/10 shadow-xl' : 'bg-transparent'">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="StayVacation Logo" class="h-12 w-auto object-contain drop-shadow-lg group-hover:scale-105 transition-transform duration-300">
                    <div class="hidden sm:block">
                        <span class="font-display font-bold text-xl tracking-tight text-white group-hover:text-primary-400 transition-colors">{{ config('app.name', 'StayVacation') }}</span>
                        <p class="text-xs text-slate-400 -mt-0.5">Luxury Resort & Stays</p>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden lg:flex items-center gap-8 text-sm font-medium">
                    <a href="#home" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                        <span>Home</span>
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('rooms.index') }}" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                        <span>Browse Rooms</span>
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#about" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                        <span>About Us</span>
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#features" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                        <span>Features</span>
                        <span class="absolute -bottom-1 left-0 w-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#testimonials" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                        <span>Reviews</span>
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('contact') }}" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                        <span>Contact</span>
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>

                {{-- Auth Actions --}}
                <div class="flex items-center gap-3">
                    @auth
                    @php
                        $currentUser = auth()->user();
                        $userBookings = $currentUser ? $currentUser->bookings()->with('room')->latest()->take(5)->get() : collect();
                        $confirmedBookings = $currentUser ? $currentUser->bookings()->where('status', 'confirmed')->with('room')->latest()->take(5)->get() : collect();
                    @endphp

                    <div class="relative" x-data="{ openNotifications: false }">
                        <button @click="openNotifications = !openNotifications" @click.away="openNotifications = false"
                            class="relative rounded-full p-2 text-slate-300 transition hover:bg-white/10 hover:text-white">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 1 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            @if($confirmedBookings->count())
                                <span class="absolute -right-0.5 -top-0.5 min-h-5 min-w-5 rounded-full bg-indigo-500 px-1.5 text-[10px] font-semibold text-white flex items-center justify-center">
                                    {{ $confirmedBookings->count() }}
                                </span>
                            @endif
                        </button>

                        <div x-show="openNotifications" x-cloak
                             class="absolute right-0 mt-2 w-72 rounded-lg border border-white/10 bg-slate-900 py-2 shadow-xl z-50">
                            <div class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Notifications</div>
                            @forelse($confirmedBookings as $booking)
                                <div class="border-b border-white/5 px-3 py-2 text-sm text-slate-300 last:border-b-0">
                                    <p class="font-medium text-white">Booking confirmed</p>
                                    <p class="text-xs text-slate-400">{{ $booking->room->name ?? 'Room' }} • {{ $booking->check_in->format('M d') }} to {{ $booking->check_out->format('M d') }}</p>
                                </div>
                            @empty
                                <div class="px-3 py-2 text-sm text-slate-400">No new notifications.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="relative">
                        <a href="{{ route('bookings.index') }}"
                            class="relative rounded-full p-2 text-slate-300 transition hover:bg-white/10 hover:text-white inline-flex items-center justify-center">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h12a2.25 2.25 0 0 1 2.25 2.25v11.25m-17.25 0a2.25 2.25 0 0 0 2.25 2.25h12a2.25 2.25 0 0 0 2.25-2.25m-17.25 0h17.25" />
                            </svg>
                            @if($userBookings->count())
                                <span class="absolute top-0 right-0 min-h-5 min-w-5 rounded-full bg-emerald-500 px-1.5 text-[10px] font-semibold text-white flex items-center justify-center">
                                    {{ $userBookings->count() }}
                                </span>
                            @endif
                        </a>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition">
                            <div class="w-8 h-8 rounded-full bg-indigo-500/20 text-indigo-300 flex items-center justify-center text-xs font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="open" x-cloak
                             class="absolute right-0 mt-2 w-48 bg-slate-900 border border-white/10 rounded-lg shadow-xl py-1 z-50">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">Admin dashboard</a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">Profile</a>
                            <a href="{{ route('booking.step1') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">New booking</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">Log out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white transition">Log in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-sm font-semibold bg-indigo-500 hover:bg-indigo-400 transition">Register</a>
                @endauth
            </div>
        </nav>
    </header>

    {{-- HOME --}}
<section id="home" class="relative">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center py-16 lg:py-24">
        <div class="scroll-animate-left">
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-300 bg-indigo-500/10 border border-indigo-500/20 px-3 py-1 rounded-full mb-6">
                Comfort. Convenience. Confirmed.
            </span>

            <h1 class="text-4xl sm:text-5xl font-extrabold leading-[1.1] tracking-tight mb-6">
                @auth
                    Welcome! {{ auth()->user()->name }}.<br class="hidden sm:block">
                    <span class="text-indigo-400">Ready for your next stay?</span>
                @else
                    Find your perfect stay,<br class="hidden sm:block">
                    <span class="text-indigo-400">book it in minutes.</span>
                @endauth
            </h1>

            <p class="text-slate-400 text-lg mb-8 max-w-md">
                Browse rooms, pick your dates, and get instant confirmation sent straight to your inbox.
            </p>

            <div class="flex flex-wrap gap-3 mb-10">
                <a href="{{ route('book-now') }}"
                   class="px-6 py-3 rounded-lg bg-indigo-500 hover:bg-indigo-400 font-semibold transition">
                    Book now
                </a>
                @guest
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 rounded-lg bg-white/5 hover:bg-white/10 font-semibold border border-white/10 transition">
                        Log in
                    </a>
                @endguest
            </div>

            <div class="flex gap-8 text-sm">
                <div>
                    <p class="text-2xl font-bold">{{ $rooms->count() }}</p>
                    <p class="text-slate-500">Room types</p>
                </div>
                <div>
                    <p class="text-2xl font-bold">24/7</p>
                    <p class="text-slate-500">Booking access</p>
                </div>
                <div>
                    <p class="text-2xl font-bold">Instant</p>
                    <p class="text-slate-500">Email confirmation</p>
                </div>
            </div>
        </div>

        <div class="relative scroll-animate-right">
            <div class="rounded-2xl overflow-hidden border border-white/10 shadow-2xl">
                <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1000&q=80"
                     alt="Luxury hotel room" class="w-full h-[420px] object-cover">
            </div>
            <div class="absolute -bottom-6 -left-6 bg-slate-900 border border-white/10 rounded-xl p-4 shadow-xl hidden sm:block">
                <p class="text-xs text-slate-400 mb-1">Deluxe Room</p>
                <p class="text-lg font-bold">₱2,500<span class="text-sm font-normal text-slate-400">/night</span></p>
            </div>
        </div>
    </div>
    
    {{-- Scroll Indicator --}}
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 scroll-animate-scale hidden lg:block">
        <a href="#rooms" class="flex flex-col items-center gap-2 text-slate-400 hover:text-white transition group">
            <span class="text-xs font-medium">Scroll to explore</span>
            <svg class="w-6 h-6 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </a>
    </div>
</section>

    {{-- ROOMS SECTION --}}
    <section id="rooms" class="border-t border-white/10 bg-white/[0.02] py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 scroll-animate">
                <h2 class="text-4xl font-display font-bold text-white mb-4">
                    Discover Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">Luxury Rooms</span>
                </h2>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                    Choose from our carefully curated selection of rooms designed for comfort and elegance
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($rooms->take(3) as $room)
                    <div class="scroll-animate">
                        <x-modern-room-card :room="$room" />
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <p class="text-slate-400 text-lg">No rooms available at the moment</p>
                    </div>
                @endforelse
            </div>

            {{-- View All Button --}}
            @if($rooms->count() > 3)
                <div class="text-center mt-12 scroll-animate">
                    <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105">
                        View All {{ $rooms->count() }} Rooms
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- ABOUT US SECTION --}}
    <section id="about" class="py-20 bg-slate-950 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 scroll-animate">
                <h2 class="text-4xl font-display font-bold text-white mb-4">
                    About <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">StayVacation</span>
                </h2>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                    Your trusted partner for memorable stays and exceptional hospitality since 2020
                </p>
            </div>

            {{-- Story Section --}}
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
                <div class="scroll-animate-left">
                    <div class="relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80" 
                             alt="Hotel lobby" 
                             class="w-full h-[400px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                    </div>
                </div>

                <div class="scroll-animate-right">
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-primary-400 bg-primary-500/10 border border-primary-500/20 rounded-full mb-4">
                        Our Story
                    </span>
                    <h3 class="text-3xl font-bold text-white mb-4">Creating Unforgettable Experiences</h3>
                    <p class="text-slate-300 leading-relaxed mb-4">
                        Founded in 2020, StayVacation was born from a simple vision: to provide travelers with more than just a place to sleep. We wanted to create a home away from home, where every guest feels valued and every stay becomes a cherished memory.
                    </p>
                    <p class="text-slate-300 leading-relaxed mb-6">
                        Today, we're proud to serve thousands of guests annually, offering premium accommodations combined with cutting-edge booking technology and personalized service that sets us apart.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-900/50 border border-white/10 rounded-xl p-4">
                            <p class="text-3xl font-bold text-primary-400 mb-1">5,000+</p>
                            <p class="text-sm text-slate-400">Happy Guests</p>
                        </div>
                        <div class="bg-slate-900/50 border border-white/10 rounded-xl p-4">
                            <p class="text-3xl font-bold text-primary-400 mb-1">4.8/5</p>
                            <p class="text-sm text-slate-400">Average Rating</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Values Section --}}
            <div class="scroll-animate">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-white mb-4">Our Core Values</h3>
                    <p class="text-slate-400 max-w-2xl mx-auto">
                        The principles that guide everything we do
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-slate-900/30 border border-white/10 rounded-2xl p-8 text-center hover:border-primary-500/40 transition-all duration-300">
                        <div class="w-16 h-16 bg-primary-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-3">Hospitality First</h4>
                        <p class="text-slate-400">Every guest is family. We go above and beyond to ensure comfort and satisfaction.</p>
                    </div>

                    <div class="bg-slate-900/30 border border-white/10 rounded-2xl p-8 text-center hover:border-primary-500/40 transition-all duration-300">
                        <div class="w-16 h-16 bg-primary-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-3">Trust & Safety</h4>
                        <p class="text-slate-400">Your safety is our priority. We maintain the highest standards of cleanliness and security.</p>
                    </div>

                    <div class="bg-slate-900/30 border border-white/10 rounded-2xl p-8 text-center hover:border-primary-500/40 transition-all duration-300">
                        <div class="w-16 h-16 bg-primary-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-3">Innovation</h4>
                        <p class="text-slate-400">We leverage technology to make booking seamless and your stay unforgettable.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="features" class="py-20 bg-slate-950">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 scroll-animate">
                <h2 class="text-4xl font-display font-bold text-white mb-4">
                    Why Choose <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">StayVacation</span>
                </h2>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                    Experience hassle-free booking with premium features designed for your convenience
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="scroll-animate">
                    <x-feature-card 
                        title="Instant Confirmation"
                        description="Get your booking confirmed immediately via email with all details and QR code for easy check-in.">
                        <x-slot:icon>
                            <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </x-slot:icon>
                    </x-feature-card>
                </div>

                <div class="scroll-animate">
                    <x-feature-card 
                        title="Free Cancellation"
                        description="Plans changed? Cancel up to 24 hours before check-in for a full refund. No questions asked.">
                        <x-slot:icon>
                            <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </x-slot:icon>
                    </x-feature-card>
                </div>

                <div class="scroll-animate">
                    <x-feature-card 
                        title="Best Price Guarantee"
                        description="Found a lower price elsewhere? We'll match it and give you an extra 10% off your booking.">
                        <x-slot:icon>
                            <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </x-slot:icon>
                    </x-feature-card>
                </div>

                <div class="scroll-animate">
                    <x-feature-card 
                        title="24/7 Customer Support"
                        description="Our dedicated support team is always available to assist you, day or night, via phone or chat.">
                        <x-slot:icon>
                            <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </x-slot:icon>
                    </x-feature-card>
                </div>

                <div class="scroll-animate">
                    <x-feature-card 
                        title="Secure Payment"
                        description="Your payment information is encrypted and secure. We support multiple payment methods for your convenience.">
                        <x-slot:icon>
                            <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </x-slot:icon>
                    </x-feature-card>
                </div>

                <div class="scroll-animate">
                    <x-feature-card 
                        title="No Hidden Fees"
                        description="What you see is what you pay. No surprise charges or hidden costs at checkout.">
                        <x-slot:icon>
                            <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </x-slot:icon>
                    </x-feature-card>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS SECTION --}}
    <section id="testimonials" class="py-20 bg-white/[0.02]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 scroll-animate">
                <h2 class="text-4xl font-display font-bold text-white mb-4">
                    What Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">Guests Say</span>
                </h2>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                    Don't just take our word for it - hear from our satisfied guests
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="scroll-animate">
                    <x-testimonial-card 
                        name="Maria Santos"
                        location="Manila, Philippines"
                        rating="5"
                        initial="M"
                        review="Absolutely wonderful experience! The room was spotless, staff was incredibly friendly, and the booking process was so smooth. Will definitely be back!" />
                </div>

                <div class="scroll-animate">
                    <x-testimonial-card 
                        name="John Rodriguez"
                        location="Cebu, Philippines"
                        rating="5"
                        initial="J"
                        review="Best hotel stay I've had in years. The amenities were top-notch and the instant booking confirmation gave me peace of mind. Highly recommended!" />
                </div>

                <div class="scroll-animate">
                    <x-testimonial-card 
                        name="Ana Reyes"
                        location="Davao, Philippines"
                        rating="4"
                        initial="A"
                        review="Great value for money! The room exceeded my expectations and the customer service was excellent. Perfect for both business and leisure stays." />
                </div>
            </div>

            {{-- Trust Badges --}}
            <div class="mt-16 pt-12 border-t border-white/10 scroll-animate">
                <p class="text-center text-slate-400 text-sm mb-8">Trusted by thousands of guests and secured by:</p>
                <div class="flex flex-wrap items-center justify-center gap-8 opacity-50">
                    <div class="px-6 py-3 bg-white/5 rounded-lg">
                        <p class="text-white font-semibold text-sm">🔒 SSL Secured</p>
                    </div>
                    <div class="px-6 py-3 bg-white/5 rounded-lg">
                        <p class="text-white font-semibold text-sm">💳 Visa</p>
                    </div>
                    <div class="px-6 py-3 bg-white/5 rounded-lg">
                        <p class="text-white font-semibold text-sm">💳 Mastercard</p>
                    </div>
                    <div class="px-6 py-3 bg-white/5 rounded-lg">
                        <p class="text-white font-semibold text-sm">💰 GCash</p>
                    </div>
                    <div class="px-6 py-3 bg-white/5 rounded-lg">
                        <p class="text-white font-semibold text-sm">💰 PayMaya</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ SECTION --}}
    <section id="faq" class="py-20 bg-slate-950">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-display font-bold text-white mb-4">
                    Frequently Asked <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">Questions</span>
                </h2>
                <p class="text-slate-400 text-lg">
                    Everything you need to know about booking with us
                </p>
            </div>

            <div class="space-y-4" x-data="{ open: null }">
                {{-- FAQ Item 1 --}}
                <div class="bg-slate-900/50 border border-white/10 rounded-xl overflow-hidden">
                    <button @click="open = open === 1 ? null : 1" 
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/5 transition-colors">
                        <span class="font-semibold text-white">What is your cancellation policy?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{ 'rotate-180': open === 1 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse>
                        <div class="px-6 pb-4 text-slate-400 text-sm leading-relaxed">
                            You can cancel your booking free of charge up to 24 hours before your scheduled check-in time. Cancellations made within 24 hours of check-in are subject to a one-night charge.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 2 --}}
                <div class="bg-slate-900/50 border border-white/10 rounded-xl overflow-hidden">
                    <button @click="open = open === 2 ? null : 2" 
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/5 transition-colors">
                        <span class="font-semibold text-white">What time is check-in and check-out?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{ 'rotate-180': open === 2 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse>
                        <div class="px-6 pb-4 text-slate-400 text-sm leading-relaxed">
                            Check-in time is 2:00 PM and check-out time is 12:00 PM (noon). Early check-in and late check-out may be available upon request, subject to availability.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 3 --}}
                <div class="bg-slate-900/50 border border-white/10 rounded-xl overflow-hidden">
                    <button @click="open = open === 3 ? null : 3" 
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/5 transition-colors">
                        <span class="font-semibold text-white">How do I receive my booking confirmation?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{ 'rotate-180': open === 3 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse>
                        <div class="px-6 pb-4 text-slate-400 text-sm leading-relaxed">
                            Once your booking is complete, you'll receive an instant confirmation email with all your reservation details, including a booking reference number and QR code.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 4 --}}
                <div class="bg-slate-900/50 border border-white/10 rounded-xl overflow-hidden">
                    <button @click="open = open === 4 ? null : 4" 
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/5 transition-colors">
                        <span class="font-semibold text-white">What payment methods do you accept?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{ 'rotate-180': open === 4 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 4" x-collapse>
                        <div class="px-6 pb-4 text-slate-400 text-sm leading-relaxed">
                            We accept credit/debit cards (Visa, Mastercard), e-wallets (GCash, PayMaya), and bank transfers. You can also upload payment proof after completing your booking.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 5 --}}
                <div class="bg-slate-900/50 border border-white/10 rounded-xl overflow-hidden">
                    <button @click="open = open === 5 ? null : 5" 
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/5 transition-colors">
                        <span class="font-semibold text-white">Are pets allowed?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{ 'rotate-180': open === 5 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 5" x-collapse>
                        <div class="px-6 pb-4 text-slate-400 text-sm leading-relaxed">
                            Selected rooms are pet-friendly. Please contact us in advance to arrange accommodations for your furry friends. Additional cleaning fees may apply.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Back to Top Button --}}
    <button 
        x-data="{ show: false }"
        x-show="show"
        @scroll.window="show = window.pageYOffset > 300"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        x-cloak
        class="fixed bottom-8 right-8 w-12 h-12 bg-primary-500 hover:bg-primary-600 text-white rounded-full shadow-luxury flex items-center justify-center transition-all duration-300 hover:scale-110 z-40">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    {{-- CONTACT SECTION --}}
    <section id="contact" class="py-20 bg-slate-950 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 scroll-animate">
                <h2 class="text-4xl font-display font-bold text-white mb-4">
                    Get In <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">Touch</span>
                </h2>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                    Have questions? We're here to help you 24/7
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <div class="scroll-animate text-center">
                    <div class="w-16 h-16 bg-primary-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Phone</h3>
                    <p class="text-slate-400">+63 123 456 7890</p>
                    <p class="text-slate-400">Mon-Sun, 24/7</p>
                </div>

                <div class="scroll-animate text-center">
                    <div class="w-16 h-16 bg-primary-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Email</h3>
                    <p class="text-slate-400">info@stayvacation.com</p>
                    <p class="text-slate-400">support@stayvacation.com</p>
                </div>

                <div class="scroll-animate text-center">
                    <div class="w-16 h-16 bg-primary-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Location</h3>
                    <p class="text-slate-400">123 Hotel Street</p>
                    <p class="text-slate-400">Manila, Philippines</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-slate-950 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                {{-- Brand --}}
                <div class="md:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="StayVacation Logo" class="h-11 w-auto object-contain drop-shadow">
                        <div>
                            <span class="font-display font-bold text-white text-lg tracking-tight">StayVacation</span>
                            <p class="text-xs text-slate-400">Luxury Resort & Stays</p>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Your trusted partner for comfortable and memorable hotel stays across the Philippines.
                    </p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#home" class="text-slate-400 hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="text-slate-400 hover:text-white transition">Browse Rooms</a></li>
                        <li><a href="#about" class="text-slate-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#features" class="text-slate-400 hover:text-white transition">Features</a></li>
                    </ul>
                </div>

                {{-- Support --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('contact') }}" class="text-slate-400 hover:text-white transition">Contact Us</a></li>
                        <li><a href="#testimonials" class="text-slate-400 hover:text-white transition">Reviews</a></li>
                        <li><a href="{{ route('terms') }}" class="text-slate-400 hover:text-white transition">Terms of Service</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-slate-400 hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="{{ route('cancellation') }}" class="text-slate-400 hover:text-white transition">Cancellation Policy</a></li>
                        <li><a href="{{ route('refund') }}" class="text-slate-400 hover:text-white transition">Refund Policy</a></li>
                    </ul>
                </div>

                {{-- Newsletter --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Stay Updated</h4>
                    <p class="text-slate-400 text-sm mb-4">Subscribe to get special offers and updates</p>
                    <div class="flex gap-2">
                        <input type="email" placeholder="Your email" class="flex-1 px-3 py-2 bg-slate-900 border border-white/10 rounded-lg text-sm text-white placeholder:text-slate-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30">
                        <button class="px-4 py-2 bg-primary-500 hover:bg-primary-600 rounded-lg transition">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-slate-400 text-sm">
                    © {{ date('Y') }} StayVacation. All rights reserved.
                </p>
                
                {{-- Social Links --}}
                <div class="flex items-center gap-4">
                    <a href="#" class="w-9 h-9 bg-slate-900 hover:bg-primary-500 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-9 h-9 bg-slate-900 hover:bg-primary-500 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-9 h-9 bg-slate-900 hover:bg-primary-500 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>