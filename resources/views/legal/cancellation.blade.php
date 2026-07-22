<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Cancellation Policy</h1>
                <p class="text-slate-400">Last updated: {{ date('F d, Y') }}</p>
            </div>

            <div class="bg-slate-900/50 border border-white/10 rounded-xl p-8 lg:p-12 shadow-xl">
                
                <h2 class="text-2xl font-bold text-white mb-4">1. Free Cancellation</h2>
                <p class="text-slate-300 mb-6">
                    Bookings can be cancelled free of charge up to 24 hours before the scheduled check-in time. You will receive a full refund of the amount paid.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">2. Late Cancellation (Less than 24 Hours)</h2>
                <p class="text-slate-300 mb-6">
                    Cancellations made less than 24 hours before check-in will incur a 50% cancellation fee. The remaining 50% will be refunded to your original payment method.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">3. No-Show Policy</h2>
                <p class="text-slate-300 mb-6">
                    Failure to check-in without prior cancellation notification will result in a 100% charge of the total booking amount. No refund will be issued for no-shows.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">4. How to Cancel</h2>
                <p class="text-slate-300 mb-4">
                    To cancel your booking:
                </p>
                <ul class="list-decimal list-inside text-slate-300 mb-6 space-y-2">
                    <li>Log in to your account</li>
                    <li>Go to "Your Bookings"</li>
                    <li>Select the booking you wish to cancel</li>
                    <li>Click "Cancel Booking" and confirm</li>
                    <li>You will receive a cancellation confirmation email</li>
                </ul>

                <h2 class="text-2xl font-bold text-white mb-4">5. Modification of Bookings</h2>
                <p class="text-slate-300 mb-6">
                    Booking modifications (dates, room type, number of guests) are subject to availability. Please contact us at least 48 hours before check-in to request modifications.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">6. Special Circumstances</h2>
                <p class="text-slate-300 mb-6">
                    In cases of emergencies, natural disasters, or government travel restrictions, we may waive cancellation fees on a case-by-case basis. Please contact our customer service team for assistance.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">7. Refund Processing Time</h2>
                <p class="text-slate-300 mb-6">
                    Refunds will be processed within 7-14 business days from the date of cancellation. The exact time depends on your payment method and bank processing times.
                </p>

                <div class="bg-amber-500/10 border border-amber-500/20 rounded-lg p-6 mt-8">
                    <p class="text-amber-300 text-sm">
                        <strong>Important:</strong> Non-refundable rates and special promotional offers may have different cancellation policies. Please check your booking confirmation for specific terms.
                    </p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
