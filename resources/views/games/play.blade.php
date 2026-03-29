<x-layouts.game 
    :houseName="$game->house->name"
    :honor="$game->honor"
    :power="$game->power"
    :debt="$game->debt"
>
    <!-- Game Player Extra Decorations -->
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
        
        <!-- Risk Warning -->
        @if($currentMultiplier > 1.0)
            <div class="mb-6 p-3 rounded-lg border {{ $currentMultiplier > 1.5 ? 'bg-[var(--blood)]/10 border-[var(--blood)]/40' : 'bg-[var(--gold)]/10 border-[var(--gold)]/40' }}">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium {{ $currentMultiplier > 1.5 ? 'text-[var(--ember)]' : 'text-[var(--gold-light)]' }}">
                        Predicted Risk: {{ $riskLevel }}
                    </span>
                    <span class="text-xs {{ $currentMultiplier > 1.5 ? 'text-[var(--ember)]' : 'text-[var(--gold-light)]' }}">
                        Debt multiplier: {{ $currentMultiplier }}x
                    </span>
                </div>
            </div>
        @endif

        <!-- Debt Warning -->
        @if($game->currentNode->debt_warning_text && $game->currentNode->debt_warning_threshold && $game->debt >= $game->currentNode->debt_warning_threshold)
            <div class="mb-6 bg-[var(--gold)]/10 border-l-4 border-[var(--gold)] p-4 rounded-r-lg">
                <p class="text-sm font-medium text-[var(--parchment)]">{{ $game->currentNode->debt_warning_text }}</p>
            </div>
        @endif

        <!-- Narrative Card -->
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
                    <img src="{{ asset('storage/' . $game->currentNode->art_image_path) }}" alt="Scene" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--bark)]/80 to-transparent"></div>
                </div>
            @endif

            <div class="p-4 sm:p-6 flex-1 min-h-0 overflow-auto">
                <!-- Chapter Label -->
                @if($game->currentNode->chapter_label)
                    <div class="flex items-center gap-3 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--mist)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm uppercase tracking-[0.2em] text-[var(--gold-light)]">{{ $game->currentNode->chapter_label }}</span>
                    </div>
                @endif

                <!-- Scene Title -->
                <h1 class="font-['Cinzel'] text-xl sm:text-2xl font-bold text-[var(--bone)] mb-4 leading-tight">
                    {{ $game->currentNode->title }}
                </h1>

                <!-- Narrative Text -->
                <div class="prose prose-invert max-w-none">
                    <p class="whitespace-pre-wrap text-[var(--parchment)] leading-relaxed text-base sm:text-lg">{{ $game->currentNode->narrative_text }}</p>
                </div>
            </div>
        </div>

        <!-- Choices Section -->
        <div class="relative flex-shrink-0">
            <!-- Section decorative header -->
            <div class="absolute -left-2 top-0 bottom-0 w-1 bg-gradient-to-b from-[var(--gold)]/60 via-[var(--gold)]/20 to-transparent rounded-full"></div>
            <h2 class="font-['Cinzel'] text-base sm:text-lg text-[var(--gold-light)] mb-4 flex items-center gap-3 pl-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                What do you do?
                <span class="flex-1 h-px bg-gradient-to-r from-[var(--gold)]/40 to-transparent"></span>
            </h2>

            <div class="space-y-3">
                @foreach($availableChoices as $choice)
                    <form action="{{ route('games.choice', [$game, $choice]) }}" method="POST">
                        @csrf
                        <button type="submit" 
                            class="w-full text-left p-3 sm:p-4 rounded-lg border border-[var(--gold)]/30 bg-[var(--ash)]/50 hover:border-[var(--gold)]/60 hover:bg-[var(--bark)]/70 hover:shadow-[0_0_20px_rgba(184,134,11,0.15)] transition-all duration-300 group">
                            
                            <!-- Choice Text -->
                            <p class="font-['Cinzel'] font-semibold text-[var(--bone)] text-base sm:text-lg mb-2 group-hover:text-[var(--gold-light)] transition-colors">
                                {{ $choice->getDynamicText($game) }}
                            </p>

                            <!-- Hint Text -->
                            @if($choice->hint_text)
                                <p class="text-xs sm:text-sm text-[var(--mist)] mb-2 italic">{{ $choice->hint_text }}</p>
                            @endif

                            <!-- Stat Changes -->
                            <div class="flex flex-wrap gap-2">
                                @if($choice->honor_delta)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:py-1 rounded text-xs font-medium {{ $choice->honor_delta > 0 ? 'bg-[#4A90D9]/20 text-[#4A90D9] border border-[#4A90D9]/30' : 'bg-[var(--blood)]/20 text-[var(--ember)] border border-[var(--blood)]/30' }}">
                                        @if($choice->honor_delta > 0)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                        @endif
                                        Honor {{ $choice->honor_delta > 0 ? '+' : '' }}{{ $choice->honor_delta }}
                                    </span>
                                @endif

                                @if($choice->power_delta)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:py-1 rounded text-xs font-medium {{ $choice->power_delta > 0 ? 'bg-[#9B59B6]/20 text-[#9B59B6] border border-[#9B59B6]/30' : 'bg-[var(--blood)]/20 text-[var(--ember)] border border-[var(--blood)]/30' }}">
                                        @if($choice->power_delta > 0)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                        @endif
                                        Power {{ $choice->power_delta > 0 ? '+' : '' }}{{ $choice->power_delta }}
                                    </span>
                                @endif

                                @if($choice->debt_delta)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium bg-[var(--blood)]/20 text-[var(--ember)] border border-[var(--blood)]/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Debt +{{ $choice->debt_delta }}
                                    </span>
                                @endif
                            </div>
                        </button>
                    </form>
                @endforeach

                <!-- Locked Choices -->
                @php
                    $lockedChoices = $game->currentNode->choices
                        ->filter(fn($choice) => !$availableChoices->contains($choice))
                        ->filter(fn($choice) => !$choice->meetsRequirements($game));
                @endphp

                @if($lockedChoices->isNotEmpty())
                    <div class="mt-10 pt-8 border-t border-[var(--gold)]/10 relative">
                        <!-- Decorative divider -->
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 px-4 bg-[var(--coal)]">
                            <div class="w-2 h-2 rotate-45 border border-[var(--mist)]/30"></div>
                        </div>
                        <h3 class="text-sm font-medium text-[var(--mist)] mb-4 uppercase tracking-wider flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Unavailable Choices
                        </h3>
                        <div class="space-y-3">
                            @foreach($lockedChoices as $choice)
                                <div class="w-full text-left p-4 rounded-lg border border-[var(--mist)]/30 bg-[var(--coal)]/50 opacity-50 cursor-not-allowed">
                                    <p class="font-medium text-[var(--mist)]">{{ $choice->getDynamicText($game) }}</p>
                                    @php
                                        $requirements = $choice->getRequirements();
                                    @endphp
                                    @if($requirements)
                                        <p class="text-xs text-[var(--mist)]/70 mt-2">
                                            @if(isset($requirements['min_honor']) && $game->honor < $requirements['min_honor'])
                                                Requires {{ $requirements['min_honor'] }} Honor (you have {{ $game->honor }})
                                            @elseif(isset($requirements['min_power']) && $game->power < $requirements['min_power'])
                                                Requires {{ $requirements['min_power'] }} Power (you have {{ $game->power }})
                                            @elseif(isset($requirements['required_flag']))
                                                Requires a previous choice
                                            @elseif(isset($requirements['forbidden_flag']))
                                                Not available due to previous choice
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($availableChoices->isEmpty() && $lockedChoices->isEmpty())
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-[var(--mist)] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-[var(--mist)] mb-6">No available choices. The story has ended.</p>
                        <a href="{{ route('games.end', $game) }}" 
                            class="inline-block px-6 py-3 rounded-lg bg-[var(--blood)] hover:bg-[var(--ember)] text-[var(--bone)] font-['Cinzel'] font-semibold transition-all duration-300 hover:shadow-[0_0_20px_rgba(139,0,0,0.5)]">
                            See Ending
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.game>
