<x-guest-layout>
    <div class="w-full">
        {{-- Header --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="StayVacation Logo" class="h-12 w-auto object-contain drop-shadow-lg">
                <div class="text-left">
                    <span class="font-bold text-xl text-white tracking-tight">{{ config('app.name', 'StayVacation') }}</span>
                    <p class="text-xs text-slate-400">Email Verification</p>
                </div>
            </a>
            <h2 class="mt-6 text-2xl font-extrabold text-white">Check your email</h2>
            <p class="mt-2 text-sm text-slate-400">
                We sent a 6-digit code to<br>
                <span class="font-semibold text-sky-400">{{ $user->email }}</span>
            </p>
        </div>

        {{-- Card --}}
        <div class="bg-slate-900/70 border border-white/10 rounded-2xl p-8 shadow-2xl">

            {{-- Success message --}}
            @if (session('status'))
                <div class="mb-5 flex items-center gap-2 text-xs font-semibold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Error message --}}
            @if ($errors->any())
                <div class="mb-5 flex items-center gap-2 text-xs font-semibold text-red-400 bg-red-500/10 border border-red-500/20 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('otp.verify.submit') }}" id="otp-form" novalidate>
                @csrf

                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest text-center mb-4">
                    Enter verification code
                </p>

                {{-- 6 digit boxes --}}
                <div class="flex justify-center gap-3 mb-6" id="otp-inputs">
                    @for ($i = 0; $i < 6; $i++)
                        <input
                            type="text"
                            inputmode="numeric"
                            maxlength="1"
                            autocomplete="{{ $i === 0 ? 'one-time-code' : 'off' }}"
                            class="otp-digit w-12 h-14 text-center text-2xl font-bold text-white bg-slate-800 border-2 border-slate-600 rounded-xl
                                   focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30 focus:outline-none
                                   transition-all duration-150 caret-transparent select-none"
                        >
                    @endfor
                </div>

                {{-- Hidden field that actually gets submitted --}}
                <input type="hidden" name="otp" id="otp_full">

                <button type="submit"
                    class="w-full py-3.5 px-4 bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-600 hover:to-indigo-700
                           text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-sky-500/20
                           flex items-center justify-center gap-2">
                    <span>Verify Account</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            {{-- Resend --}}
            <div class="mt-6 pt-6 border-t border-white/10 text-center">
                <p class="text-xs text-slate-400 mb-3">Didn't receive the code?</p>
                <form method="POST" action="{{ route('otp.resend') }}">
                    @csrf
                    <button type="submit"
                        class="text-sm font-semibold text-sky-400 hover:text-sky-300 transition underline underline-offset-4">
                        Resend Verification Code
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Inline script — no @push needed, always renders --}}
    <script>
    (function () {
        const inputs     = Array.from(document.querySelectorAll('.otp-digit'));
        const hidden     = document.getElementById('otp_full');
        const form       = document.getElementById('otp-form');

        function collect() {
            hidden.value = inputs.map(el => el.value).join('');
        }

        function setError(hasError) {
            inputs.forEach(el => {
                if (!el.value) {
                    el.classList.toggle('border-red-500', hasError);
                    el.classList.toggle('border-slate-600', !hasError);
                }
            });
        }

        inputs.forEach(function (el, idx) {

            // Only allow one numeric digit; auto-advance
            el.addEventListener('input', function () {
                el.value = el.value.replace(/\D/g, '').slice(-1);
                setError(false);
                collect();
                if (el.value && idx < inputs.length - 1) {
                    inputs[idx + 1].focus();
                }
            });

            // Backspace: clear current, or move back
            el.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace') {
                    e.preventDefault();
                    if (el.value) {
                        el.value = '';
                        collect();
                    } else if (idx > 0) {
                        inputs[idx - 1].value = '';
                        inputs[idx - 1].focus();
                        collect();
                    }
                } else if (e.key === 'ArrowLeft'  && idx > 0)               inputs[idx - 1].focus();
                  else if (e.key === 'ArrowRight' && idx < inputs.length - 1) inputs[idx + 1].focus();
            });

            // Paste anywhere — strip non-digits, fill all boxes
            el.addEventListener('paste', function (e) {
                e.preventDefault();
                const digits = (e.clipboardData || window.clipboardData)
                    .getData('text').replace(/\D/g, '').slice(0, 6);
                digits.split('').forEach(function (ch, i) {
                    if (inputs[i]) inputs[i].value = ch;
                });
                collect();
                const next = inputs.find(function (x) { return !x.value; });
                (next || inputs[inputs.length - 1]).focus();
            });

            el.addEventListener('focus', function () { el.select(); });
        });

        form.addEventListener('submit', function (e) {
            collect();
            if (hidden.value.length !== 6) {
                e.preventDefault();
                setError(true);
                const first = inputs.find(function (x) { return !x.value; });
                if (first) first.focus();
            }
        });

        // Auto-focus first box on load
        if (inputs[0]) inputs[0].focus();
    })();
    </script>
</x-guest-layout>
