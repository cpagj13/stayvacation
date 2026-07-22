<x-app-layout>
    <div class="max-w-2xl mx-auto px-6 py-12">

        <div class="flex items-center gap-2 mb-10">
            <div class="flex items-center gap-2 text-slate-500">
                <div class="w-7 h-7 rounded-full bg-emerald-500 text-white text-xs font-bold flex items-center justify-center">✓</div>
                <span class="text-sm">Details</span>
            </div>
            <div class="flex-1 h-px bg-indigo-500/40"></div>
            <div class="flex items-center gap-2 text-indigo-400">
                <div class="w-7 h-7 rounded-full bg-indigo-500 text-white text-xs font-bold flex items-center justify-center">2</div>
                <span class="text-sm font-medium">Payment proof</span>
            </div>
            <div class="flex-1 h-px bg-white/10"></div>
            <div class="flex items-center gap-2 text-slate-500">
                <div class="w-7 h-7 rounded-full bg-white/10 text-xs font-bold flex items-center justify-center">3</div>
                <span class="text-sm">Summary</span>
            </div>
        </div>

        <h1 class="text-2xl font-bold mb-1">Confirm Payment & Upload Proof</h1>
        <p class="text-slate-400 text-sm mb-8">Please complete your payment using your chosen method below.</p>

        @php
            $paymentMethod = $step1['payment_method'] ?? 'gcash';
            $totalAmount = $step1['total_price'] ?? 0;
        @endphp

        <!-- Payment Method Confirmation Card -->
        <div class="mb-6 rounded-2xl border border-indigo-500/30 bg-slate-900/80 p-6 shadow-xl backdrop-blur-sm">
            <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Selected Payment Method</p>
                    <h2 class="text-xl font-bold text-white capitalize flex items-center gap-2 mt-1">
                        @if($paymentMethod === 'gcash')
                            <span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span> GCash E-Wallet
                        @elseif($paymentMethod === 'maya')
                            <span class="inline-block w-3 h-3 rounded-full bg-emerald-500"></span> Maya E-Wallet
                        @elseif($paymentMethod === 'bank_transfer')
                            <span class="inline-block w-3 h-3 rounded-full bg-purple-500"></span> Bank Transfer (BDO / BPI)
                        @elseif($paymentMethod === 'card')
                            <span class="inline-block w-3 h-3 rounded-full bg-amber-500"></span> Credit / Debit Card
                        @else
                            <span class="inline-block w-3 h-3 rounded-full bg-rose-500"></span> Cash on Arrival
                        @endif
                    </h2>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400">Total Amount Due</p>
                    <p class="text-2xl font-black text-emerald-400">₱{{ number_format($totalAmount, 2) }}</p>
                </div>
            </div>

            <!-- Specific Payment Instructions -->
            @if($paymentMethod === 'gcash')
                <div class="rounded-xl bg-blue-500/10 border border-blue-500/20 p-4 text-sm space-y-2">
                    <p class="font-bold text-blue-300">GCash Payment Details:</p>
                    <div class="flex justify-between text-slate-200">
                        <span>Account Name:</span>
                        <span class="font-mono font-semibold">StayVacation Resort</span>
                    </div>
                    <div class="flex justify-between text-slate-200">
                        <span>GCash Number:</span>
                        <span class="font-mono font-bold text-blue-400">0917-555-8888</span>
                    </div>
                    <p class="text-xs text-slate-400 pt-2 border-t border-blue-500/20">Send exactly <strong>₱{{ number_format($totalAmount, 2) }}</strong> to the GCash number above, then upload your transaction receipt below.</p>
                </div>
            @elseif($paymentMethod === 'maya')
                <div class="rounded-xl bg-emerald-500/10 border border-emerald-500/20 p-4 text-sm space-y-2">
                    <p class="font-bold text-emerald-300">Maya Payment Details:</p>
                    <div class="flex justify-between text-slate-200">
                        <span>Account Name:</span>
                        <span class="font-mono font-semibold">StayVacation Resort</span>
                    </div>
                    <div class="flex justify-between text-slate-200">
                        <span>Maya Mobile/Account:</span>
                        <span class="font-mono font-bold text-emerald-400">0917-555-8888</span>
                    </div>
                    <p class="text-xs text-slate-400 pt-2 border-t border-emerald-500/20">Send <strong>₱{{ number_format($totalAmount, 2) }}</strong> to our Maya account, then upload your confirmation screenshot below.</p>
                </div>
            @elseif($paymentMethod === 'bank_transfer')
                <div class="rounded-xl bg-purple-500/10 border border-purple-500/20 p-4 text-sm space-y-2">
                    <p class="font-bold text-purple-300">Bank Transfer Details:</p>
                    <div class="flex justify-between text-slate-200">
                        <span>BDO Account:</span>
                        <span class="font-mono font-bold text-purple-300">0012-3456-7890</span>
                    </div>
                    <div class="flex justify-between text-slate-200">
                        <span>BPI Account:</span>
                        <span class="font-mono font-bold text-purple-300">9876-5432-10</span>
                    </div>
                    <div class="flex justify-between text-slate-200">
                        <span>Account Name:</span>
                        <span class="font-semibold">StayVacation Resort Inc.</span>
                    </div>
                    <p class="text-xs text-slate-400 pt-2 border-t border-purple-500/20">Transfer <strong>₱{{ number_format($totalAmount, 2) }}</strong> via online banking or deposit, then upload your deposit slip / receipt below.</p>
                </div>
            @elseif($paymentMethod === 'card')
                <div class="rounded-xl bg-amber-500/10 border border-amber-500/20 p-4 text-sm space-y-2">
                    <p class="font-bold text-amber-300">Credit / Debit Card Confirmation:</p>
                    <p class="text-slate-300">Please upload your payment authorization slip or card payment receipt for <strong>₱{{ number_format($totalAmount, 2) }}</strong>.</p>
                </div>
            @else
                <div class="rounded-xl bg-rose-500/10 border border-rose-500/20 p-4 text-sm space-y-2">
                    <p class="font-bold text-rose-300">Cash on Arrival Confirmation:</p>
                    <p class="text-slate-300">Your total of <strong>₱{{ number_format($totalAmount, 2) }}</strong> will be settled at check-in at our front desk.</p>
                    <p class="text-xs text-slate-400 pt-2 border-t border-rose-500/20">Please upload a copy of a valid Government ID (Passport, Driver's License, UMID) to confirm and lock in your reservation.</p>
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-indigo-950/30 backdrop-blur-sm">
            <form id="proof-upload-form" method="POST" action="{{ route('booking.step2.store') }}" enctype="multipart/form-data" class="space-y-6" novalidate>
                @csrf

                <div class="rounded-xl border border-indigo-500/20 bg-indigo-500/10 p-4 text-sm text-slate-300">
                    <p class="font-medium text-indigo-200">Upload your payment proof</p>
                    <p class="mt-1 text-slate-400">Accepted formats: PDF, PNG, JPG, or JPEG. Maximum size: 5MB.</p>
                </div>

                <label id="drop-zone" for="proof" class="group flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/15 bg-white/5 px-6 py-10 text-center transition hover:border-indigo-400/60 hover:bg-indigo-500/10">
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-indigo-500/15 text-indigo-300">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                        </svg>
                    </div>
                    <span class="text-base font-semibold text-slate-100">Click to upload your proof</span>
                    <span class="mt-2 text-sm text-slate-400">or drag and drop a file here</span>
                    <input id="proof" type="file" name="proof" accept=".pdf,.png,.jpg,.jpeg,.webp" class="sr-only" required>
                </label>

                <div id="proof-file-name" class="hidden rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                    <span class="font-medium">Selected file:</span> <span class="ml-1 text-emerald-100" id="proof-file-name-text">No file selected</span>
                </div>

                <div id="client-error-box" class="hidden rounded-lg border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                    <span id="client-error-text"></span>
                </div>

                @error('proof')
                    <div class="rounded-lg border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        {{ $message }}
                    </div>
                @enderror

                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('booking.step1') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-white/10 px-4 py-2.5 text-slate-300 transition hover:bg-white/5">
                        Back
                    </a>
                    <button type="submit"
                        class="flex-1 rounded-lg bg-indigo-500 px-4 py-2.5 font-semibold text-white transition hover:bg-indigo-400">
                        Continue to summary
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('proof-upload-form');
            const input = document.getElementById('proof');
            const dropZone = document.getElementById('drop-zone');
            const fileNameBox = document.getElementById('proof-file-name');
            const fileNameText = document.getElementById('proof-file-name-text');
            const clientErrorBox = document.getElementById('client-error-box');
            const clientErrorText = document.getElementById('client-error-text');

            if (!form || !input || !fileNameBox || !fileNameText) {
                return;
            }

            const showError = (msg) => {
                if (clientErrorBox && clientErrorText) {
                    clientErrorText.textContent = msg;
                    clientErrorBox.classList.remove('hidden');
                }
            };

            const clearError = () => {
                if (clientErrorBox) {
                    clientErrorBox.classList.add('hidden');
                }
            };

            const updateFileName = () => {
                clearError();
                if (input.files && input.files.length > 0) {
                    const file = input.files[0];
                    const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                    fileNameText.textContent = `${file.name} (${sizeMb} MB)`;
                    fileNameBox.classList.remove('hidden');
                } else {
                    fileNameText.textContent = 'No file selected';
                    fileNameBox.classList.add('hidden');
                }
            };

            input.addEventListener('change', updateFileName);

            if (dropZone) {
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropZone.classList.add('border-indigo-400', 'bg-indigo-500/20');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropZone.classList.remove('border-indigo-400', 'bg-indigo-500/20');
                    }, false);
                });

                dropZone.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    if (dt && dt.files && dt.files.length > 0) {
                        input.files = dt.files;
                        updateFileName();
                    }
                });
            }

            form.addEventListener('submit', function (event) {
                clearError();
                if (!input.files || input.files.length === 0) {
                    event.preventDefault();
                    showError('Please select a file to upload before continuing.');
                }
            });
        });
    </script>

</x-app-layout>