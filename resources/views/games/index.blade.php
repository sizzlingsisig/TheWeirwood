<x-layouts.app>
    <h1 class="text-2xl font-bold mb-4">Your Games</h1>

    @if($activeGames->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Active Games</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($activeGames as $game)
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="font-bold">{{ $game->house->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $game->region?->name ?? 'No Region' }}</p>
                        <div class="mt-2 flex gap-2 text-sm">
                            <span>Honor: {{ $game->honor }}</span>
                            <span>Power: {{ $game->power }}</span>
                            <span>Debt: {{ $game->debt }}</span>
                        </div>
                        <a href="{{ route('games.play', $game) }}" class="btn btn-primary btn-sm mt-2">Continue</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Start New Game</h2>
        
        <form action="{{ route('games.start') }}" method="POST" class="bg-white rounded-lg shadow p-6 max-w-lg">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Select House</label>
                <select name="house_id" class="form-select w-full" required>
                    <option value="">Choose your house...</option>
                    @foreach(Auth::user()->houses as $house)
                        <option value="{{ $house->id }}">{{ $house->name }}</option>
                    @endforeach
                </select>
                @if(Auth::user()->houses->isEmpty())
                    <p class="text-sm text-red-500 mt-1">No houses unlocked. Complete endings to unlock houses!</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Entry Mode</label>
                <select name="entry_mode" class="form-select w-full" required>
                    <option value="commoner">Commoner (Standard)</option>
                    <option value="quiz">Quiz (Test your knowledge)</option>
                    <option value="map">Map (Choose your path)</option>
                    <option value="blind">Blind (Random start)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" {{ Auth::user()->houses->isEmpty() ? 'disabled' : '' }}>
                Start Game
            </button>
        </form>
    </div>

    @if($completedGames->isNotEmpty())
        <div>
            <h2 class="text-xl font-semibold mb-4">Completed Games</h2>
            <div class="space-y-2">
                @foreach($completedGames as $game)
                    <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold">{{ $game->house->name }}</h3>
                            <p class="text-sm text-gray-600">
                                {{ $game->run?->is_victory ? 'Victory' : 'Defeat' }} - 
                                {{ $game->run?->steps_taken ?? 0 }} steps
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm">H: {{ $game->honor }} | P: {{ $game->power }} | D: {{ $game->debt }}</p>
                            @if($game->run?->unlocked_house_id)
                                <p class="text-sm text-green-600">+House Unlocked!</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-layouts.app>
