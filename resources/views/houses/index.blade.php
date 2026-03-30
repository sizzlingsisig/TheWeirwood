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

    {{-- Expanded max-width to 1400px to accommodate 4 columns gracefully --}}
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <h1 class="font-['Cinzel'] text-4xl font-bold text-[#E8DCC8] tracking-widest uppercase drop-shadow-[0_0_15px_rgba(139,0,0,0.3)]">
                    The Great Houses
                </h1>
                <p class="font-['Crimson_Text'] text-[#6B5A4E] text-xl italic mt-3">
                    "Blood, gold, and the debts between them."
                </p>
            </div>

            {{-- Protected Archivist Actions --}}
            <div class="flex gap-3">
                @can('edit-houses')
                    <a href="{{ route('houses.trashed') }}"
                       class="border border-[rgba(107,90,78,0.4)] text-[#E8DCC8] font-['Cinzel'] text-xs tracking-[0.2em] uppercase px-6 py-3 rounded-sm hover:bg-[rgba(107,90,78,0.2)] hover:border-[rgba(184,134,11,0.6)] transition-all text-center inline-block whitespace-nowrap">
                        View Archives
                    </a>
                    <a href="{{ route('houses.create') }}"
                       class="bg-gradient-to-br from-[rgba(139,0,0,0.8)] to-[rgba(90,0,0,0.9)] border border-[rgba(139,0,0,0.6)] text-[#E8DCC8] font-['Cinzel'] text-xs tracking-[0.2em] uppercase px-8 py-4 rounded-sm hover:from-[rgba(168,0,0,0.9)] hover:to-[#780000] hover:shadow-[0_0_24px_rgba(139,0,0,0.5)] transition-all text-center inline-block whitespace-nowrap">
                        + Add House
                    </a>
                @endcan
            </div>
        </div>

        <form action="{{ route('houses.index') }}" method="GET" class="mb-10 flex items-center bg-[#1A1512]/80 border border-[rgba(107,90,78,0.4)] rounded-sm shadow-xl max-w-2xl">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ledger by name or motto..."
                class="flex-1 bg-transparent border-none text-[#E8DCC8] focus:ring-0 placeholder-[rgba(232,220,200,0.4)] font-['Crimson_Text'] text-lg px-6 py-3">
            
            <button type="submit" class="px-6 py-3 border-l border-[rgba(107,90,78,0.4)] text-[rgba(232,220,200,0.6)] hover:text-[#E8DCC8] hover:bg-black/40 font-['Cinzel'] tracking-widest text-sm transition-colors uppercase">
                Search
            </button>
            
            @if(request('search'))
                <a href="{{ route('houses.index') }}" class="px-6 py-3 border-l border-[rgba(107,90,78,0.4)] text-red-800/80 hover:text-red-500 hover:bg-black/40 font-['Cinzel'] tracking-widest text-sm transition-colors uppercase">
                    Clear
                </a>
            @endif
        </form>

        {{-- ── GRID AREA (4 Columns) ── --}}
        @if($houses->isEmpty())
            <div class="bg-[#1A1512]/60 border border-[rgba(107,90,78,0.3)] p-16 text-center rounded shadow-lg">
                <p class="font-['Crimson_Text'] text-[rgba(232,220,200,0.6)] text-2xl italic">The archivists found no records matching your query.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($houses as $house)
                    <x-house-card :house="$house" />
                @endforeach
            </div>
        @endif

        {{-- PAGINATION --}}
        @if ($houses->hasPages())
            <div class="mt-16 pt-8 border-t border-[rgba(107,90,78,0.2)]">
                {{ $houses->links() }}
            </div>
        @endif

    </div>
</x-layouts.app>