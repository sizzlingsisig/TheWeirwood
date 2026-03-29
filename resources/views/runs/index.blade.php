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
        <div class="mb-8">
            <h1 class="font-['Cinzel'] text-2xl font-bold text-[var(--bone)] tracking-wider">Run History</h1>
            <p class="text-[var(--mist)] mt-2 italic">Chronicle of your past journeys</p>
        </div>

        @if($runs->isEmpty())
            <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--gold)]/20 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-[var(--mist)] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-[var(--mist)] mb-4">You haven't completed any runs yet.</p>
                <a href="{{ route('games.create') }}" class="text-[var(--gold-light)] hover:text-[var(--gold)] font-['Cinzel'] font-medium transition-colors">
                    Start Your First Journey →
                </a>
            </div>
        @else
            <div class="bg-[var(--bark)]/60 backdrop-blur-sm rounded-xl border border-[var(--gold)]/20 overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-[var(--coal)]/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">House</th>
                            <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">Final Stats</th>
                            <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">Verdict</th>
                            <th class="px-6 py-4 text-left text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-right text-xs font-['Cinzel'] font-semibold text-[var(--gold-light)] uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--gold)]/10">
                        @foreach($runs as $run)
                            <tr class="hover:bg-[var(--gold)]/5 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-['Cinzel'] font-medium text-[var(--bone)]">{{ $run->house->name ?? 'Unknown' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-4 text-sm">
                                        <span class="{{ $run->final_honor <= 0 ? 'text-[var(--ember)]' : 'text-[#4A90D9]' }}">H: {{ $run->final_honor }}</span>
                                        <span class="text-[#9B59B6]">P: {{ $run->final_power }}</span>
                                        <span class="{{ $run->final_debt >= 100 ? 'text-[var(--ember)]' : 'text-[#E74C3C]' }}">D: {{ $run->final_debt }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($run->is_victory)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900/50 text-green-400 border border-green-700/50">
                                            Victory
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[var(--blood)]/20 text-[var(--ember)] border border-[var(--blood)]/30">
                                            Defeat
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--mist)]">
                                    {{ $run->completed_at?->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('runs.show', $run) }}" class="text-[var(--gold-light)] hover:text-[var(--gold)] font-medium transition-colors">
                                        View Details →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
