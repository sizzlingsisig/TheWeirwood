<x-layouts.game 
    :houseName="$game->house->name"
    :honor="$game->honor"
    :power="$game->power"
    :debt="$game->debt"
>
    <!-- Ending Extra Decorations -->
    <div class="fixed inset-0 pointer-events-none z-[3] overflow-hidden">
        <!-- Floating particles -->
        <div class="absolute top-1/4 left-10 w-1 h-1 bg-[var(--gold)]/30 rounded-full animate-pulse"></div>
        <div class="absolute top-1/3 right-16 w-2 h-2 bg-[var(--blood)]/20 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/4 left-1/4 w-1 h-1 bg-[var(--mist)]/40 rounded-full animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 right-1/3 w-1.5 h-1.5 bg-[var(--gold)]/25 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
        
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
        
        <!-- Side decorative borders -->
        <div class="absolute left-4 top-1/2 -translate-y-1/2 w-px h-32 bg-gradient-to-b from-transparent via-[var(--gold)]/20 to-transparent"></div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 w-px h-32 bg-gradient-to-b from-transparent via-[var(--blood)]/20 to-transparent"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-4 sm:py-6 relative z-10 min-h-0 flex flex-col">
        
        <!-- Ending Card -->
        <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--gold)]/20 mb-6 overflow-hidden relative flex-1 min-h-0 flex flex-col">
            <!-- Corner decorations -->
            <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-[var(--gold)]/40 rounded-tl-xl"></div>
            <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-[var(--gold)]/40 rounded-tr-xl"></div>
            <div class="absolute bottom-0 left-0 w-8 h-8 border-b-2 border-l-2 border-[var(--gold)]/40 rounded-bl-xl"></div>
            <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-[var(--gold)]/40 rounded-br-xl"></div>
            
            <!-- Center decorative element -->
            <div class="absolute top-4 left-1/2 -translate-x-1/2 w-20 h-px bg-gradient-to-r from-transparent via-[var(--gold)]/30 to-transparent"></div>
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 w-20 h-px bg-gradient-to-r from-transparent via-[var(--gold)]/30 to-transparent"></div>
            
            <!-- Scene Image -->
            @if($game->currentNode->art_image_path)
                <div class="relative h-32 sm:h-48 overflow-hidden flex-shrink-0">
                    <img src="{{ asset('storage/' . $game->currentNode->art_image_path) }}" alt="Ending" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--bark)]/80 to-transparent"></div>
                </div>
            @endif

            <div class="p-4 sm:p-6 flex-1 min-h-0 overflow-auto">
                <!-- The End Label -->
                <div class="text-center mb-6">
                    <span class="text-sm uppercase tracking-[0.2em] text-[var(--gold-light)]">The End</span>
                    <h1 class="font-['Cinzel'] text-2xl sm:text-3xl font-bold text-[var(--bone)] mt-2">{{ $game->currentNode->title }}</h1>
                </div>

                <!-- Narrative Text -->
                <div class="prose prose-invert max-w-none mb-6">
                    <p class="whitespace-pre-wrap text-[var(--parchment)] leading-relaxed text-base sm:text-lg">{{ $game->currentNode->narrative_text }}</p>
                </div>

                <!-- Ending Verdict -->
                @if($game->currentNode->ending)
                    <div class="bg-[var(--coal)]/50 rounded-lg p-4 mb-6 border border-[var(--gold)]/20">
                        <p class="text-center font-['Cinzel'] font-semibold text-lg text-[var(--bone)] mb-1">{{ $game->currentNode->ending->verdict_label }}</p>
                        <p class="text-center text-sm text-[var(--mist)] uppercase tracking-wider">{{ ucfirst($game->currentNode->ending->ending_type) }} Ending</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Final Stats -->
        <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--gold)]/20 mb-6 p-4 sm:p-6 flex-shrink-0">
            <h2 class="font-['Cinzel'] text-[var(--gold-light)] text-base mb-4 text-center uppercase tracking-wider">Final Stats</h2>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <span class="block font-['Cinzel'] text-2xl font-bold {{ $game->honor <= 0 ? 'text-[var(--ember)]' : 'text-[#4A90D9]' }}">{{ $game->honor }}</span>
                    <span class="text-sm text-[var(--mist)] uppercase tracking-wider">Honor</span>
                </div>
                <div>
                    <span class="block font-['Cinzel'] text-2xl font-bold text-[#9B59B6]">{{ $game->power }}</span>
                    <span class="text-sm text-[var(--mist)] uppercase tracking-wider">Power</span>
                </div>
                <div>
                    <span class="block font-['Cinzel'] text-2xl font-bold {{ $game->debt >= 100 ? 'text-[var(--ember)]' : 'text-[#E74C3C]' }}">{{ $game->debt }}</span>
                    <span class="text-sm text-[var(--mist)] uppercase tracking-wider">Debt</span>
                </div>
            </div>
            <div class="mt-4 text-center">
                @if($game->run)
                    <span class="font-['Cinzel'] text-lg font-semibold {{ $game->run->is_victory ? 'text-green-500' : 'text-[var(--ember)]' }}">
                        {{ $game->run->is_victory ? 'Victory' : 'Defeat' }}
                    </span>
                    <span class="text-[var(--mist)] ml-2">- {{ $game->run->steps_taken }} steps taken</span>
                @else
                    <span class="font-['Cinzel'] text-lg text-[var(--mist)]">Game Over</span>
                @endif
            </div>
        </div>

        <!-- Unlocked House -->
        @if($unlockedHouse)
            <div class="bg-[var(--gold)]/10 border border-[var(--gold)]/40 rounded-xl p-6 mb-6 text-center flex-shrink-0">
                <h2 class="font-['Cinzel'] text-xl font-bold text-[var(--gold-light)] mb-2">New House Unlocked!</h2>
                <p class="text-[var(--parchment)]">You have unlocked <strong class="text-[var(--gold-light)]">{{ $unlockedHouse->name }}</strong> for future playthroughs!</p>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex gap-4 justify-center flex-shrink-0">
            <a href="{{ route('dashboard') }}" 
                class="bg-gradient-to-br from-[rgba(139,0,0,0.8)] to-[rgba(90,0,0,0.9)] border border-[rgba(139,0,0,0.6)] text-[#E8DCC8] font-['Cinzel'] text-xs tracking-[0.25em] uppercase px-8 py-3 rounded-sm hover:from-[rgba(168,0,0,0.9)] hover:to-[#780000] hover:shadow-[0_0_24px_rgba(139,0,0,0.5)] transition-all inline-block">
                Return to Dashboard
            </a>
        </div>
    </div>
</x-layouts.game>
