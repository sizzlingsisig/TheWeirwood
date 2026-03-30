<x-layouts.app>
    <div class="fixed inset-0 pointer-events-none z-[3] overflow-hidden">
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
        
        {{-- ── HEADER AREA ── --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 border-b border-[var(--gold)]/20 pb-6">
            <div>
                <a href="{{ route('houses.index') }}" class="text-[var(--mist)] hover:text-[var(--gold-light)] transition-colors inline-flex items-center gap-2 mb-4 font-['Cinzel'] tracking-widest text-sm uppercase">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Active Records
                </a>
                <h1 class="font-['Cinzel'] text-4xl font-bold text-[#E8DCC8] tracking-widest uppercase drop-shadow-[0_0_15px_rgba(139,0,0,0.3)]">
                    The Forgotten Archives
                </h1>
                <p class="font-['Crimson_Text'] text-[#6B5A4E] text-xl italic mt-3">
                    "Even the dead can be brought back... for a price."
                </p>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-8 p-4 bg-[rgba(139,0,0,0.2)] border border-[rgba(139,0,0,0.5)] text-[#E8DCC8] font-['Cinzel'] tracking-wider rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- ── GRID AREA ── --}}
        @if($houses->isEmpty())
            <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--gold)]/20 p-16 text-center shadow-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-[var(--mist)]/50 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <p class="font-['Crimson_Text'] text-2xl text-[var(--mist)] italic">The archives are empty. No houses have fallen yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($houses as $house)
                    <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--blood)]/30 p-6 opacity-80 hover:opacity-100 transition-opacity flex flex-col justify-between h-full">
                        
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                @if($house->sigil_image_path)
                                    <img src="{{ asset('storage/' . $house->sigil_image_path) }}" alt="{{ $house->name }} Sigil" class="w-12 h-12 object-cover rounded border border-[var(--mist)]/30 grayscale">
                                @else
                                    <div class="w-12 h-12 bg-black/50 border border-[var(--mist)]/30 rounded flex items-center justify-center text-[10px] text-[var(--mist)]/50 uppercase tracking-tighter">No Sigil</div>
                                @endif

                                <div>
                                    <h3 class="font-['Cinzel'] text-lg font-bold text-[var(--bone)] line-through">{{ $house->name }}</h3>
                                    <span class="text-xs text-[var(--blood)] font-bold uppercase tracking-widest">Destroyed</span>
                                </div>
                            </div>
                            
                            <p class="font-['Crimson_Text'] text-lg text-[var(--parchment)] mb-6 italic line-clamp-3">
                                "{{ $house->motto ?? 'No motto recorded' }}"
                            </p>
                        </div>
                        
                        <div class="flex gap-3 mt-auto pt-4 border-t border-[var(--mist)]/10">
                            <form action="{{ route('houses.restore', $house->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                    class="w-full text-center text-xs font-['Cinzel'] uppercase tracking-wider px-3 py-3 rounded border border-[rgba(184,134,11,0.6)] text-[var(--gold-light)] hover:bg-[rgba(184,134,11,0.2)] hover:shadow-[0_0_10px_rgba(184,134,11,0.3)] transition-all">
                                    Restore
                                </button>
                            </form>
                            
                            <form action="{{ route('houses.forceDelete', $house->id) }}" method="POST" class="flex-1" onsubmit="return confirm('WARNING: This will permanently erase this House and its sigil image from the server. This cannot be undone. Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-full text-center text-xs font-['Cinzel'] uppercase tracking-wider px-3 py-3 rounded border border-[rgba(139,0,0,0.6)] text-[var(--ember)] hover:bg-[rgba(139,0,0,0.2)] hover:shadow-[0_0_10px_rgba(139,0,0,0.3)] transition-all">
                                    Burn Records
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