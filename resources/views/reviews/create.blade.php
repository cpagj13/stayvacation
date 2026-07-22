<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 transition mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Profile
                </a>
                <h1 class="text-4xl font-bold text-white mb-2">Write a Review</h1>
                <p class="text-slate-400">Share your experience with {{ $booking->room->name }}</p>
            </div>

            <!-- Booking Info Card -->
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6 mb-8">
                <div class="flex items-start gap-4">
                    @if($booking->room->image)
                        <img src="{{ asset('storage/' . $booking->room->image) }}" 
                             alt="{{ $booking->room->name }}"
                             class="w-24 h-24 rounded-lg object-cover">
                    @endif
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-white mb-2">{{ $booking->room->name }}</h3>
                        <div class="space-y-1 text-sm text-slate-400">
                            <p>
                                <span class="font-medium">Booking ID:</span> #{{ $booking->id }}
                            </p>
                            <p>
                                <span class="font-medium">Check-in:</span> {{ $booking->check_in->format('M d, Y') }}
                            </p>
                            <p>
                                <span class="font-medium">Check-out:</span> {{ $booking->check_out->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <form method="POST" action="{{ route('reviews.store') }}" class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-8">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-300 mb-3">
                        Rating <span class="text-red-500">*</span>
                    </label>
                    <div x-data="{ rating: 0, hover: 0 }" class="flex gap-2">
                        <template x-for="star in 5" :key="star">
                            <button 
                                type="button"
                                @click="rating = star"
                                @mouseenter="hover = star"
                                @mouseleave="hover = 0"
                                class="focus:outline-none transition-transform hover:scale-110">
                                <svg 
                                    :class="star <= (hover || rating) ? 'text-yellow-400 fill-current' : 'text-slate-600'"
                                    class="w-10 h-10" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </button>
                        </template>
                        <input type="hidden" name="rating" x-model="rating" required>
                    </div>
                    <p x-show="rating > 0" x-text="`${rating} star${rating > 1 ? 's' : ''}`" class="text-sm text-slate-400 mt-2"></p>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-slate-300 mb-2">
                        Your Review <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 mb-3">
                        Share your experience with this room. What did you like? What could be improved?
                    </p>
                    <textarea 
                        id="comment"
                        name="comment" 
                        rows="6"
                        required
                        minlength="10"
                        maxlength="1000"
                        placeholder="Write your review here... (minimum 10 characters)"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                    >{{ old('comment') }}</textarea>
                    <div class="flex justify-between mt-2">
                        @error('comment')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-500 ml-auto" x-data="{ count: 0 }">
                            <span x-text="count"></span> / 1000 characters
                            <script>
                                document.getElementById('comment').addEventListener('input', function(e) {
                                    document.querySelector('[x-data]').setAttribute('x-data', `{ count: ${e.target.value.length} }`);
                                });
                            </script>
                        </p>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-indigo-500/10 border border-indigo-500/30 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-indigo-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm text-indigo-300">
                            <p class="font-medium mb-1">Review Guidelines</p>
                            <ul class="space-y-1 text-xs text-indigo-200/80">
                                <li>• Your review will be visible after admin approval</li>
                                <li>• Be honest and constructive</li>
                                <li>• Focus on your experience with the room and service</li>
                                <li>• Avoid offensive language or personal attacks</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <button 
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40">
                        Submit Review
                    </button>
                    <a 
                        href="{{ route('profile.edit') }}"
                        class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-semibold rounded-lg transition-all duration-200">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
