<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-16 flex items-center justify-center px-4">
        <div class="max-w-xl w-full mx-auto">

            <!-- Container Box Card -->
            <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-slate-900/70 p-8 md:p-10 shadow-2xl shadow-emerald-950/20 backdrop-blur-md">
                
                <!-- Background Accent Glow -->
                <div class="absolute -top-24 -right-24 h-48 w-48 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 h-48 w-48 rounded-full bg-indigo-500/10 blur-3xl pointer-events-none"></div>

                <!-- Success Icon & Header -->
                <div class="relative z-10 text-center">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-emerald-500/20 to-emerald-400/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-500/10">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </div>

                    <h1 class="text-3xl font-extrabold text-white mb-2 tracking-tight">Booking Submitted!</h1>
                    <p class="text-slate-400 text-sm max-w-md mx-auto mb-6">
                        Thank you, <span class="text-slate-200 font-semibold">{{ $booking->guest_name }}</span>. A confirmation email with your details has been sent to
                        <span class="text-emerald-400 font-semibold block mt-1">{{ auth()->user()->email }}</span>
                    </p>
                </div>

                <!-- Booking Summary Box Container -->
                <div class="relative z-10 mb-8 rounded-2xl border border-white/10 bg-slate-950/60 p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-white/10 pb-4">
                        <div>
                            <span class="text-xs text-slate-400 uppercase tracking-wider block">Booking Reference</span>
                            <span class="font-mono font-bold text-lg text-white">#{{ $booking->id }}</span>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 border border-amber-500/20 text-amber-400 capitalize">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-slate-400 text-xs block mb-0.5">Reserved Room</span>
                            <span class="font-semibold text-slate-200">{{ $booking->room->name ?? 'Room' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 text-xs block mb-0.5">Guests & Rooms</span>
                            <span class="font-semibold text-slate-200">{{ $booking->guests }} guest(s) · {{ $booking->rooms_count }} room(s)</span>
                        </div>
                        <div>
                            <span class="text-slate-400 text-xs block mb-0.5">Check-in</span>
                            <span class="font-semibold text-slate-200">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 text-xs block mb-0.5">Check-out</span>
                            <span class="font-semibold text-slate-200">{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-white/10 pt-4 text-sm">
                        <div>
                            <span class="text-slate-400 text-xs block">Payment Method</span>
                            <span class="font-semibold text-indigo-300 capitalize">{{ str_replace('_', ' ', $booking->payment_method ?? 'gcash') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-slate-400 text-xs block">Total Amount</span>
                            <span class="font-bold text-xl text-emerald-400">₱{{ number_format($booking->total_price, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="relative z-10 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('booking.step1') }}"
                       class="flex-1 inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-5 py-3 font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:from-emerald-600 hover:to-emerald-700 hover:scale-[1.02]">
                        Book Another Room
                    </a>
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 font-semibold text-slate-300 transition hover:bg-white/10 hover:text-white">
                        Back to Home
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>