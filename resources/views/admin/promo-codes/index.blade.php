<x-admin-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Promo Codes</h1>
                    <p class="text-slate-400">Manage discount codes and promotions</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.promo-codes.export') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export CSV
                    </a>
                    <a href="{{ route('admin.promo-codes.create') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-semibold rounded-lg transition shadow-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Promo Code
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Promo Codes Table -->
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Discount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Usage</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Valid Until</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($promoCodes as $code)
                                <tr class="hover:bg-slate-800/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono font-bold text-indigo-400">{{ $code->code }}</span>
                                            @if(!$code->is_active)
                                                <span class="px-2 py-0.5 bg-red-500/10 border border-red-500/30 text-red-400 text-xs rounded">Inactive</span>
                                            @endif
                                        </div>
                                        @if($code->description)
                                            <p class="text-xs text-slate-500 mt-1">{{ Str::limit($code->description, 50) }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-300">
                                        <span class="capitalize">{{ $code->type }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-white font-semibold">
                                            @if($code->type === 'percentage')
                                                {{ $code->value }}%
                                            @else
                                                ₱{{ number_format($code->value, 2) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-slate-300">
                                            <span class="font-semibold text-white">{{ $code->used_count }}</span>
                                            <span class="text-slate-500">/ {{ $code->max_uses ?? '∞' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-300">
                                        {{ $code->valid_until ? $code->valid_until->format('M d, Y') : 'No expiry' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($code->is_active && (!$code->valid_until || $code->valid_until->isFuture()))
                                            <span class="inline-flex px-2 py-1 bg-green-500/10 border border-green-500/30 text-green-400 text-xs font-medium rounded-full">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 bg-slate-500/10 border border-slate-500/30 text-slate-400 text-xs font-medium rounded-full">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.promo-codes.edit', $code) }}" 
                                               class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.promo-codes.destroy', $code) }}" class="inline" onsubmit="return confirm('Delete this promo code?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-500 text-white text-sm font-medium rounded-lg transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <h3 class="text-xl font-semibold text-slate-400 mb-2">No Promo Codes Yet</h3>
                                        <p class="text-slate-500 mb-6">Create your first promo code to start offering discounts!</p>
                                        <a href="{{ route('admin.promo-codes.create') }}" 
                                           class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg transition">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Add Promo Code
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($promoCodes->hasPages())
                <div class="mt-6">
                    {{ $promoCodes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
