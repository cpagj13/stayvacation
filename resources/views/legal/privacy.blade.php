<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Privacy Policy</h1>
                <p class="text-slate-400">Last updated: {{ date('F d, Y') }}</p>
            </div>

            {{-- Content --}}
            <div class="bg-slate-900/50 border border-white/10 rounded-xl p-8 lg:p-12 shadow-xl prose prose-invert prose-slate max-w-none">
                
                <h2 class="text-2xl font-bold text-white mb-4">1. Introduction</h2>
                <p class="text-slate-300 mb-6">
                    StayVacation ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">2. Information We Collect</h2>
                
                <h3 class="text-xl font-semibold text-white mb-3">2.1 Personal Information</h3>
                <p class="text-slate-300 mb-4">
                    We may collect personal information that you provide to us, including:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li>Name and contact information (email, phone number, address)</li>
                    <li>Payment information (credit card details, billing address)</li>
                    <li>Government-issued ID for verification purposes</li>
                    <li>Booking preferences and history</li>
                    <li>Communication records with our customer service</li>
                </ul>

                <h3 class="text-xl font-semibold text-white mb-3">2.2 Automatically Collected Information</h3>
                <p class="text-slate-300 mb-4">
                    When you visit our website, we automatically collect certain information:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li>IP address and browser type</li>
                    <li>Device information and operating system</li>
                    <li>Pages visited and time spent on each page</li>
                    <li>Referral source and exit pages</li>
                    <li>Cookies and similar tracking technologies</li>
                </ul>

                <h2 class="text-2xl font-bold text-white mb-4">3. How We Use Your Information</h2>
                <p class="text-slate-300 mb-4">
                    We use the collected information for various purposes:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li>Process and manage your bookings and reservations</li>
                    <li>Send booking confirmations and updates</li>
                    <li>Provide customer support and respond to inquiries</li>
                    <li>Process payments and prevent fraud</li>
                    <li>Improve our website and services</li>
                    <li>Send promotional offers and marketing communications (with your consent)</li>
                    <li>Comply with legal obligations and enforce our terms</li>
                </ul>

                <h2 class="text-2xl font-bold text-white mb-4">4. Information Sharing and Disclosure</h2>
                <p class="text-slate-300 mb-4">
                    We do not sell your personal information. We may share your information with:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li><strong class="text-white">Service Providers:</strong> Third parties who perform services on our behalf (payment processors, email services)</li>
                    <li><strong class="text-white">Legal Requirements:</strong> When required by law or to protect our rights</li>
                    <li><strong class="text-white">Business Transfers:</strong> In connection with a merger, sale, or acquisition</li>
                    <li><strong class="text-white">With Your Consent:</strong> When you have given us explicit permission</li>
                </ul>

                <h2 class="text-2xl font-bold text-white mb-4">5. Data Security</h2>
                <p class="text-slate-300 mb-6">
                    We implement appropriate technical and organizational security measures to protect your personal information. However, no method of transmission over the Internet is 100% secure, and we cannot guarantee absolute security.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">6. Cookies and Tracking Technologies</h2>
                <p class="text-slate-300 mb-4">
                    We use cookies and similar tracking technologies to:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li>Remember your preferences and settings</li>
                    <li>Analyze website traffic and usage patterns</li>
                    <li>Provide personalized content and advertisements</li>
                    <li>Ensure website security and prevent fraud</li>
                </ul>
                <p class="text-slate-300 mb-6">
                    You can control cookies through your browser settings. However, disabling cookies may limit your ability to use certain features of our website.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">7. Your Privacy Rights</h2>
                <p class="text-slate-300 mb-4">
                    Depending on your location, you may have the following rights:
                </p>
                <ul class="list-disc list-inside text-slate-300 mb-6 space-y-2">
                    <li><strong class="text-white">Access:</strong> Request a copy of your personal information</li>
                    <li><strong class="text-white">Correction:</strong> Request correction of inaccurate information</li>
                    <li><strong class="text-white">Deletion:</strong> Request deletion of your personal information</li>
                    <li><strong class="text-white">Opt-out:</strong> Unsubscribe from marketing communications</li>
                    <li><strong class="text-white">Portability:</strong> Request transfer of your data</li>
                    <li><strong class="text-white">Object:</strong> Object to certain processing of your data</li>
                </ul>
                <p class="text-slate-300 mb-6">
                    To exercise these rights, please contact us at privacy@stayvacation.com.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">8. Data Retention</h2>
                <p class="text-slate-300 mb-6">
                    We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required by law.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">9. Children's Privacy</h2>
                <p class="text-slate-300 mb-6">
                    Our services are not directed to children under 18 years of age. We do not knowingly collect personal information from children. If you believe we have collected information from a child, please contact us immediately.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">10. International Data Transfers</h2>
                <p class="text-slate-300 mb-6">
                    Your information may be transferred to and processed in countries other than your country of residence. We ensure appropriate safeguards are in place to protect your information.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">11. Changes to This Privacy Policy</h2>
                <p class="text-slate-300 mb-6">
                    We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.
                </p>

                <h2 class="text-2xl font-bold text-white mb-4">12. Contact Us</h2>
                <p class="text-slate-300 mb-4">
                    If you have questions or concerns about this Privacy Policy, please contact us:
                </p>
                <ul class="list-none text-slate-300 space-y-2 mb-8">
                    <li><strong class="text-white">Email:</strong> privacy@stayvacation.com</li>
                    <li><strong class="text-white">Phone:</strong> +63 (2) 1234 5678</li>
                    <li><strong class="text-white">Address:</strong> 123 Hotel Street, Manila, Philippines 1000</li>
                </ul>

                <div class="bg-indigo-500/10 border border-indigo-500/20 rounded-lg p-6 mt-8">
                    <p class="text-indigo-300 text-sm">
                        <strong>Data Protection Officer:</strong> For privacy-related inquiries, you can contact our Data Protection Officer at dpo@stayvacation.com
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
