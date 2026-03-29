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
                        <span class="text-xl font-bold {{ $game->power < 40 ? 'text-orange-600' : '' }}">{{ $game->power }}</span>
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

            <!-- Predicted Risk Indicator -->
            @if($currentMultiplier > 1.0)
                <div class="mt-3 p-2 rounded {{ $currentMultiplier > 1.5 ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium {{ $currentMultiplier > 1.5 ? 'text-red-700' : 'text-yellow-700' }}">
                            Predicted Risk: {{ $riskLevel }}
                        </span>
                        <span class="text-xs {{ $currentMultiplier > 1.5 ? 'text-red-600' : 'text-yellow-600' }}">
                            Debt multiplier: {{ $currentMultiplier }}x
                        </span>
                    </div>
                </div>
            @endif
            
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
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h2 class="font-semibold">What do you do?</h2>
            </div>
            <div class="p-4 space-y-3">
                @foreach($availableChoices as $choice)
                    <form action="{{ route('games.choice', [$game, $choice]) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left p-4 rounded-lg border hover:bg-gray-50 transition">
                            <p class="font-medium">{{ $choice->getDynamicText($game) }}</p>
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

                <!-- Locked Choices (requirements not met) -->
                @php
                    $lockedChoices = $game->currentNode->choices
                        ->filter(fn($choice) => !$availableChoices->contains($choice))
                        ->filter(fn($choice) => !$choice->meetsRequirements($game));
                @endphp
                @if($lockedChoices->isNotEmpty())
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Unavailable Choices</h3>
                        <div class="space-y-2">
                            @foreach($lockedChoices as $choice)
                                <div class="w-full text-left p-3 rounded-lg border border-gray-200 bg-gray-50 opacity-60 cursor-not-allowed">
                                    <p class="font-medium text-gray-500">{{ $choice->getDynamicText($game) }}</p>
                                    @php
                                        $requirements = $choice->getRequirements();
                                    @endphp
                                    @if($requirements)
                                        <p class="text-xs text-gray-400 mt-1">
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
                    <div class="text-center py-6">
                        <p class="text-gray-500">No available choices. The story has ended.</p>
                        <a href="{{ route('games.end', $game) }}" class="btn btn-primary mt-4">See Ending</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
