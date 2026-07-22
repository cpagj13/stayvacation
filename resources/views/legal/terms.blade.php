<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Terms of Service</h1>
                <p class="text-slate-400">Last updated: {{ date('F d, Y') }}</p>
            </div>

            {{-- Content --}}
            <div class="bg-slate-900/50 border border-white/10 rounded-xl p-8 lg:p-12 shadow-xl prose prose-invert prose-slate max-w-none">
                
                <h2 class="text-2xl font-bold text-white mb-4">1. Agreement to Terms</h2>
                <p class="text-slate-300 mb-6">
                    By accessing and using StayVacation's website and services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">2. Booking and Reservations</h2>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">2.1 Booking Process:</strong> All bookings must be made through our website or authorized channels. A booking is confirmed only when you receive a confirmation email from us.
                </p>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">2.2 Payment:</strong> Full payment or deposit (as specified) must be received before your booking is confirmed. We accept various payment methods including credit cards, GCash, and PayMaya.
                </p>
                <p class="text-slate-300 mb-6">
                    <strong class="text-white">2.3 Pricing:</strong> All prices are listed in Philippine Pesos (₱) and are subject to change without notice. The price applicable to your booking is the price displayed at the time of reservation.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">3. Check-in and Check-out</h2>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">3.1 Check-in Time:</strong> Standard check-in time is 2:00 PM. Early check-in is subject to availability and may incur additional charges.
                </p>
                <p class="text-slate-300 mb-6">
                    <strong class="text-white">3.2 Check-out Time:</strong> Standard check-out time is 12:00 PM noon. Late check-out is subject to availability and may incur additional charges.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">4. Cancellation Policy</h2>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">4.1 Free Cancellation:</strong> Bookings can be cancelled free of charge up to 24 hours before the check-in date.
                </p>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">4.2 Late Cancellation:</strong> Cancellations made less than 24 hours before check-in will forfeit 50% of the booking amount.
                </p>
                <p class="text-slate-300 mb-6">
                    <strong class="text-white">4.3 No-Show:</strong> Failure to check-in without prior cancellation will result in forfeiture of the full booking amount.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">5. Guest Responsibilities</h2>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">5.1 Behavior:</strong> Guests must respect other guests and hotel property. We reserve the right to refuse service or evict guests who engage in disruptive or illegal behavior.
                </p>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">5.2 Damages:</strong> Guests are responsible for any damage to hotel property caused during their stay. Repair or replacement costs will be charged to the guest.
                </p>
                <p class="text-slate-300 mb-6">
                    <strong class="text-white">5.3 Identification:</strong> Valid government-issued ID is required at check-in for all guests.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">6. Hotel Responsibilities</h2>
                <p class="text-slate-300 mb-4">
                    We strive to provide the best service possible. However, we are not liable for:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li>Personal belongings lost or damaged during your stay</li>
                    <li>Service interruptions due to circumstances beyond our control</li>
                    <li>Third-party services or events</li>
                    <li>Changes in room availability due to unforeseen circumstances</li>
                </ul>

                <h2 class="text-2xl font-bold text-white mb-4">7. Privacy and Data Protection</h2>
                <p class="text-slate-300 mb-6">
                    We collect and process personal information in accordance with our <a href="{{ route('privacy') }}" class="text-indigo-400 hover:text-indigo-300 underline">Privacy Policy</a>. By using our services, you consent to such processing and warrant that all data provided is accurate.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">8. Intellectual Property</h2>
                <p class="text-slate-300 mb-6">
                    All content on this website, including text, graphics, logos, images, and software, is the property of StayVacation and protected by intellectual property laws. Unauthorized use is prohibited.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">9. Modifications to Terms</h2>
                <p class="text-slate-300 mb-6">
                    We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting to the website. Your continued use of our services constitutes acceptance of the modified terms.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">10. Contact Information</h2>
                <p class="text-slate-300 mb-4">
                    If you have any questions about these Terms of Service, please contact us:
                </p>
                <ul class="list-none text-slate-300 space-y-2 mb-8">
                    <li><strong class="text-white">Email:</strong> legal@stayvacation.com</li>
                    <li><strong class="text-white">Phone:</strong> +63 (2) 1234 5678</li>
                    <li><strong class="text-white">Address:</strong> 123 Hotel Street, Manila, Philippines 1000</li>
                </ul>

                <div class="bg-indigo-500/10 border border-indigo-500/20 rounded-lg p-6 mt-8">
                    <p class="text-indigo-300 text-sm">
                        <strong>Note:</strong> These terms and conditions form a legally binding agreement between you and StayVacation. Please read them carefully before making a booking.
                    </p>
                </div>
            </div>

            {{-- Back Button --}}
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
