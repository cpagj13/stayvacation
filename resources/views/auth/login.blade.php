<x-guest-layout>
    <h1 class="text-2xl font-bold mb-1">Welcome back</h1>
    <p class="text-slate-400 text-sm mb-8">Log in to manage your bookings.</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full rounded-lg bg-white/5 border border-white/10 text-white placeholder-slate-500 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="you@example.com">
            @error('email')
                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-slate-300">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-400 hover:text-indigo-300">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full rounded-lg bg-white/5 border border-white/10 text-white placeholder-slate-500 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-400">
            <input type="checkbox" name="remember"
                class="rounded border-white/20 bg-white/5 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-0">
            Remember me
        </label>

        <button type="submit"
            class="w-full bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-lg px-4 py-2.5 transition">
            Log in
        </button>

        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/10"></div>
            </div>
            <div class="relative flex justify-center text-xs">
                <span class="bg-slate-950 px-3 text-slate-500">or</span>
            </div>
        </div>

        <a href="{{ route('register') }}"
            class="block text-center w-full bg-white/5 hover:bg-white/10 border border-white/10 text-white font-semibold rounded-lg px-4 py-2.5 transition">
            Create an account
        </a>
    </form>
</x-guest-layout>