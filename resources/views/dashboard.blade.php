<x-admin-layout>
    <div class="px-8 py-8">
        <h1 class="text-2xl font-bold mb-1">Bookings</h1>
        <p class="text-slate-400 text-sm mb-8">Review and manage all reservations.</p>

        <div class="grid sm:grid-cols-5 gap-4 mb-8">
            <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                <p class="text-slate-400 text-sm mb-1">Total</p>
                <p class="text-2xl font-bold">{{ $stats['total_bookings'] }}</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                <p class="text-slate-400 text-sm mb-1">Pending</p>
                <p class="text-2xl font-bold text-amber-400">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                <p class="text-slate-400 text-sm mb-1">Confirmed</p>
                <p class="text-2xl font-bold text-emerald-400">{{ $stats['confirmed'] }}</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                <p class="text-slate-400 text-sm mb-1">Cancelled</p>
                <p class="text-2xl font-bold text-red-400">{{ $stats['cancelled'] }}</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                <p class="text-slate-400 text-sm mb-1">Total users</p>
                <p class="text-2xl font-bold text-indigo-400">{{ $stats['total_users'] }}</p>
            </div>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-white/5 text-slate-400 text-left">
                    <tr>
                        <th class="px-5 py-3 font-medium">Guest</th>
                        <th class="px-5 py-3 font-medium">Room</th>
                        <th class="px-5 py-3 font-medium">Dates</th>
                        <th class="px-5 py-3 font-medium">Total</th>
                        <th class="px-5 py-3 font-medium">Proof</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($bookings as $booking)
                        <tr>
                            <td class="px-5 py-3">
                                <p class="font-medium">{{ $booking->guest_name }}</p>
                                <p class="text-slate-500 text-xs">{{ $booking->user->email }}</p>
                            </td>
                            <td class="px-5 py-3">{{ $booking->room->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-slate-400">
                                {{ $booking->check_in->format('M d') }} – {{ $booking->check_out->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-3">₱{{ number_format($booking->total_price, 2) }}</td>
                            <td class="px-5 py-3">
                                @if($booking->proof_path)
                                    <a href="{{ Storage::url($booking->proof_path) }}" target="_blank" class="text-indigo-400 hover:text-indigo-300">View</a>
                                @else
                                    <span class="text-slate-600">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                        class="bg-slate-900 border border-white/10 rounded-lg text-xs px-2 py-1.5">
                                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $bookings->links() }}</div>
    </div>
</x-admin-layout>