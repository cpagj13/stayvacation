<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Hotel Booking') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-950 text-white">

    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- Left: brand panel (hidden on mobile) --}}
        <div class="hidden lg:flex flex-col justify-between p-12 relative overflow-hidden"
             style="background-image: linear-gradient(rgba(15,23,42,0.85), rgba(15,23,42,0.92)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80'); background-size: cover; background-position: center;">

            <a href="/" class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-lg bg-indigo-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <span class="font-bold text-lg tracking-tight">{{ config('app.name', 'Hotel Booking') }}</span>
            </a>

            <div>
                <h2 class="text-3xl font-bold leading-tight mb-3">Your next stay is<br>a few clicks away.</h2>
                <p class="text-slate-400 max-w-sm">Manage your bookings, view confirmations, and get instant updates sent straight to your inbox.</p>
            </div>
        </div>

        {{-- Right: form panel --}}
        <div class="flex flex-col justify-center px-6 py-12 sm:px-12 lg:px-16">
            <div class="w-full max-w-sm mx-auto">

                {{-- Mobile-only logo --}}
                <a href="/" class="flex lg:hidden items-center gap-2.5 mb-10">
                    <div class="w-9 h-9 rounded-lg bg-indigo-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                    <span class="font-bold text-lg tracking-tight">{{ config('app.name', 'Hotel Booking') }}</span>
                </a>

                @if (session('status'))
                    <div class="mb-6 text-sm font-medium text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-lg px-4 py-3">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>