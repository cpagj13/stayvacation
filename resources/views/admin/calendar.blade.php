<x-admin-layout>
    <div x-data="{
        selectedBookings: [],
        selectedDate: null,
        showModal: false,
        showCancelModal: false,
        showDeleteModal: false,
        bookingToCancel: null,
        bookingToDelete: null,
        
        init() {
            // Listen for the custom event from the calendar
            window.addEventListener('open-booking-modal', (event) => {
                console.log('Event received:', event.detail); // Debug log
                this.selectedBookings = event.detail.bookings;
                this.selectedDate = event.detail.dateStr;
                this.showModal = true;
            });
        },
        
        openModal(dateStr) {
            const matches = bookingEvents.filter(e => dateStr >= e.from && dateStr <= e.to);
            if (matches.length) {
                this.selectedBookings = matches;
                this.selectedDate = dateStr;
                this.showModal = true;
            }
        },
        
        confirmCancel(bookingId) {
            this.bookingToCancel = bookingId;
            this.showCancelModal = true;
        },
        
        confirmDelete(bookingId) {
            this.bookingToDelete = bookingId;
            this.showDeleteModal = true;
        }
    }" class="px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Booking Calendar</h1>
                    <p class="text-slate-400">Click on any booked date to view and manage booking details</p>
                </div>
                <div class="hidden sm:flex items-center gap-3">
                    <div class="px-4 py-2 bg-slate-900/50 border border-white/10 rounded-lg">
                        <p class="text-xs text-slate-400">Total Bookings</p>
                        <p class="text-lg font-bold text-white">{{ count($events) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calendar Container --}}
        <div class="bg-slate-900/50 border border-white/10 rounded-xl p-8 shadow-xl">
            <div id="admin-calendar" class="max-w-full"></div>

            <div class="flex items-center gap-6 mt-8 pt-6 border-t border-white/10">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gradient-to-br from-amber-400 to-amber-600"></span>
                    <span class="text-sm text-slate-400">Booked Date</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600"></span>
                    <span class="text-sm text-slate-400">Confirmed</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gradient-to-br from-blue-400 to-blue-600"></span>
                    <span class="text-sm text-slate-400">Pending</span>
                </div>
            </div>
        </div>

        {{-- Booking Details Modal --}}
        <div x-show="showModal" 
             x-cloak
             @click.away="showModal = false"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="bg-slate-900 border border-white/10 rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden"
                 @click.stop
                 x-transition:enter="transition ease-out duration-200 delay-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                
                {{-- Modal Header --}}
                <div class="px-6 py-5 border-b border-white/10 bg-gradient-to-r from-slate-900/80 to-slate-900/40">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span x-text="selectedDate ? new Date(selectedDate).toLocaleDateString('en-US', {month: 'long', day: 'numeric', year: 'numeric'}) : ''"></span>
                            </h2>
                            <p class="text-sm text-slate-400 mt-1">
                                <span x-text="selectedBookings.length"></span> booking<span x-show="selectedBookings.length !== 1">s</span> on this date
                            </p>
                        </div>
                        <button @click="showModal = false" class="text-slate-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="overflow-y-auto max-h-[calc(90vh-140px)]">
                    <div class="p-6 space-y-4">
                        <template x-for="booking in selectedBookings" :key="booking.id">
                            <div class="bg-slate-800/50 border border-white/10 rounded-xl p-6 hover:border-white/20 transition-all">
                                {{-- Guest Info --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-lg" x-text="booking.guest.substring(0, 1).toUpperCase()"></span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-white text-lg" x-text="booking.guest"></p>
                                            <p class="text-sm text-slate-400" x-text="booking.email"></p>
                                        </div>
                                    </div>
                                    <div>
                                        <span x-show="booking.status === 'pending'" 
                                              class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border bg-blue-500/10 text-blue-400 border-blue-500/20">
                                            <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Pending
                                        </span>
                                        <span x-show="booking.status === 'confirmed'" 
                                              class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border bg-emerald-500/10 text-emerald-400 border-emerald-500/20">
                                            <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Confirmed
                                        </span>
                                    </div>
                                </div>

                                {{-- Room & Stay Details --}}
                                <div class="grid grid-cols-2 gap-4 mb-4 pb-4 border-b border-white/10">
                                    <div>
                                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Room</p>
                                        <p class="text-white font-medium" x-text="booking.room"></p>
                                        <p class="text-xs text-slate-400" x-text="booking.category"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Stay Period</p>
                                        <p class="text-white text-sm" x-text="booking.fromFormatted + ' - ' + booking.toFormatted"></p>
                                        <p class="text-xs text-slate-400"><span x-text="booking.nights"></span> night<span x-show="booking.nights !== 1">s</span></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Guests & Rooms</p>
                                        <p class="text-white text-sm"><span x-text="booking.guests"></span> guests • <span x-text="booking.rooms_count"></span> room<span x-show="booking.rooms_count !== 1">s</span></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Total Price</p>
                                        <p class="text-white font-bold text-lg">₱<span x-text="booking.total"></span></p>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <a x-show="booking.proof" 
                                           :href="booking.proof"
                                           target="_blank"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Proof
                                        </a>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a :href="'/admin/bookings/' + booking.id + '/edit'"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 hover:border-indigo-500/40 text-sm font-medium rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <button @click="confirmCancel(booking.id)"
                                                x-show="booking.status !== 'cancelled'"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/20 hover:border-amber-500/40 text-sm font-medium rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel
                                        </button>
                                        <button @click="confirmDelete(booking.id)"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 hover:border-red-500/40 text-sm font-medium rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cancel Confirmation Modal --}}
        <div x-show="showCancelModal"
             x-cloak
             class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
             x-transition>
            <div class="bg-slate-900 border border-amber-500/20 rounded-xl shadow-2xl max-w-md w-full p-6"
                 @click.stop>
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Cancel Booking?</h3>
                    <p class="text-slate-400">This will mark the booking as cancelled. The guest will be notified.</p>
                </div>
                <div class="flex gap-3">
                    <button @click="showCancelModal = false"
                            class="flex-1 px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg transition">
                        No, Keep It
                    </button>
                    <form :action="'/admin/bookings/' + bookingToCancel + '/cancel'" method="POST" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="w-full px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                            Yes, Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Delete Confirmation Modal --}}
        <div x-show="showDeleteModal"
             x-cloak
             class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
             x-transition>
            <div class="bg-slate-900 border border-red-500/20 rounded-xl shadow-2xl max-w-md w-full p-6"
                 @click.stop>
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Delete Booking?</h3>
                    <p class="text-slate-400">This action cannot be undone. The booking will be permanently removed from the system.</p>
                </div>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false"
                            class="flex-1 px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg transition">
                        Cancel
                    </button>
                    <form :action="'/admin/bookings/' + bookingToDelete" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition">
                            Delete Forever
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        [x-cloak] { display: none !important; }
        
        /* Calendar Container */
        .flatpickr-calendar { 
            background: rgba(15, 23, 42, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: none !important;
            width: 100% !important;
            max-width: none !important;
            border-radius: 12px !important;
        }
        
        /* Header */
        .flatpickr-months {
            background: transparent !important;
            padding: 16px 20px !important;
        }
        
        .flatpickr-month {
            height: auto !important;
        }
        
        .flatpickr-current-month {
            padding: 0 !important;
            height: auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 18px !important;
            font-weight: 600 !important;
        }
        
        /* Weekdays Header */
        .flatpickr-weekdays { 
            background: transparent !important;
            padding: 12px 0 !important;
            display: flex !important;
            width: 100% !important;
        }
        
        .flatpickr-weekday {
            color: #F3EDE1 !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            flex: 1 !important;
            text-align: center !important;
        }
        
        /* Days Container - THIS IS KEY FOR ALIGNMENT */
        .flatpickr-days {
            width: 100% !important;
        }
        
        .dayContainer {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            display: grid !important;
            grid-template-columns: repeat(7, 1fr) !important;
            gap: 4px !important;
            padding: 0 !important;
        }
        
        /* Individual Day Cells */
        .flatpickr-day { 
            color: #F3EDE1 !important;
            border-radius: 8px !important;
            height: 48px !important;
            line-height: 48px !important;
            max-width: none !important;
            width: 100% !important;
            margin: 0 !important;
            border: 1px solid transparent !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 14px !important;
        }
        
        .flatpickr-day:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }
        
        .flatpickr-day.today {
            border-color: rgba(99, 102, 241, 0.5) !important;
            background: rgba(99, 102, 241, 0.1) !important;
        }
        
        /* Booked Days */
        .flatpickr-day.has-booking { 
            position: relative !important;
            font-weight: 600 !important;
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.15), rgba(245, 158, 11, 0.1)) !important;
            border: 1px solid rgba(251, 191, 36, 0.3) !important;
            color: #FCD34D !important;
            cursor: pointer !important;
        }
        
        .flatpickr-day.has-booking:hover {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.25), rgba(245, 158, 11, 0.15)) !important;
            border-color: rgba(251, 191, 36, 0.5) !important;
            transform: scale(1.05) !important;
        }
        
        .flatpickr-day.has-booking::after {
            content: '' !important;
            position: absolute !important;
            bottom: 6px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            width: 4px !important;
            height: 4px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, #FCD34D, #F59E0B) !important;
            box-shadow: 0 0 6px rgba(252, 211, 77, 0.5) !important;
        }
        
        .flatpickr-day.has-booking.confirmed {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.1)) !important;
            border-color: rgba(16, 185, 129, 0.3) !important;
            color: #6EE7B7 !important;
        }
        
        .flatpickr-day.has-booking.confirmed::after {
            background: linear-gradient(135deg, #6EE7B7, #10B981) !important;
            box-shadow: 0 0 6px rgba(110, 231, 183, 0.5) !important;
        }
        
        /* Other Days */
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: rgba(243, 237, 225, 0.3) !important;
        }
        
        /* Month/Year Dropdown */
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            background: rgba(15, 23, 42, 0.9) !important;
        }
        
        .flatpickr-current-month .flatpickr-monthDropdown-months .flatpickr-monthDropdown-month {
            background: transparent !important;
            color: #F3EDE1 !important;
        }
        
        .numInputWrapper {
            width: 80px !important;
        }
        
        .numInputWrapper input {
            color: #F3EDE1 !important;
        }
        
        /* Navigation Arrows */
        .flatpickr-prev-month,
        .flatpickr-next-month {
            fill: #F3EDE1 !important;
        }
        
        .flatpickr-prev-month:hover svg,
        .flatpickr-next-month:hover svg {
            fill: #6366F1 !important;
        }
        
        /* Make sure calendar takes full width */
        .flatpickr-innerContainer {
            width: 100% !important;
        }
        
        .flatpickr-rContainer {
            width: 100% !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const bookingEvents = @json($events);
        
        console.log('Booking events:', bookingEvents); // Debug log

        document.addEventListener('DOMContentLoaded', function () {
            // Get the Alpine component
            const calendarContainer = document.querySelector('[x-data]');
            
            flatpickr("#admin-calendar", {
                inline: true,
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    const y = dayElem.dateObj.getFullYear();
                    const m = String(dayElem.dateObj.getMonth() + 1).padStart(2, '0');
                    const d = String(dayElem.dateObj.getDate()).padStart(2, '0');
                    const dateStr = `${y}-${m}-${d}`;

                    const matches = bookingEvents.filter(e => dateStr >= e.from && dateStr <= e.to);
                    if (matches.length) {
                        dayElem.classList.add('has-booking');
                        
                        // Add status-specific class for the first booking
                        if (matches[0].status === 'confirmed') {
                            dayElem.classList.add('confirmed');
                        }
                        
                        // Add click handler
                        dayElem.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            console.log('Date clicked:', dateStr); // Debug log
                            console.log('Matches found:', matches); // Debug log
                            
                            // Dispatch a custom event that Alpine can listen to
                            window.dispatchEvent(new CustomEvent('open-booking-modal', {
                                detail: { dateStr: dateStr, bookings: matches }
                            }));
                        });
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>