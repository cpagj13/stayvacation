<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-12">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Back Button --}}
            <div class="mb-8">
                <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Rooms
                </a>
            </div>

            {{-- Page Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-display font-bold text-white mb-4">
                    Book Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">Perfect Stay</span>
                </h1>
                <p class="text-slate-400 text-lg">Complete the form below to reserve your room</p>
            </div>

            {{-- Progress Steps --}}
            <div class="mb-10 bg-slate-900/30 border border-white/10 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 text-white text-sm font-bold flex items-center justify-center shadow-lg">
                            1
                        </div>
                        <div>
                            <p class="text-white font-semibold">Booking Details</p>
                            <p class="text-xs text-slate-400">Fill your information</p>
                        </div>
                    </div>
                    <div class="flex-1 h-0.5 bg-white/10 mx-4"></div>
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-slate-500 text-sm font-bold flex items-center justify-center">
                            2
                        </div>
                        <div>
                            <p class="text-slate-500 font-semibold">Payment Proof</p>
                            <p class="text-xs text-slate-600">Upload receipt</p>
                        </div>
                    </div>
                    <div class="flex-1 h-0.5 bg-white/10 mx-4"></div>
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-slate-500 text-sm font-bold flex items-center justify-center">
                            3
                        </div>
                        <div>
                            <p class="text-slate-500 font-semibold">Confirmation</p>
                            <p class="text-xs text-slate-600">Review & confirm</p>
                        </div>
                    </div>
                </div>
            </div>

        @if(session('error'))
            <div class="mb-6 flex items-start gap-3 text-sm font-medium text-red-400 bg-red-500/10 border border-red-500/20 rounded-xl px-5 py-4">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Booking Form --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-white/10 bg-slate-900/50 p-8 shadow-xl backdrop-blur">
                    <form method="POST" action="{{ route('booking.step1.store') }}" class="space-y-6">
                        @csrf

                        <div class="flex items-start gap-3 rounded-xl border border-primary-500/20 bg-primary-500/10 px-4 py-3 text-sm text-slate-300">
                            <svg class="w-5 h-5 text-primary-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Select a room first to see dates already booked.</span>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Full name
                            </label>
                            <input type="text" name="guest_name" value="{{ old('guest_name', auth()->user()->name) }}"
                                class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-slate-100 placeholder:text-slate-400 transition focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 hover:border-slate-600">
                            @error('guest_name') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-white flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Number of guests
                                </label>
                                <input type="number" name="guests" min="1" max="12" value="{{ old('guests', 1) }}"
                                    class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-slate-100 transition focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 hover:border-slate-600">
                                @error('guests') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-white flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Number of rooms
                                </label>
                                <input type="number" name="rooms_count" min="1" max="20" value="{{ old('rooms_count', 1) }}"
                                    class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-slate-100 transition focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 hover:border-slate-600">
                                @error('rooms_count') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Select Room
                            </label>
                            <select name="room_id" id="room_id"
                                class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-slate-100 transition focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 hover:border-slate-600 cursor-pointer">
                                <option value="" data-price="0" class="bg-slate-900">Choose your room...</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" data-price="{{ $room->price }}" class="bg-slate-900" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }} — ₱{{ number_format($room->price, 2) }}/night
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-white flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Check-in date
                                </label>
                                <input type="text" id="check_in" name="check_in" value="{{ old('check_in') }}" readonly required
                                    placeholder="Select check-in date"
                                    class="w-full cursor-pointer rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-slate-100 placeholder:text-slate-500 transition focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 hover:border-slate-600">
                                @error('check_in') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-white flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Check-out date
                                </label>
                                <input type="text" id="check_out" name="check_out" value="{{ old('check_out') }}" readonly required
                                    placeholder="Select check-out date"
                                    class="w-full cursor-pointer rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-slate-100 placeholder:text-slate-500 transition focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 hover:border-slate-600">
                                @error('check_out') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="mb-3 block text-sm font-semibold text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                Select Payment Method
                            </label>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <label class="relative flex flex-col items-center justify-center p-3.5 rounded-xl border border-slate-700 bg-slate-950/60 cursor-pointer hover:border-primary-500/60 transition has-[:checked]:border-primary-500 has-[:checked]:bg-primary-500/10 group text-center">
                                    <input type="radio" name="payment_method" value="gcash" class="sr-only" {{ old('payment_method', 'gcash') == 'gcash' ? 'checked' : '' }}>
                                    <span class="text-sm font-bold text-white group-has-[:checked]:text-primary-400">GCash</span>
                                    <span class="text-[11px] text-slate-400">E-Wallet</span>
                                </label>

                                <label class="relative flex flex-col items-center justify-center p-3.5 rounded-xl border border-slate-700 bg-slate-950/60 cursor-pointer hover:border-primary-500/60 transition has-[:checked]:border-primary-500 has-[:checked]:bg-primary-500/10 group text-center">
                                    <input type="radio" name="payment_method" value="maya" class="sr-only" {{ old('payment_method') == 'maya' ? 'checked' : '' }}>
                                    <span class="text-sm font-bold text-white group-has-[:checked]:text-primary-400">Maya</span>
                                    <span class="text-[11px] text-slate-400">E-Wallet</span>
                                </label>

                                <label class="relative flex flex-col items-center justify-center p-3.5 rounded-xl border border-slate-700 bg-slate-950/60 cursor-pointer hover:border-primary-500/60 transition has-[:checked]:border-primary-500 has-[:checked]:bg-primary-500/10 group text-center">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="sr-only" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                    <span class="text-sm font-bold text-white group-has-[:checked]:text-primary-400">Bank Transfer</span>
                                    <span class="text-[11px] text-slate-400">BDO / BPI</span>
                                </label>

                                <label class="relative flex flex-col items-center justify-center p-3.5 rounded-xl border border-slate-700 bg-slate-950/60 cursor-pointer hover:border-primary-500/60 transition has-[:checked]:border-primary-500 has-[:checked]:bg-primary-500/10 group text-center">
                                    <input type="radio" name="payment_method" value="card" class="sr-only" {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                                    <span class="text-sm font-bold text-white group-has-[:checked]:text-primary-400">Credit / Debit</span>
                                    <span class="text-[11px] text-slate-400">Visa / Mastercard</span>
                                </label>

                                <label class="relative flex flex-col items-center justify-center p-3.5 rounded-xl border border-slate-700 bg-slate-950/60 cursor-pointer hover:border-primary-500/60 transition has-[:checked]:border-primary-500 has-[:checked]:bg-primary-500/10 group text-center">
                                    <input type="radio" name="payment_method" value="cash" class="sr-only" {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                                    <span class="text-sm font-bold text-white group-has-[:checked]:text-primary-400">Cash on Arrival</span>
                                    <span class="text-[11px] text-slate-400">Pay at Desk</span>
                                </label>
                            </div>
                            @error('payment_method') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <!-- Promo Code Input -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Promo Code (Optional)
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="text" id="promo_code" name="promo_code" value="{{ old('promo_code', session('booking.step1.promo_code')) }}"
                                    placeholder="Enter promo code (e.g. WELCOME10)"
                                    class="flex-1 uppercase rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-slate-100 placeholder:text-slate-500 transition focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30">
                                <button type="button" id="btn-apply-promo"
                                    class="px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-sm font-bold text-white transition flex items-center gap-1.5 cursor-pointer">
                                    Apply
                                </button>
                            </div>
                            <div id="promo-message" class="mt-2 text-xs font-semibold hidden"></div>
                        </div>

                        <button type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4 font-bold text-white transition hover:from-primary-600 hover:to-primary-700 hover:shadow-lg hover:scale-[1.02] flex items-center justify-center gap-2">
                            Continue to Payment Proof
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Booking Summary Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 rounded-2xl border border-white/10 bg-slate-900/50 p-6 shadow-xl">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Booking Total
                    </h3>

                    <div class="rounded-xl border border-indigo-500/20 bg-indigo-500/10 p-5 mb-6">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Amount</p>
                        <div id="original-price-row" class="hidden mb-1 flex items-center justify-between text-xs text-slate-400">
                            <span>Subtotal:</span>
                            <span id="summary-original" class="line-through">₱0.00</span>
                        </div>
                        <div id="discount-price-row" class="hidden mb-2 flex items-center justify-between text-xs text-emerald-400 font-bold">
                            <span id="discount-label">Discount:</span>
                            <span id="summary-discount">-₱0.00</span>
                        </div>
                        <p id="summary-total" class="font-extrabold text-3xl text-emerald-400">₱0.00</p>
                        <p id="summary-nights" class="text-xs text-slate-400 mt-2">0 night(s) selected</p>
                    </div>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex items-start gap-3 text-sm">
                            <svg class="w-5 h-5 text-slate-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-slate-400">Check-in: 2:00 PM</p>
                                <p class="text-slate-400">Check-out: 12:00 PM</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 text-sm">
                            <svg class="w-5 h-5 text-slate-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-slate-400">Free cancellation up to 24 hours before check-in</p>
                        </div>
                        
                        <div class="flex items-start gap-3 text-sm">
                            <svg class="w-5 h-5 text-slate-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-slate-400">Instant confirmation via email</p>
                        </div>
                    </div>

                    <div class="border-t border-white/10 pt-4">
                        <p class="text-xs text-slate-500 leading-relaxed">
                            By continuing, you agree to our terms and conditions. All prices are in Philippine Peso (₱).
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-calendar { background:#0f172a; border:1px solid rgba(255,255,255,0.1); box-shadow:none; }
        .flatpickr-day { color:#e2e8f0; }
        .flatpickr-day.flatpickr-disabled { color:#475569; text-decoration:line-through; cursor:not-allowed; }
        .flatpickr-day.selected, .flatpickr-day.selected:hover { background:#6366f1; border-color:#6366f1; }
        .flatpickr-day:hover { background:rgba(99,102,241,0.2); }
        .flatpickr-months, .flatpickr-weekdays { background:#1e293b; }
        .flatpickr-current-month, .flatpickr-weekday { color:#e2e8f0 !important; }
        .flatpickr-day.today { border-color:#6366f1; }

        /* Pending Booking (Yellow / Amber) */
        .flatpickr-day.is-pending-booking {
            background: rgba(245, 158, 11, 0.3) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(245, 158, 11, 0.6) !important;
            font-weight: 700;
            position: relative;
        }
        .flatpickr-day.is-pending-booking::after {
            content: '';
            position: absolute;
            bottom: 3px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #fbbf24;
        }

        /* Confirmed Booking (Red) */
        .flatpickr-day.is-confirmed-booking {
            background: rgba(239, 68, 68, 0.25) !important;
            color: #f87171 !important;
            border: 1px solid rgba(239, 68, 68, 0.5) !important;
            text-decoration: line-through;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let checkInPicker, checkOutPicker;
        let activeBookedRanges = [];
        const roomSelect = document.getElementById('room_id');
        const roomsCountInput = document.querySelector('input[name="rooms_count"]');
        const summaryNights = document.getElementById('summary-nights');
        const summaryTotal = document.getElementById('summary-total');

        const formatYmd = (date) => {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        };

        const applyDayStatusStyle = (dObj, dayElem) => {
            if (!activeBookedRanges || activeBookedRanges.length === 0) return;
            const dateStr = formatYmd(dObj);
            const matched = activeBookedRanges.find(r => dateStr >= r.from && dateStr <= r.to);

            if (matched) {
                if (matched.status === 'pending') {
                    dayElem.classList.add('is-pending-booking');
                    dayElem.setAttribute('title', 'Pending Booking (Awaiting Confirmation)');
                } else {
                    dayElem.classList.add('is-confirmed-booking');
                    dayElem.setAttribute('title', 'Confirmed Booking');
                }
            }
        };

        const promoInput = document.getElementById('promo_code');
        const applyPromoBtn = document.getElementById('btn-apply-promo');
        const promoMsg = document.getElementById('promo-message');
        const origPriceRow = document.getElementById('original-price-row');
        const discPriceRow = document.getElementById('discount-price-row');
        const summaryOriginal = document.getElementById('summary-original');
        const summaryDiscount = document.getElementById('summary-discount');

        let currentDiscount = 0;

        const calculatePrice = () => {
            const selectedOption = roomSelect ? roomSelect.options[roomSelect.selectedIndex] : null;
            const pricePerNight = selectedOption ? parseFloat(selectedOption.getAttribute('data-price') || 0) : 0;
            const roomsCount = parseInt(roomsCountInput ? roomsCountInput.value : 1, 10) || 1;

            let nights = 0;
            const checkInVal = document.getElementById('check_in') ? document.getElementById('check_in').value : '';
            const checkOutVal = document.getElementById('check_out') ? document.getElementById('check_out').value : '';

            if (checkInVal && checkOutVal) {
                const date1 = new Date(checkInVal);
                const date2 = new Date(checkOutVal);
                const diffTime = date2.getTime() - date1.getTime();
                nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            }
            if (nights < 1) nights = 1;

            const subtotal = pricePerNight * nights * roomsCount;
            const finalTotal = Math.max(0, subtotal - currentDiscount);

            if (summaryNights) {
                summaryNights.textContent = `${nights} night(s) · ${roomsCount} room(s)`;
            }

            if (currentDiscount > 0) {
                if (origPriceRow) origPriceRow.classList.remove('hidden');
                if (discPriceRow) discPriceRow.classList.remove('hidden');
                if (summaryOriginal) summaryOriginal.textContent = '₱' + subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                if (summaryDiscount) summaryDiscount.textContent = '-₱' + currentDiscount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            } else {
                if (origPriceRow) origPriceRow.classList.add('hidden');
                if (discPriceRow) discPriceRow.classList.add('hidden');
            }

            if (summaryTotal) {
                summaryTotal.textContent = '₱' + finalTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        };

        const handleApplyPromo = () => {
            const code = promoInput ? promoInput.value.trim() : '';
            if (!code) {
                currentDiscount = 0;
                if (promoMsg) {
                    promoMsg.className = 'mt-2 text-xs font-semibold text-slate-400';
                    promoMsg.textContent = 'Please enter a promo code.';
                    promoMsg.classList.remove('hidden');
                }
                calculatePrice();
                return;
            }

            const selectedOption = roomSelect ? roomSelect.options[roomSelect.selectedIndex] : null;
            const pricePerNight = selectedOption ? parseFloat(selectedOption.getAttribute('data-price') || 0) : 0;
            const roomsCount = parseInt(roomsCountInput ? roomsCountInput.value : 1, 10) || 1;

            let nights = 0;
            const checkInVal = document.getElementById('check_in') ? document.getElementById('check_in').value : '';
            const checkOutVal = document.getElementById('check_out') ? document.getElementById('check_out').value : '';

            if (checkInVal && checkOutVal) {
                const date1 = new Date(checkInVal);
                const date2 = new Date(checkOutVal);
                const diffTime = date2.getTime() - date1.getTime();
                nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            }
            if (nights < 1) nights = 1;
            const subtotal = pricePerNight * nights * roomsCount;

            fetch('{{ route("booking.apply-promo") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ promo_code: code, amount: subtotal })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    currentDiscount = data.discount_amount;
                    if (promoMsg) {
                        promoMsg.className = 'mt-2 text-xs font-semibold text-emerald-400';
                        promoMsg.textContent = `✓ ${data.message} (${data.type === 'percentage' ? data.value + '%' : '₱' + data.value} off)`;
                        promoMsg.classList.remove('hidden');
                    }
                } else {
                    currentDiscount = 0;
                    if (promoMsg) {
                        promoMsg.className = 'mt-2 text-xs font-semibold text-red-400';
                        promoMsg.textContent = `✕ ${data.message || 'Invalid promo code'}`;
                        promoMsg.classList.remove('hidden');
                    }
                }
                calculatePrice();
            })
            .catch(() => {
                currentDiscount = 0;
                if (promoMsg) {
                    promoMsg.className = 'mt-2 text-xs font-semibold text-red-400';
                    promoMsg.textContent = '✕ Error validating promo code.';
                    promoMsg.classList.remove('hidden');
                }
                calculatePrice();
            });
        };

        if (applyPromoBtn) {
            applyPromoBtn.addEventListener('click', handleApplyPromo);
        }

        if (promoInput && promoInput.value.trim()) {
            handleApplyPromo();
        }

        checkInPicker = flatpickr("#check_in", {
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function (selectedDates, dateStr) {
                checkOutPicker.set('minDate', dateStr);
                calculatePrice();
            },
            onDayCreate: function (dObj, dStr, fp, dayElem) {
                applyDayStatusStyle(dObj, dayElem);
            }
        });

        checkOutPicker = flatpickr("#check_out", {
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function () {
                calculatePrice();
            },
            onDayCreate: function (dObj, dStr, fp, dayElem) {
                applyDayStatusStyle(dObj, dayElem);
            }
        });

        function loadBookedDates(roomId) {
            if (!roomId) {
                activeBookedRanges = [];
                checkInPicker.set('disable', []);
                checkOutPicker.set('disable', []);
                checkInPicker.redraw();
                checkOutPicker.redraw();
                return;
            }
            fetch(`{{ url('/booking/room-bookings') }}/${roomId}`)
                .then(res => res.json())
                .then(ranges => {
                    activeBookedRanges = Array.isArray(ranges) ? ranges : [];
                    const disableFn = function (date) {
                        if (!activeBookedRanges.length) return false;
                        const dateStr = formatYmd(date);
                        return activeBookedRanges.some(range => dateStr >= range.from && dateStr <= range.to);
                    };

                    checkInPicker.set('disable', [disableFn]);
                    checkOutPicker.set('disable', [disableFn]);
                    checkInPicker.redraw();
                    checkOutPicker.redraw();
                })
                .catch(err => {
                    activeBookedRanges = [];
                    checkInPicker.set('disable', []);
                    checkOutPicker.set('disable', []);
                    checkInPicker.redraw();
                    checkOutPicker.redraw();
                });
        }

        roomSelect.addEventListener('change', function () {
            loadBookedDates(this.value);
            calculatePrice();
        });

        if (roomsCountInput) {
            roomsCountInput.addEventListener('input', calculatePrice);
            roomsCountInput.addEventListener('change', calculatePrice);
        }

        if (roomSelect.value) {
            loadBookedDates(roomSelect.value);
        }

        calculatePrice();
    });
    </script>
    @endpush
</x-app-layout>