<x-layouts.app>
    <!-- Extra Decorations -->
    <div class="fixed inset-0 pointer-events-none z-[3] overflow-hidden">
        <!-- Corner vine decorations -->
        <svg class="absolute top-20 left-0 w-40 h-40 text-[var(--gold)]/10" viewBox="0 0 100 100" fill="currentColor">
            <path d="M0 50 Q20 30 40 40 Q60 50 80 30 Q100 10 100 0" stroke="currentColor" stroke-width="2" fill="none"/>
            <path d="M20 50 Q30 60 40 50 Q50 40 60 50" stroke="currentColor" stroke-width="1" fill="none"/>
            <path d="M40 40 Q50 30 60 40" stroke="currentColor" stroke-width="1" fill="none"/>
        </svg>
        <svg class="absolute top-20 right-0 w-40 h-40 text-[var(--blood)]/10 scale-x-[-1]" viewBox="0 0 100 100" fill="currentColor">
            <path d="M0 50 Q20 30 40 40 Q60 50 80 30 Q100 10 100 0" stroke="currentColor" stroke-width="2" fill="none"/>
            <path d="M20 50 Q30 60 40 50 Q50 40 60 50" stroke="currentColor" stroke-width="1" fill="none"/>
            <path d="M40 40 Q50 30 60 40" stroke="currentColor" stroke-width="1" fill="none"/>
        </svg>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        
        {{-- ── HEADER AREA ── }}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <a href="{{ route('houses.index') }}" class="text-[var(--mist)] hover:text-[var(--gold-light)] transition-colors inline-flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Houses
                </a>
                <h1 class="font-['Cinzel'] text-4xl font-bold text-[#E8DCC8] tracking-widest uppercase drop-shadow-[0_0_15px_rgba(139,0,0,0.3)]">
                    Deleted Houses
                </h1>
                <p class="font-['Crimson_Text'] text-[#6B5A4E] text-xl italic mt-3">
                    "Even the dead can be brought back..."
                </p>
            </div>
        </div>

        @if($houses->isEmpty())
            <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--gold)]/20 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-[var(--mist)] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-[var(--mist)]">No deleted houses found.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($houses as $house)
                    <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--blood)]/30 p-6 opacity-70">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="font-['Cinzel'] text-lg font-bold text-[var(--bone)]">{{ $house->name }}</h3>
                            <span class="text-xs text-[var(--mist)]">Deleted</span>
                        </div>
                        
                        <p class="text-sm text-[var(--parchment)] mb-4 line-clamp-3">{{ $house->motto }}</p>
                        
                        <div class="flex gap-2 mt-4">
                            <form action="{{ route('houses.restore', $house->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                    class="w-full text-center text-xs font-['Cinzel'] uppercase tracking-wider px-3 py-2 rounded border border-[rgba(184,134,11,0.6)] text-[var(--gold-light)] hover:bg-[rgba(184,134,11,0.2)] transition-colors">
                                    Restore
                                </button>
                            </form>
                            <form action="{{ route('houses.forceDelete', $house->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to permanently delete this house? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-full text-center text-xs font-['Cinzel'] uppercase tracking-wider px-3 py-2 rounded border border-[rgba(139,0,0,0.6)] text-[var(--ember)] hover:bg-[rgba(139,0,0,0.2)] transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if ($houses->hasPages())
                <div class="mt-16 pt-8 border-t border-[rgba(107,90,78,0.2)]">
                    {{ $houses->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.app>
