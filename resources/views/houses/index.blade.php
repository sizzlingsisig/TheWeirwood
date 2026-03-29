<x-layouts.app>
    
    {{-- ── MAIN CONTAINER ── --}}
    {{-- Expanded max-width to 1400px to accommodate 4 columns gracefully --}}
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- ── HEADER AREA ── --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="font-['Cinzel'] text-4xl font-bold text-[#E8DCC8] tracking-widest uppercase drop-shadow-[0_0_15px_rgba(139,0,0,0.3)]">
                    The Great Houses
                </h1>
                <p class="font-['Crimson_Text'] text-[#6B5A4E] text-xl italic mt-3">
                    "Blood, gold, and the debts between them."
                </p>
            </div>

            {{-- Protected Archivist Action --}}
            @can('edit-houses')
                <a href="{{ route('houses.create') }}" 
                   class="bg-gradient-to-br from-[rgba(139,0,0,0.8)] to-[rgba(90,0,0,0.9)] border border-[rgba(139,0,0,0.6)] text-[#E8DCC8] font-['Cinzel'] text-xs tracking-[0.2em] uppercase px-8 py-4 rounded-sm hover:from-[rgba(168,0,0,0.9)] hover:to-[#780000] hover:shadow-[0_0_24px_rgba(139,0,0,0.5)] transition-all text-center inline-block whitespace-nowrap">
                    + Add House
                </a>
            @endcan
        </div>

        {{-- ── GRID AREA (4 Columns) ── --}}
        {{-- Added xl:grid-cols-4 to trigger the 4-column layout on large screens --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach ($houses as $house)
                <x-house-card :house="$house" />
            @endforeach
        </div>
        
        {{-- ── PAGINATION AREA ── --}}
        @if ($houses->hasPages())
            <div class="mt-16 pt-8 border-t border-[rgba(107,90,78,0.2)]">
                {{ $houses->links() }}
            </div>
        @endif

    </div>
</x-layouts.app>