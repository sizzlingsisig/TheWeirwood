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

    <div class="max-w-6xl mx-auto relative z-10">
        <!-- Back Link -->
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-[var(--mist)] hover:text-[var(--gold-light)] transition-colors inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="font-['Cinzel'] text-2xl font-bold text-[var(--bone)] tracking-wider">Endings Catalogue</h1>
                <p class="text-[var(--mist)] mt-2 italic">Discover all possible fates within the Weirwood</p>
            </div>
            <span class="text-[var(--gold-light)] font-['Cinzel'] text-sm">{{ $allEndings->filter(fn($e) => in_array($e->node_id, $discoveredEndingIds))->count() }} / {{ $allEndings->count() }} Discovered</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ hoveredEnding: null, hoveredData: null }">
            @foreach($allEndings as $ending)
                @php
                    $isDiscovered = in_array($ending->node_id, $discoveredEndingIds);
                @endphp
                @if($isDiscovered)
                    <div 
                        class="block bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--gold)]/20 p-6 transition-all hover:border-[var(--gold)]/40 hover:-translate-y-1 cursor-pointer"
                        @mouseenter="hoveredEnding = {{ $ending->id }}; hoveredData = { type: '{{ $ending->ending_type }}', verdict: '{{ $ending->verdict_label }}', text: @js($ending->ending_text), unlocks: '{{ $ending->unlockedHouse?->name }}' }"
                        @mouseleave="hoveredEnding = null"
                    >
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-['Cinzel'] font-semibold uppercase text-[var(--mist)] tracking-wider">{{ $ending->ending_type }}</span>
                            @if($ending->unlockedHouse)
                                <span class="text-xs text-[var(--gold-light)]">Unlocks: {{ $ending->unlockedHouse->name }}</span>
                            @endif
                        </div>
                        <h3 class="font-['Cinzel'] font-bold text-[var(--bone)] text-lg mb-3">{{ $ending->verdict_label }}</h3>
                        <p class="text-sm text-[var(--parchment)] line-clamp-4 leading-relaxed">{{ $ending->ending_text }}</p>
                    </div>
                @else
                    <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--gold)]/20 p-6 opacity-50">
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-[var(--mist)] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <p class="text-[var(--mist)] font-['Cinzel'] text-lg">???</p>
                            <p class="text-sm text-[var(--mist)] mt-1">Complete a run to discover</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Hover Modal Overlay -->
        <div 
            x-show="hoveredEnding !== null"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display: none;"
        >
            <div class="absolute inset-0 bg-black/70" @click="hoveredEnding = null"></div>
            <div 
                class="relative bg-[var(--coal)] border border-[var(--gold)]/40 rounded-xl p-8 max-w-2xl w-full shadow-2xl max-h-[80vh] overflow-y-auto"
                @click.stop
            >
                <button @click="hoveredEnding = null" class="absolute top-4 right-4 text-[var(--mist)] hover:text-[var(--bone)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <template x-if="hoveredData">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-['Cinzel'] font-semibold uppercase text-[var(--gold-light)] tracking-wider" x-text="hoveredData?.type"></span>
                            <template x-if="hoveredData?.unlocks">
                                <span class="text-xs text-[var(--gold)]">Unlocks: <span x-text="hoveredData?.unlocks"></span></span>
                            </template>
                        </div>
                        <h3 class="font-['Cinzel'] font-bold text-[var(--bone)] text-2xl mb-4" x-text="hoveredData?.verdict"></h3>
                        <p class="text-[var(--parchment)] leading-relaxed text-lg" x-text="hoveredData?.text"></p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-layouts.app>
