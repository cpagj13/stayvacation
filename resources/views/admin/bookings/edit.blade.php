<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.calendar') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Calendar
                </a>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Edit Booking</h1>
            <p class="text-slate-400">Update booking details for {{ $booking->guest_name }}</p>
        </div>

        {{-- Edit Form --}}
        <div class="max-w-3xl">
            <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="bg-slate-900/50 border border-white/10 rounded-xl p-8 shadow-xl">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    {{-- Booking Info --}}
                    <div class="pb-6 border-b border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-1">Booking Information</h3>
                        <p class="text-sm text-slate-400">Booking ID: #{{ $booking->id }}</p>
                    </div>

                    {{-- Guest Name --}}
                    <div>
                        <label for="guest_name" class="block text-sm font-medium text-white mb-2">Guest Name</label>
                        <input type="text" 
                               name="guest_name" 
                               id="guest_name" 
                               value="{{ old('guest_name', $booking->guest_name) }}"
                               required
                               class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        @error('guest_name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Room Selection --}}
                    <div>
                        <label for="room_id" class="block text-sm font-medium text-white mb-2">Room</label>
                        <select name="room_id" 
                                id="room_id" 
                                required
                                class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" 
                                        data-price="{{ $room->price }}"
                                        {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} - {{ $room->category->name ?? 'Standard' }} (₱{{ number_format($room->price, 2) }}/night)
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Check-in & Check-out --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="check_in" class="block text-sm font-medium text-white mb-2">Check-in Date</label>
                            <input type="date" 
                                   name="check_in" 
                                   id="check_in" 
                                   value="{{ old('check_in', $booking->check_in->format('Y-m-d')) }}"
                                   required
                                   class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('check_in')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="check_out" class="block text-sm font-medium text-white mb-2">Check-out Date</label>
                            <input type="date" 
                                   name="check_out" 
                                   id="check_out" 
                                   value="{{ old('check_out', $booking->check_out->format('Y-m-d')) }}"
                                   required
                                   class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('check_out')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Guests & Rooms Count --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="guests" class="block text-sm font-medium text-white mb-2">Number of Guests</label>
                            <input type="number" 
                                   name="guests" 
                                   id="guests" 
                                   min="1"
                                   value="{{ old('guests', $booking->guests) }}"
                                   required
                                   class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('guests')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="rooms_count" class="block text-sm font-medium text-white mb-2">Number of Rooms</label>
                            <input type="number" 
                                   name="rooms_count" 
                                   id="rooms_count" 
                                   min="1"
                                   value="{{ old('rooms_count', $booking->rooms_count) }}"
                                   required
                                   class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('rooms_count')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-white mb-2">Booking Status</label>
                        <select name="status" 
                                id="status" 
                                required
                                class="w-full px-4 py-3 bg-slate-800 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price Preview --}}
                    <div class="p-4 bg-indigo-500/10 border border-indigo-500/20 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-400">Current Total Price</p>
                                <p class="text-xs text-slate-500 mt-0.5">Price will be recalculated on save</p>
                            </div>
                            <p class="text-2xl font-bold text-white">₱{{ number_format($booking->total_price, 2) }}</p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-3 pt-6 border-t border-white/10">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg transition shadow-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Changes
                        </button>
                        <a href="{{ route('admin.calendar') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-lg transition">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
