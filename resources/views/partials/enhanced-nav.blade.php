{{-- Enhanced Navigation with scroll effects and dropdowns --}}
<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" 
        x-data="{ scrolled: false, mobileMenu: false }" 
        x-init="window.addEventListener('scroll', () => { scrolled = (window.pageYOffset > 20) })"
        :class="scrolled ? 'bg-slate-950/95 backdrop-blur-xl border-b border-white/10 shadow-2xl' : 'bg-transparent'">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group z-10">
                <img src="{{ asset('images/logo.png') }}" alt="StayVacation Logo" class="h-12 w-auto object-contain drop-shadow-lg group-hover:scale-105 transition-transform duration-300">
                <div class="hidden sm:block">
                    <span class="font-display font-bold text-xl tracking-tight text-white group-hover:text-primary-400 transition-colors">{{ config('app.name', 'StayVacation') }}</span>
                    <p class="text-xs text-slate-400 -mt-0.5">Luxury Stays</p>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center gap-8 text-sm font-medium">
                <a href="#home" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                    <span>Home</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#rooms" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                    <span>Rooms</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#features" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                    <span>Features</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#testimonials" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                    <span>Reviews</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#contact" class="text-slate-300 hover:text-white transition-colors duration-200 relative group">
                    <span>Contact</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            {{-- Auth Actions --}}
            <div class="flex items-center gap-3 z-10">
                @auth
                    {{-- User is logged in --}}
                    @php
                        $currentUser = auth()->user();
                        $userBookings = $currentUser ? $currentUser->bookings()->with('room')->latest()->take(5)->get() : collect();
                        $confirmedBookings = $currentUser ? $currentUser->bookings()->where('status', 'confirmed')->with('room')->latest()->take(5)->get() : collect();
                    @endphp

                    {{-- Mobile Menu Toggle --}}
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-slate-300 hover:text-white transition-colors">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    {{-- User Menu --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-all duration-200">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 text-white flex items-center justify-center text-sm font-semibold shadow-lg">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:block font-medium">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             x-cloak
                             class="absolute right-0 mt-2 w-56 bg-slate-900/95 backdrop-blur-xl border border-white/10 rounded-xl shadow-luxury py-2 overflow-hidden">
                            <div class="px-4 py-3 border-b border-white/10">
                                <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ auth()->user()->email }}</p>
                            </div>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Admin Dashboard
                                </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                            <a href="{{ route('booking.step1') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                New Booking
                            </a>
                            <div class="border-t border-white/10 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Guest user --}}
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-slate-300 hover:text-white transition-colors">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <a href="{{ route('login') }}" class="hidden md:block px-5 py-2.5 text-sm font-medium text-slate-300 hover:text-white transition-colors">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105">
                        Sign Up
                    </a>
                @endauth
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenu" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             x-cloak
             class="lg:hidden border-t border-white/10 py-4">
            <div class="space-y-1">
                <a href="#home" @click="mobileMenu = false" class="block px-4 py-2.5 text-slate-300 hover:bg-white/5 hover:text-white transition-colors">Home</a>
                <a href="#rooms" @click="mobileMenu = false" class="block px-4 py-2.5 text-slate-300 hover:bg-white/5 hover:text-white transition-colors">Rooms</a>
                <a href="#features" @click="mobileMenu = false" class="block px-4 py-2.5 text-slate-300 hover:bg-white/5 hover:text-white transition-colors">Features</a>
                <a href="#testimonials" @click="mobileMenu = false" class="block px-4 py-2.5 text-slate-300 hover:bg-white/5 hover:text-white transition-colors">Reviews</a>
                <a href="#contact" @click="mobileMenu = false" class="block px-4 py-2.5 text-slate-300 hover:bg-white/5 hover:text-white transition-colors">Contact</a>
                @guest
                    <div class="pt-2 border-t border-white/10 space-y-1">
                        <a href="{{ route('login') }}" class="block px-4 py-2.5 text-slate-300 hover:bg-white/5 hover:text-white transition-colors">Log In</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2.5 text-primary-400 hover:bg-primary-500/10 transition-colors font-semibold">Sign Up</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</header>
