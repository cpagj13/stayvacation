<x-app-layout>
    <div class="max-w-2xl mx-auto px-6 py-12">

        <div class="flex items-center gap-2 mb-10">
            <div class="flex items-center gap-2 text-slate-500">
                <div class="w-7 h-7 rounded-full bg-emerald-500 text-white text-xs font-bold flex items-center justify-center">✓</div>
                <span class="text-sm">Details</span>
            </div>
            <div class="flex-1 h-px bg-emerald-500/40"></div>
            <div class="flex items-center gap-2 text-slate-500">
                <div class="w-7 h-7 rounded-full bg-emerald-500 text-white text-xs font-bold flex items-center justify-center">✓</div>
                <span class="text-sm">Payment proof</span>
            </div>
            <div class="flex-1 h-px bg-indigo-500/40"></div>
            <div class="flex items-center gap-2 text-indigo-400">
                <div class="w-7 h-7 rounded-full bg-indigo-500 text-white text-xs font-bold flex items-center justify-center">3</div>
                <span class="text-sm font-medium">Summary</span>
            </div>
        </div>

        <h1 class="text-2xl font-bold mb-1">Review your booking</h1>
        <p class="text-slate-400 text-sm mb-8">Double-check everything before confirming.</p>

        <div class="bg-white/5 border border-white/10 rounded-xl p-6">
            <dl class="divide-y divide-white/10">
                <div class="py-3 flex justify-between text-sm">
                    <dt class="text-slate-400">Guest name</dt>
                    <dd class="font-medium">{{ $data['guest_name'] }}</dd>
                </div>
                <div class="py-3 flex justify-between text-sm">
                    <dt class="text-slate-400">Room</dt>
                    <dd class="font-medium">{{ $data['room_name'] }}</dd>
                </div>

                <div class="py-3 flex justify-between text-sm">
                    <dt class="text-slate-400">Guests</dt>
                    <dd class="font-medium">{{ $data['guests'] }}</dd>
                </div>
                <div class="py-3 flex justify-between text-sm">
                    <dt class="text-slate-400">Rooms</dt>
                    <dd class="font-medium">{{ $data['rooms_count'] }}</dd>
                </div>
                
                <div class="py-3 flex justify-between text-sm">
                    <dt class="text-slate-400">Check-in</dt>
                    <dd class="font-medium">{{ $data['check_in'] }}</dd>
                </div>
                <div class="py-3 flex justify-between text-sm">
                    <dt class="text-slate-400">Check-out</dt>
                    <dd class="font-medium">{{ $data['check_out'] }}</dd>
                </div>
                <div class="py-3 flex justify-between text-sm">
                    <dt class="text-slate-400">Nights</dt>
                    <dd class="font-medium">{{ $data['nights'] }}</dd>
                </div>
                <div class="py-3 flex justify-between text-sm">
                    <dt class="text-slate-400">Payment method</dt>
                    <dd class="font-medium text-indigo-300 capitalize">{{ str_replace('_', ' ', $data['payment_method'] ?? 'gcash') }}</dd>
                </div>
                @if(!empty($data['promo_code']) && !empty($data['discount_amount']))
                    <div class="py-3 flex justify-between text-sm">
                        <dt class="text-slate-400">Promo Code Applied</dt>
                        <dd class="font-bold text-emerald-400 uppercase font-mono">{{ $data['promo_code'] }} (-₱{{ number_format($data['discount_amount'], 2) }})</dd>
                    </div>
                @endif
                <div class="py-3 flex justify-between text-sm">
                    <dt class="text-slate-400">Payment proof</dt>
                    <dd>
                        @if(!empty($data['proof_path']))
                            <a href="{{ route('booking.proof', ['path' => $data['proof_path']]) }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 font-medium">View file →</a>
                        @else
                            <span class="text-slate-500">No proof uploaded</span>
                        @endif
                    </dd>
                </div>
                <div class="py-4 flex justify-between items-center border-t border-white/10">
                    <div>
                        <dt class="font-bold text-lg text-white">Total Amount</dt>
                        <p class="text-xs text-slate-400 mt-0.5">For {{ $data['nights'] }} night(s) stay (₱{{ number_format($data['price_per_night'] ?? 0, 2) }}/night)</p>
                    </div>
                    <dd class="font-bold text-2xl text-emerald-400">₱{{ number_format($data['total_price'], 2) }}</dd>
                </div>
            </dl>

            <form method="POST" action="{{ route('booking.confirm') }}" class="flex gap-3 mt-6">
                @csrf
                <a href="{{ route('booking.step2') }}"
                   class="px-4 py-2.5 rounded-lg border border-white/10 text-slate-300 hover:bg-white/5 transition">
                    Back
                </a>
                <button type="submit"
                    class="flex-1 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-lg px-4 py-2.5 transition">
                    Confirm booking
                </button>
            </form>
        </div>
    </div>
</x-app-layout>