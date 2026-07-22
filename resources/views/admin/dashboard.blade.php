<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Admin Dashboard</h1>
                    <p class="text-slate-400">Welcome back! Here's what's happening with your bookings today.</p>
                </div>
                <div class="hidden sm:flex items-center gap-3">
                    <div class="px-4 py-2 bg-slate-900/50 border border-white/10 rounded-lg">
                        <p class="text-xs text-slate-400">Total Revenue</p>
                        <p class="text-lg font-bold text-white">₱{{ number_format($bookings->sum('total_price'), 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 border border-blue-500/20 rounded-xl p-6 hover:border-blue-500/40 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-blue-400 bg-blue-500/10 px-2 py-1 rounded-full">Total</span>
                </div>
                <p class="text-3xl font-bold text-white mb-1">{{ $stats['total_bookings'] }}</p>
                <p class="text-sm text-slate-400">All Bookings</p>
            </div>

            <div class="bg-gradient-to-br from-amber-500/10 to-amber-600/5 border border-amber-500/20 rounded-xl p-6 hover:border-amber-500/40 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-amber-400 bg-amber-500/10 px-2 py-1 rounded-full">Pending</span>
                </div>
                <p class="text-3xl font-bold text-white mb-1">{{ $stats['pending'] }}</p>
                <p class="text-sm text-slate-400">Awaiting Approval</p>
            </div>

            <div class="bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 border border-emerald-500/20 rounded-xl p-6 hover:border-emerald-500/40 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded-full">Active</span>
                </div>
                <p class="text-3xl font-bold text-white mb-1">{{ $stats['confirmed'] }}</p>
                <p class="text-sm text-slate-400">Confirmed Bookings</p>
            </div>

            <div class="bg-gradient-to-br from-red-500/10 to-red-600/5 border border-red-500/20 rounded-xl p-6 hover:border-red-500/40 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-red-400 bg-red-500/10 px-2 py-1 rounded-full">Cancelled</span>
                </div>
                <p class="text-3xl font-bold text-white mb-1">{{ $stats['cancelled'] }}</p>
                <p class="text-sm text-slate-400">Cancelled Bookings</p>
            </div>
        </div>

        {{-- Bookings Table --}}
        <div class="bg-slate-900/50 border border-white/10 rounded-xl overflow-hidden shadow-xl">
            <div class="px-6 py-5 border-b border-white/10 bg-gradient-to-r from-slate-900/80 to-slate-900/40">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Recent Bookings
                        </h2>
                        <p class="text-sm text-slate-400 mt-1">Manage and update booking statuses</p>
                    </div>
                    <span class="px-3 py-1.5 bg-primary-500/10 text-primary-400 text-sm font-semibold rounded-lg border border-primary-500/20">
                        {{ $bookings->total() }} Total
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-white/5 text-slate-400 text-left">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Guest</th>
                            <th class="px-6 py-4 font-semibold">Room</th>
                            <th class="px-6 py-4 font-semibold">Check-in / Check-out</th>
                            <th class="px-6 py-4 font-semibold">Total Price</th>
                            <th class="px-6 py-4 font-semibold">Proof</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-indigo-500/10 rounded-full flex items-center justify-center">
                                            <span class="text-indigo-400 font-semibold text-sm">{{ substr($booking->guest_name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-white">{{ $booking->guest_name }}</p>
                                            <p class="text-xs text-slate-400">{{ $booking->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-white">{{ $booking->room->name ?? '—' }}</p>
                                    <p class="text-xs text-slate-400">{{ $booking->room->category->name ?? 'Standard' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <p class="text-white">{{ $booking->check_in->format('M d, Y') }}</p>
                                        <p class="text-xs text-slate-400">to {{ $booking->check_out->format('M d, Y') }}</p>
                                        <p class="text-xs text-slate-500">{{ $booking->check_in->diffInDays($booking->check_out) }} nights</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-white">₱{{ number_format($booking->total_price, 2) }}</p>
                                    <p class="text-xs text-indigo-300 capitalize font-medium">{{ str_replace('_', ' ', $booking->payment_method ?? 'gcash') }}</p>
                                    @if($booking->discount_amount > 0)
                                        <p class="text-[11px] text-emerald-400 font-semibold">Disc: -₱{{ number_format($booking->discount_amount, 2) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($booking->proof_path)
                                        <a href="{{ route('booking.proof', ['path' => $booking->proof_path]) }}" target="_blank" 
                                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 hover:text-white hover:bg-indigo-500/20 rounded-lg text-xs font-semibold transition">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Proof
                                        </a>
                                    @else
                                        <span class="text-slate-600 text-xs">No proof</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'confirmed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'cancelled' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                            'completed' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusColors[$booking->status] ?? '' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="bg-slate-800 border border-white/10 rounded-lg text-sm px-3 py-2 text-white hover:border-white/20 transition cursor-pointer focus:ring-2 focus:ring-primary-500/50">
                                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gradient-to-br from-slate-800 to-slate-900 rounded-full flex items-center justify-center mb-6 border border-white/10">
                                            <svg class="w-10 h-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-300 text-xl font-semibold mb-2">No bookings yet</p>
                                        <p class="text-slate-500 text-sm mb-6">Bookings will appear here once guests start booking rooms</p>
                                        <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Rooms
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-white/10">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
