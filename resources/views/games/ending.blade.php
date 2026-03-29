<x-layouts.app>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow mb-6">
            @if($game->currentNode->art_image_path)
                <img src="{{ asset('storage/' . $game->currentNode->art_image_path) }}" alt="Ending" class="w-full max-h-64 object-cover rounded-t-lg">
            @endif
            
            <div class="p-6">
                <div class="text-center mb-6">
                    <span class="text-sm text-gray-500 uppercase">The End</span>
                    <h1 class="text-3xl font-bold">{{ $game->currentNode->title }}</h1>
                </div>

                <div class="prose max-w-none mb-6">
                    <p class="whitespace-pre-wrap">{{ $game->currentNode->narrative_text }}</p>
                </div>

                @if($game->currentNode->ending)
                    <div class="bg-gray-100 rounded-lg p-4 mb-6">
                        <p class="text-center font-semibold text-lg">{{ $game->currentNode->ending->verdict_label }}</p>
                        <p class="text-center text-sm text-gray-600">{{ ucfirst($game->currentNode->ending->ending_type) }} Ending</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Final Stats -->
        <div class="bg-white rounded-lg shadow mb-6 p-6">
            <h2 class="font-semibold mb-4">Final Stats</h2>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <span class="block text-2xl font-bold {{ $game->honor <= 0 ? 'text-red-600' : '' }}">{{ $game->honor }}</span>
                    <span class="text-sm text-gray-500">Honor</span>
                </div>
                <div>
                    <span class="block text-2xl font-bold">{{ $game->power }}</span>
                    <span class="text-sm text-gray-500">Power</span>
                </div>
                <div>
                    <span class="block text-2xl font-bold {{ $game->debt >= 100 ? 'text-red-600' : '' }}">{{ $game->debt }}</span>
                    <span class="text-sm text-gray-500">Debt</span>
                </div>
            </div>
            <div class="mt-4 text-center">
                @if($game->run)
                    <span class="text-lg font-semibold {{ $game->run->is_victory ? 'text-green-600' : 'text-red-600' }}">
                        {{ $game->run->is_victory ? 'Victory' : 'Defeat' }}
                    </span>
                    <span class="text-gray-500"> - {{ $game->run->steps_taken }} steps taken</span>
                @else
                    <span class="text-lg font-semibold text-gray-500">Game Over</span>
                @endif
            </div>
        </div>

        <!-- Unlocked House -->
        @if($unlockedHouse)
            <div class="bg-green-100 border border-green-500 rounded-lg p-6 mb-6 text-center">
                <h2 class="text-xl font-bold text-green-800 mb-2">New House Unlocked!</h2>
                <p class="text-green-700">You have unlocked <strong>{{ $unlockedHouse->name }}</strong> for future playthroughs!</p>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex gap-4 justify-center">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Return to Dashboard</a>
        </div>
    </div>
</x-layouts.app>
