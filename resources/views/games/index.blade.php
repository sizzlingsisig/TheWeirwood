<x-layouts.app>
    <div class="max-w-4xl mx-auto py-4">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition text-sm">
                ← Back to Dashboard
            </a>
        </div>

        <div class="rounded-xl p-6">
            <h1 class="text-2xl font-['Cinzel'] font-bold text-white mb-6">Your Games</h1>

            <!-- Active Games -->
            @if($activeGames->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-lg font-['Cinzel'] text-amber-400 mb-4">Active Games</h2>
                    <div class="space-y-3">
                        @foreach($activeGames as $game)
                            <a href="{{ route('games.play', $game) }}" 
                                class="block p-4 rounded-lg border border-[rgba(184,134,11,0.3)] bg-gradient-to-br from-[rgba(61,43,31,0.6)] to-[rgba(26,21,18,0.9)] hover:border-amber-400 hover:shadow-[0_0_15px_rgba(218,165,32,0.3)] transition-all duration-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-['Cinzel'] font-semibold text-white">{{ $game->house->name }}</span>
                                        <p class="text-xs text-gray-400 mt-1">Chapter: {{ $game->currentNode->chapter_label ?? 'Unknown' }}</p>
                                    </div>
                                    <div class="text-right text-sm">
                                        <div class="flex gap-3">
                                            <span class="text-red-400">{{ $game->honor }}</span>
                                            <span class="text-amber-400">{{ $game->power }}</span>
                                            <span class="text-purple-400">{{ $game->debt }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Completed Games -->
            @if($completedGames->isNotEmpty())
                <div>
                    <h2 class="text-lg font-['Cinzel'] text-amber-400 mb-4">Completed Games</h2>
                    <div class="space-y-3">
                        @foreach($completedGames as $game)
                            <div class="block p-4 rounded-lg border border-[rgba(184,134,11,0.2)] bg-[rgba(26,21,18,0.5)] opacity-75">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-['Cinzel'] font-semibold text-white">{{ $game->house->name }}</span>
                                        <span class="ml-2 text-xs px-2 py-0.5 rounded {{ $game->run?->is_victory ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                            {{ $game->run?->is_victory ? 'Victory' : 'Ruin' }}
                                        </span>
                                    </div>
                                    <div class="text-right text-sm text-gray-400">
                                        {{ $game->run?->steps_taken ?? 0 }} steps
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($activeGames->isEmpty() && $completedGames->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-400 mb-4">No games yet. Start your first journey!</p>
                    <a href="{{ route('games.create') }}" class="inline-block px-6 py-3 bg-red-700 text-white rounded-lg font-['Cinzel'] font-semibold hover:bg-red-600 transition-all duration-200">
                        Begin Journey
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
