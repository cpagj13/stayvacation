<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Refund Policy</h1>
                <p class="text-slate-400">Last updated: {{ date('F d, Y') }}</p>
            </div>

            <div class="bg-slate-900/50 border border-white/10 rounded-xl p-8 lg:p-12 shadow-xl">
                
                <h2 class="text-2xl font-bold text-white mb-4">1. Eligibility for Refunds</h2>
                <p class="text-slate-300 mb-4">
                    You may be eligible for a refund in the following circumstances:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li>Cancellation made according to our <a href="{{ route('cancellation') }}" class="text-indigo-400 underline hover:text-indigo-300">Cancellation Policy</a></li>
                    <li>Hotel-initiated cancellation or overbooking</li>
                    <li>Significant service failures or misrepresentation</li>
                    <li>Technical errors resulting in incorrect charges</li>
                </ul>

                <h2 class="text-2xl font-bold text-white mb-4">2. Refund Amounts</h2>
                <div class="bg-slate-800/50 rounded-lg p-6 mb-6">
                    <table class="w-full text-slate-300">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left pb-3 text-white">Cancellation Timing</th>
                                <th class="text-right pb-3 text-white">Refund Amount</th>
                            </tr>
                        </thead>
                        <tbody class="space-y-2">
                            <tr class="border-b border-white/5">
                                <td class="py-3">24+ hours before check-in</td>
                                <td class="text-right py-3 text-emerald-400 font-semibold">100% Refund</td>
                            </tr>
                            <tr class="border-b border-white/5">
                                <td class="py-3">Less than 24 hours before check-in</td>
                                <td class="text-right py-3 text-amber-400 font-semibold">50% Refund</td>
                            </tr>
                            <tr>
                                <td class="py-3">No-show</td>
                                <td class="text-right py-3 text-red-400 font-semibold">No Refund</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2 class="text-2xl font-bold text-white mb-4">3. Refund Process</h2>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">Step 1:</strong> Cancel your booking through your account or contact customer service
                </p>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">Step 2:</strong> Receive cancellation confirmation email with refund details
                </p>
                <p class="text-slate-300 mb-4">
                    <strong class="text-white">Step 3:</strong> Refund processed within 7-14 business days
                </p>
                <p class="text-slate-300 mb-6">
                    <strong class="text-white">Step 4:</strong> Funds credited to your original payment method
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">4. Refund Methods</h2>
                <p class="text-slate-300 mb-4">
                    Refunds will be issued to your original payment method:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li><strong class="text-white">Credit/Debit Card:</strong> 7-14 business days</li>
                    <li><strong class="text-white">GCash:</strong> 3-5 business days</li>
                    <li><strong class="text-white">PayMaya:</strong> 3-5 business days</li>
                    <li><strong class="text-white">Bank Transfer:</strong> 5-10 business days</li>
                </ul>

                <h2 class="text-2xl font-bold text-white mb-4">5. Non-Refundable Items</h2>
                <p class="text-slate-300 mb-4">
                    The following are non-refundable:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li>Booking fees and service charges</li>
                    <li>Third-party charges (tourism tax, local fees)</li>
                    <li>Additional services already rendered (spa, meals, etc.)</li>
                    <li>Non-refundable rate bookings (as specified at time of booking)</li>
                </ul>

                <h2 class="text-2xl font-bold text-white mb-4">6. Partial Stays</h2>
                <p class="text-slate-300 mb-6">
                    If you check out early, no refund will be provided for unused nights unless approved by management due to special circumstances.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">7. Disputes and Chargebacks</h2>
                <p class="text-slate-300 mb-6">
                    If you have a dispute, please contact us first at disputes@stayvacation.com before initiating a chargeback. Chargebacks may result in account suspension and additional fees.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">8. Contact for Refund Inquiries</h2>
                <p class="text-slate-300 mb-4">
                    For questions about refunds:
                </p>
                <ul class="list-none text-slate-300 space-y-2 mb-8">
                    <li><strong class="text-white">Email:</strong> refunds@stayvacation.com</li>
                    <li><strong class="text-white">Phone:</strong> +63 (2) 1234 5678</li>
                    <li><strong class="text-white">Hours:</strong> Mon-Fri, 8:00 AM - 10:00 PM</li>
                </ul>

                <div class="bg-indigo-500/10 border border-indigo-500/20 rounded-lg p-6 mt-8">
                    <p class="text-indigo-300 text-sm">
                        <strong>Note:</strong> Refund processing times may vary depending on your bank or payment provider. StayVacation processes refunds promptly but cannot control bank processing times.
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
