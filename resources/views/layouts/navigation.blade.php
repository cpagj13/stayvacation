@php
    $currentUser = auth()->user();
    $userBookings = $currentUser ? $currentUser->bookings()->with('room')->latest()->take(5)->get() : collect();
    $confirmedBookings = $currentUser ? $currentUser->bookings()->where('status', 'confirmed')->with('room')->latest()->take(5)->get() : collect();
@endphp

<nav class="border-b border-white/10 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16 items-center">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="StayVacation Logo" class="h-11 w-auto object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-300">
                <div class="hidden sm:block">
                    <span class="font-bold text-white tracking-tight text-lg group-hover:text-primary-400 transition-colors">{{ config('app.name', 'StayVacation') }}</span>
                    <p class="text-[10px] text-slate-400 -mt-1">Luxury Resort & Stays</p>
                </div>
            </a>

            {{-- Centered Navigation --}}
            <div class="hidden lg:flex gap-1 absolute left-1/2 transform -translate-x-1/2">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }} transition">
                    Home
                </a>
                <a href="{{ route('rooms.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('rooms.*') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }} transition">
                    Browse Rooms
                </a>
                <a href="{{ route('bookings.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('bookings.*') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }} transition">
                    Your Bookings
                </a>
                <a href="{{ route('booking.step1') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('booking.step*') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }} transition">
                    Book a Room
                </a>
            </div>

            <div class="flex items-center gap-2">
                <div class="relative" x-data="{ openNotifications: false }">
                    <button @click="openNotifications = !openNotifications" @click.away="openNotifications = false"
                        class="relative rounded-full p-2 text-slate-300 transition hover:bg-white/10 hover:text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 1 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                        @if($confirmedBookings->count())
                            <span class="absolute top-0 right-0 min-h-5 min-w-5 rounded-full bg-indigo-500 px-1.5 text-[10px] font-semibold text-white flex items-center justify-center">
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
                            {{ $currentUser ? strtoupper(substr($currentUser->name, 0, 1)) : 'G' }}
                        </div>
                        <span class="hidden sm:block">{{ $currentUser ? $currentUser->name : 'Guest' }}</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <div x-show="open" x-cloak
                        class="absolute right-0 mt-2 w-48 bg-slate-900 border border-white/10 rounded-lg shadow-xl py-1 z-50">
                        @if($currentUser && $currentUser->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">
                                Admin dashboard
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
