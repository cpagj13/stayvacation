<x-guest-layout>
    <div class="min-h-screen bg-slate-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="StayVacation Logo" class="h-14 w-auto object-contain drop-shadow-lg">
                <div class="text-left">
                    <span class="font-display font-bold text-2xl text-white tracking-tight">{{ config('app.name', 'StayVacation') }}</span>
                    <p class="text-xs text-slate-400">Email Verification</p>
                </div>
            </a>
            <h2 class="mt-6 text-2xl font-extrabold text-white">Enter 6-Digit Code</h2>
            <p class="mt-2 text-sm text-slate-400">
                We have sent a verification code to <span class="font-bold text-primary-400">{{ $user->email }}</span>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-slate-900/60 border border-white/10 py-8 px-6 shadow-2xl rounded-2xl sm:px-10">
                
                @if (session('status'))
                    <div class="mb-4 text-xs font-semibold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-3 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 text-xs font-semibold text-red-400 bg-red-500/10 border border-red-500/20 rounded-xl p-3 text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify.submit') }}" id="otp-form">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider text-center mb-4">
                            Verification Code
                        </label>
                        
                        <div class="flex justify-between gap-2 sm:gap-3" id="otp-inputs">
                            @for ($i = 0; $i < 6; $i++)
                                <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required
                                    class="otp-digit w-11 h-13 sm:w-12 sm:h-14 text-center text-xl font-bold text-white bg-slate-950/80 border border-slate-700 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/40 focus:outline-none transition">
                            @endfor
                        </div>
                        <input type="hidden" name="otp" id="otp_full">
                    </div>

                    <button type="submit" id="btn-submit-otp"
                        class="w-full py-3.5 px-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-primary-500/20 flex items-center justify-center gap-2">
                        <span>Verify Account</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>

                <div class="mt-6 border-t border-white/10 pt-6 text-center">
                    <p class="text-xs text-slate-400 mb-3">Didn't receive the code?</p>
                    <form method="POST" action="{{ route('otp.resend') }}">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-primary-400 hover:text-primary-300 transition underline underline-offset-4">
                            Resend Verification Code
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.otp-digit');
        const hiddenInput = document.getElementById('otp_full');
        const form = document.getElementById('otp-form');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const val = e.target.value;
                if (val.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                updateFullOtp();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = (e.clipboardData || window.clipboardData).getData('text').trim();
                if (/^\d{6}$/.test(pastedData)) {
                    pastedData.split('').forEach((char, i) => {
                        if (inputs[i]) inputs[i].value = char;
                    });
                    inputs[5].focus();
                    updateFullOtp();
                }
            });
        });

        function updateFullOtp() {
            let code = '';
            inputs.forEach(input => code += input.value);
            hiddenInput.value = code;
        }

        form.addEventListener('submit', function (e) {
            updateFullOtp();
            if (hiddenInput.value.length !== 6) {
                e.preventDefault();
                alert('Please enter all 6 digits of your verification code.');
            }
        });

        if (inputs[0]) inputs[0].focus();
    });
    </script>
    @endpush
</x-guest-layout>
