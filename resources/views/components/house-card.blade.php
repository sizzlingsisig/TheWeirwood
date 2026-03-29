@php
    // This MUST be at the very top before any HTML is rendered
    $userHasHouse = Auth::check() && Auth::user()->hasHouse($house);
    $isAdmin = Auth::check() && Auth::user()->can('edit-houses');
@endphp

<div class="bg-gradient-to-br from-[rgba(61,43,31,0.6)] to-[rgba(26,21,18,0.9)] border {{ $userHasHouse ? 'border-[rgba(184,134,11,0.4)]' : 'border-[rgba(107,90,78,0.2)]' }} rounded-sm p-6 flex flex-col h-full transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(0,0,0,0.5)] group">
    
    {{-- ── SIGIL / LOCKED AREA ── --}}
    <div class="w-full h-36 mb-6 flex items-center justify-center rounded-sm overflow-hidden {{ $userHasHouse ? '' : 'bg-[#0a0807] border border-[rgba(107,90,78,0.2)] shadow-inner' }}">
        @if($userHasHouse && $house->sigil_image_path)
            <img src="{{ asset('storage/' . $house->sigil_image_path) }}" alt="{{ $house->name }} sigil" class="w-full h-full object-contain drop-shadow-[0_0_12px_rgba(184,134,11,0.2)] group-hover:scale-105 transition-transform duration-500">
        @else
            {{-- Black area with Gold Question Mark --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-[#B8860B] opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @endif
    </div>

    {{-- ── HOUSE IDENTITY ── --}}
    <h2 class="font-['Cinzel'] text-xl font-bold mb-2 tracking-[0.1em] text-center {{ $userHasHouse ? 'text-[#E8DCC8]' : 'text-[#6B5A4E]' }}">
        {{ $userHasHouse ? $house->name : 'Unknown House' }}
    </h2>
    <p class="font-['Crimson_Text'] italic text-center mb-6 {{ $userHasHouse ? 'text-[#B8860B]' : 'text-[#6B5A4E]' }}">
        {{ $userHasHouse && $house->motto ? '"' . $house->motto . '"' : '"Words lost to time"' }}
    </p>

    {{-- ── OPENING STATS ── --}}
    <div class="flex justify-between text-[0.65rem] tracking-[0.15em] font-['Cinzel'] uppercase border-t border-[rgba(107,90,78,0.2)] pt-4 mb-6">
        <span class="{{ $userHasHouse ? 'text-[#4A90D9]' : 'text-[#6B5A4E]' }}">Honor: <span class="font-bold">{{ $house->starting_honor }}</span></span>
        <span class="{{ $userHasHouse ? 'text-[#9B59B6]' : 'text-[#6B5A4E]' }}">Power: <span class="font-bold">{{ $house->starting_power }}</span></span>
        <span class="{{ $userHasHouse ? 'text-[#E74C3C]' : 'text-[#6B5A4E]' }}">Debt: <span class="font-bold">{{ $house->starting_debt }}</span></span>
    </div>

    {{-- ── ACTIONS ── --}}
    <div class="mt-auto flex gap-3 justify-center flex-wrap">
        
        {{-- Only show View if they own the house OR if they are an Admin --}}
        @if($userHasHouse || $isAdmin)
            <a href="{{ route('houses.show', $house) }}" class="bg-transparent border border-[rgba(107,90,78,0.4)] text-[#6B5A4E] font-['Cinzel'] text-[0.6rem] tracking-[0.2em] uppercase px-4 py-2 hover:border-[rgba(184,134,11,0.5)] hover:text-[#B8860B] transition-colors rounded-sm">
                View
            </a>
        @else
            <span class="bg-transparent border border-[rgba(107,90,78,0.2)] text-[#6B5A4E]/50 font-['Cinzel'] text-[0.6rem] tracking-[0.2em] uppercase px-4 py-2 rounded-sm cursor-not-allowed select-none">
                Locked
            </span>
        @endif
        
        {{-- Protected Archivist Controls --}}
        @if($isAdmin)
            <a href="{{ route('houses.edit', $house) }}" class="bg-transparent border border-[rgba(107,90,78,0.4)] text-[#6B5A4E] font-['Cinzel'] text-[0.6rem] tracking-[0.2em] uppercase px-4 py-2 hover:border-[#4A90D9] hover:text-[#4A90D9] transition-colors rounded-sm">
                Edit
            </a>
            <form action="{{ route('houses.destroy', $house) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-[rgba(139,0,0,0.1)] border border-[rgba(139,0,0,0.4)] text-[#E74C3C] font-['Cinzel'] text-[0.6rem] tracking-[0.2em] uppercase px-4 py-2 hover:bg-[rgba(139,0,0,0.6)] hover:text-[#E8DCC8] transition-colors rounded-sm" onclick="return confirm('Erase this house from the archives?')">
                    Delete
                </button>
            </form>
        @endif
    </div>
</div>