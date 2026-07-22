<x-admin-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Reviews Management</h1>
                <p class="text-slate-400">Moderate and manage customer reviews</p>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Tabs -->
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-xl p-6 mb-6">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.reviews.index', ['status' => 'all']) }}" 
                       class="px-4 py-2 rounded-lg font-medium transition {{ $status === 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:bg-slate-700' }}">
                        All Reviews
                        <span class="ml-2 px-2 py-0.5 bg-slate-700 rounded text-xs">
                            {{ \App\Models\Review::count() }}
                        </span>
                    </a>
                    <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
                       class="px-4 py-2 rounded-lg font-medium transition {{ $status === 'pending' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:bg-slate-700' }}">
                        Pending
                        <span class="ml-2 px-2 py-0.5 bg-yellow-600 rounded text-xs">
                            {{ \App\Models\Review::where('status', 'pending')->count() }}
                        </span>
                    </a>
                    <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
                       class="px-4 py-2 rounded-lg font-medium transition {{ $status === 'approved' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:bg-slate-700' }}">
                        Approved
                        <span class="ml-2 px-2 py-0.5 bg-green-600 rounded text-xs">
                            {{ \App\Models\Review::where('status', 'approved')->count() }}
                        </span>
                    </a>
                    <a href="{{ route('admin.reviews.index', ['status' => 'rejected']) }}" 
                       class="px-4 py-2 rounded-lg font-medium transition {{ $status === 'rejected' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:bg-slate-700' }}">
                        Rejected
                        <span class="ml-2 px-2 py-0.5 bg-red-600 rounded text-xs">
                            {{ \App\Models\Review::where('status', 'rejected')->count() }}
                        </span>
                    </a>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="space-y-4">
                @forelse($reviews as $review)
                    <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-xl p-6">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex-1">
                                <!-- Rating -->
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-slate-400 text-sm font-medium">{{ $review->rating }}/5</span>
                                </div>

                                <!-- User Info -->
                                <p class="text-white font-semibold mb-1">{{ $review->user->name }}</p>
                                <p class="text-slate-400 text-sm mb-3">
                                    Room: <span class="text-indigo-400">{{ $review->room->name }}</span> • 
                                    Booking ID: <span class="text-indigo-400">#{{ $review->booking_id }}</span> •
                                    {{ $review->created_at->format('M d, Y') }}
                                </p>

                                <!-- Review Comment -->
                                <p class="text-slate-300 leading-relaxed">{{ $review->comment }}</p>
                            </div>

                            <!-- Status Badge -->
                            <div>
                                @if($review->status === 'pending')
                                    <span class="inline-flex px-3 py-1 bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 text-sm font-medium rounded-full">
                                        Pending
                                    </span>
                                @elseif($review->status === 'approved')
                                    <span class="inline-flex px-3 py-1 bg-green-500/10 border border-green-500/30 text-green-400 text-sm font-medium rounded-full">
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 bg-red-500/10 border border-red-500/30 text-red-400 text-sm font-medium rounded-full">
                                        Rejected
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4 border-t border-slate-800">
                            @if($review->status === 'pending')
                                <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white font-medium rounded-lg transition">
                                        ✓ Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.reviews.reject', $review->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-500 text-white font-medium rounded-lg transition">
                                        ✕ Reject
                                    </button>
                                </form>
                            @elseif($review->status === 'approved')
                                <form method="POST" action="{{ route('admin.reviews.reject', $review->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-500 text-white font-medium rounded-lg transition">
                                        Reject
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white font-medium rounded-lg transition">
                                        Approve
                                    </button>
                                </form>
                            @endif
                            
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white font-medium rounded-lg transition">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-xl p-12 text-center">
                        <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-slate-400 mb-2">No Reviews Found</h3>
                        <p class="text-slate-500">Reviews will appear here once customers submit them.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
