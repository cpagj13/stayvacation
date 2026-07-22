@props(['icon', 'title', 'description'])

<div class="group bg-slate-900/30 border border-white/10 rounded-xl p-6 hover:bg-slate-900/50 hover:border-primary-500/30 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
    <div class="w-12 h-12 bg-primary-500/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary-500/20 group-hover:scale-110 transition-all duration-300">
        {{ $icon }}
    </div>
    <h3 class="font-semibold text-lg text-white mb-2">{{ $title }}</h3>
    <p class="text-slate-400 text-sm leading-relaxed">{{ $description }}</p>
</div>
