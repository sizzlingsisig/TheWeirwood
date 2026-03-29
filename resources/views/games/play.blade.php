<x-layouts.app>
    <div class="max-w-4xl mx-auto">
        <!-- Stats Bar -->
        <div class="bg-white rounded-lg shadow mb-6 p-4">
            <div class="flex justify-between items-center">
                <div class="flex gap-6">
                    <div class="text-center">
                        <span class="block text-xs text-gray-500 uppercase">Honor</span>
                        <span class="text-xl font-bold {{ $game->honor < 20 ? 'text-red-600' : '' }}">{{ $game->honor }}</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-xs text-gray-500 uppercase">Power</span>
                        <span class="text-xl font-bold">{{ $game->power }}</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-xs text-gray-500 uppercase">Debt</span>
                        <span class="text-xl font-bold {{ $game->debt >= 60 ? 'text-red-600' : '' }}">{{ $game->debt }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-sm text-gray-500">{{ $game->house->name }}</span>
                </div>
            </div>
            
            <!-- Debt Warning -->
            @if($game->currentNode->debt_warning_text && $game->currentNode->debt_warning_threshold && $game->debt >= $game->currentNode->debt_warning_threshold)
                <div class="mt-3 bg-yellow-50 border-l-4 border-yellow-500 p-3">
                    <p class="text-sm font-medium text-yellow-800">{{ $game->currentNode->debt_warning_text }}</p>
                </div>
            @endif
        </div>

        <!-- Node Content -->
        <div class="bg-white rounded-lg shadow mb-6">
            @if($game->currentNode->art_image_path)
                <img src="{{ asset('storage/' . $game->currentNode->art_image_path) }}" alt="Scene" class="w-full max-h-64 object-cover rounded-t-lg">
            @endif
            
            <div class="p-6">
                @if($game->currentNode->chapter_label)
                    <span class="text-sm text-gray-500">{{ $game->currentNode->chapter_label }}</span>
                @endif
                <h1 class="text-2xl font-bold mb-4">{{ $game->currentNode->title }}</h1>
                <div class="prose max-w-none">
                    <p class="whitespace-pre-wrap">{{ $game->currentNode->narrative_text }}</p>
                </div>
            </div>
        </div>

        <!-- Choices -->
        @if($availableChoices->isNotEmpty())
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                    <h2 class="font-semibold">What do you do?</h2>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($availableChoices as $choice)
                        <form action="{{ route('games.choice', [$game, $choice]) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left p-4 rounded-lg border hover:bg-gray-50 transition">
                                <p class="font-medium">{{ $choice->choice_text }}</p>
                                @if($choice->hint_text)
                                    <p class="text-sm text-gray-500 mt-1">Hint: {{ $choice->hint_text }}</p>
                                @endif
                                <div class="flex gap-3 mt-2 text-xs text-gray-600">
                                    @if($choice->honor_delta)
                                        <span class="{{ $choice->honor_delta > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            Honor: {{ $choice->honor_delta > 0 ? '+' : '' }}{{ $choice->honor_delta }}
                                        </span>
                                    @endif
                                    @if($choice->power_delta)
                                        <span class="{{ $choice->power_delta > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            Power: {{ $choice->power_delta > 0 ? '+' : '' }}{{ $choice->power_delta }}
                                        </span>
                                    @endif
                                    @if($choice->debt_delta)
                                        <span class="text-red-600">
                                            Debt: +{{ $choice->debt_delta }}
                                        </span>
                                    @endif
                                </div>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">No available choices. The story has ended.</p>
                <a href="{{ route('games.end', $game) }}" class="btn btn-primary mt-4">See Ending</a>
            </div>
        @endif
    </div>
</x-layouts.app>
