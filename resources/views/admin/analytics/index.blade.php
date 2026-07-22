<x-admin-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Analytics & Reports</h1>
                    <p class="text-slate-400">Business insights and performance metrics</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.analytics.export-bookings') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export Bookings
                    </a>
                    <a href="{{ route('admin.analytics.export-revenue') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-500 text-white font-medium rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export Revenue
                    </a>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Revenue -->
                <div class="bg-gradient-to-br from-green-500/10 to-emerald-500/10 border border-green-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium mb-1">Total Revenue</h3>
                    <p class="text-3xl font-bold text-white">₱{{ number_format($totalRevenue, 2) }}</p>
                    <p class="text-xs text-green-400 mt-2">All time</p>
                </div>

                <!-- Total Bookings -->
                <div class="bg-gradient-to-br from-indigo-500/10 to-purple-500/10 border border-indigo-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium mb-1">Total Bookings</h3>
                    <p class="text-3xl font-bold text-white">{{ $totalBookings }}</p>
                    <p class="text-xs text-indigo-400 mt-2">
                        {{ $confirmedBookings }} confirmed, {{ $pendingBookings }} pending
                    </p>
                </div>

                <!-- Occupancy Rate -->
                <div class="bg-gradient-to-br from-amber-500/10 to-orange-500/10 border border-amber-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium mb-1">Occupancy Rate</h3>
                    <p class="text-3xl font-bold text-white">{{ number_format($occupancyRate, 1) }}%</p>
                    <p class="text-xs text-amber-400 mt-2">Current occupancy</p>
                </div>

                <!-- Average Booking -->
                <div class="bg-gradient-to-br from-blue-500/10 to-cyan-500/10 border border-blue-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium mb-1">Avg Booking Value</h3>
                    <p class="text-3xl font-bold text-white">₱{{ number_format($avgBookingValue, 2) }}</p>
                    <p class="text-xs text-blue-400 mt-2">Per booking</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6 mb-8">
                <!-- Popular Rooms -->
                <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-6">Most Popular Rooms</h3>
                    <div class="space-y-4">
                        @forelse($popularRooms as $room)
                            <div class="flex items-center justify-between p-4 bg-slate-800/50 rounded-lg">
                                <div>
                                    <p class="font-semibold text-white">{{ $room->name }}</p>
                                    <p class="text-sm text-slate-400">₱{{ number_format($room->price, 2) }}/night</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-indigo-400">{{ $room->bookings_count }}</p>
                                    <p class="text-xs text-slate-500">bookings</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-center py-8">No booking data yet</p>
                        @endforelse
                    </div>
                </div>

                <!-- Booking Status Distribution -->
                <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-6">Bookings by Status</h3>
                    <div class="space-y-4">
                        @foreach($bookingsByStatus as $item)
                            @php
                                $percentage = $totalBookings > 0 ? ($item->count / $totalBookings) * 100 : 0;
                                $colors = [
                                    'confirmed' => ['bg' => 'bg-green-500', 'text' => 'text-green-400'],
                                    'pending' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-400'],
                                    'cancelled' => ['bg' => 'bg-red-500', 'text' => 'text-red-400'],
                                    'completed' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-400'],
                                ];
                                $color = $colors[$item->status] ?? ['bg' => 'bg-slate-500', 'text' => 'text-slate-400'];
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-white font-medium capitalize">{{ $item->status }}</span>
                                    <span class="{{ $color['text'] }} font-bold">{{ $item->count }}</span>
                                </div>
                                <div class="w-full bg-slate-800 rounded-full h-2">
                                    <div class="{{ $color['bg'] }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Additional Stats -->
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Customer Stats -->
                <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Customers</h3>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $totalCustomers }}</p>
                    <p class="text-sm text-slate-400">+{{ $newCustomersThisPeriod }} this period</p>
                </div>

                <!-- Reviews Stats -->
                <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Reviews</h3>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $totalReviews }}</p>
                    <p class="text-sm text-slate-400">Avg {{ number_format($averageRating, 1) }}★ | {{ $pendingReviews }} pending</p>
                </div>

                <!-- Revenue This Period -->
                <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Period Revenue</h3>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">₱{{ number_format($revenueThisPeriod, 2) }}</p>
                    <p class="text-sm text-slate-400">Last {{ $period }} days</p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
