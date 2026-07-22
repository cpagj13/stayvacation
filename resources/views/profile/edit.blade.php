<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">My Profile</h1>
                <p class="text-slate-400">Manage your account settings and booking history</p>
            </div>

            <!-- Success Messages -->
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Profile Information -->
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-8 shadow-xl">
                <h2 class="text-2xl font-bold text-white mb-6">Profile Information</h2>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-8 shadow-xl">
                <h2 class="text-2xl font-bold text-white mb-6">Update Password</h2>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Booking History -->
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-8 shadow-xl">
                <h2 class="text-2xl font-bold text-white mb-6">My Booking History</h2>
                
                @if($bookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 hover:border-indigo-500/50 transition">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <!-- Room Image -->
                                    @if($booking->room->image)
                                        <img src="{{ asset('storage/' . $booking->room->image) }}" 
                                             alt="{{ $booking->room->name }}"
                                             class="w-full md:w-32 h-32 rounded-lg object-cover">
                                    @endif

                                    <!-- Booking Details -->
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h3 class="text-xl font-semibold text-white mb-1">{{ $booking->room->name }}</h3>
                                                <p class="text-sm text-slate-400">Booking ID: #{{ $booking->id }}</p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                                @if($booking->status === 'confirmed') bg-green-500/10 border border-green-500/30 text-green-400
                                                @elseif($booking->status === 'pending') bg-yellow-500/10 border border-yellow-500/30 text-yellow-400
                                                @elseif($booking->status === 'cancelled') bg-red-500/10 border border-red-500/30 text-red-400
                                                @else bg-slate-500/10 border border-slate-500/30 text-slate-400
                                                @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                            <div>
                                                <p class="text-slate-500 mb-1">Check-in</p>
                                                <p class="text-white font-medium">{{ $booking->check_in->format('M d, Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-slate-500 mb-1">Check-out</p>
                                                <p class="text-white font-medium">{{ $booking->check_out->format('M d, Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-slate-500 mb-1">Guests</p>
                                                <p class="text-white font-medium">{{ $booking->guests }} {{ $booking->guests > 1 ? 'guests' : 'guest' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-slate-500 mb-1">Total</p>
                                                <p class="text-white font-medium">₱{{ number_format($booking->total_price, 2) }}</p>
                                            </div>
                                        </div>

                                        <!-- Review Button -->
                                        @if(($booking->status === 'confirmed' || $booking->status === 'completed') && !$booking->hasReview())
                                            <div class="mt-4">
                                                <a href="{{ route('reviews.create', $booking->id) }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-lg transition">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                    </svg>
                                                    Write a Review
                                                </a>
                                            </div>
                                        @elseif($booking->hasReview())
                                            <div class="mt-4 flex items-center text-green-400">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="font-medium">Review Submitted ({{ $booking->review->status }})</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($bookings->hasPages())
                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-slate-400 mb-2">No Bookings Yet</h3>
                        <p class="text-slate-500 mb-6">Start your journey by booking a room!</p>
                        <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg transition">
                            Browse Rooms
                        </a>
                    </div>
                @endif
            </div>

            <!-- Delete Account -->
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-8 shadow-xl">
                <h2 class="text-2xl font-bold text-white mb-6">Delete Account</h2>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
