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
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-['Cinzel'] text-2xl font-bold text-[var(--bone)] tracking-wider">Choices</h1>
                <p class="text-[var(--mist)] mt-2 italic">Story branching options</p>
            </div>
            @can('create-houses')
                <a href="{{ route('choices.create') }}" 
                    class="bg-gradient-to-br from-[rgba(139,0,0,0.8)] to-[rgba(90,0,0,0.9)] border border-[rgba(139,0,0,0.6)] text-[#E8DCC8] font-['Cinzel'] text-xs tracking-[0.25em] uppercase px-6 py-3 rounded-sm hover:from-[rgba(168,0,0,0.9)] hover:to-[#780000] hover:shadow-[0_0_24px_rgba(139,0,0,0.5)] transition-all inline-block">
                    Add Choice
                </a>
            @endcan
        </div>

        <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--gold)]/20 overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-[var(--coal)]/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">From</th>
                        <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">To</th>
                        <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">Text</th>
                        <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">Order</th>
                        <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">Stats</th>
                        <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--gold)]/10">
                    @foreach ($choices as $choice)
                        <tr class="hover:bg-[var(--gold)]/5 transition-colors">
                            <td class="px-6 py-4 text-sm text-[var(--parchment)]">{{ $choice->fromNode->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-[var(--parchment)]">{{ $choice->toNode->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-[var(--bone)]">{{ Str::limit($choice->choice_text, 40) }}</td>
                            <td class="px-6 py-4 text-sm text-[var(--mist)]">{{ $choice->display_order }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($choice->honor_delta)<span class="{{ $choice->honor_delta > 0 ? 'text-[#4A90D9]' : 'text-[var(--ember)]' }}">H: {{ $choice->honor_delta }}</span>@endif
                                @if($choice->power_delta)<span class="{{ $choice->power_delta > 0 ? 'text-[#9B59B6]' : 'text-[var(--ember)]' }}">P: {{ $choice->power_delta }}</span>@endif
                                @if($choice->debt_delta)<span class="text-[#E74C3C]">D: +{{ $choice->debt_delta }}</span>@endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('choices.show', $choice) }}" class="text-[var(--gold-light)] hover:text-[var(--gold)] text-sm font-medium transition-colors">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $choices->links() }}</div>
    </div>
</x-layouts.app>
