<x-layouts.app>
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('runs.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                ← Back to Run History
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-6">
            <div class="text-center mb-6">
                <span class="text-sm text-gray-500 dark:text-gray-400 uppercase">Run Complete</span>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-2">
                    {{ $run->house->name ?? 'Unknown House' }}
                </h1>
                <div class="mt-2">
                    @if($run->is_victory)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Victory
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Defeat
                        </span>
                    @endif
                    <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $run->steps_taken }} steps</span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 text-center mb-6">
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <span class="block text-2xl font-bold {{ $run->final_honor <= 0 ? 'text-red-600' : 'text-gray-800 dark:text-gray-100' }}">{{ $run->final_honor }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Honor</span>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <span class="block text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $run->final_power }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Power</span>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <span class="block text-2xl font-bold {{ $run->final_debt >= 100 ? 'text-red-600' : 'text-gray-800 dark:text-gray-100' }}">{{ $run->final_debt }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Debt</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Journey Log</h2>
            
            @if($run->game && $run->game->gameSteps->isNotEmpty())
                <div class="space-y-4">
                    @foreach($run->game->gameSteps as $index => $step)
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center text-red-600 dark:text-red-300 font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800 dark:text-gray-100">{{ $step->choice->choice_text ?? 'Unknown choice' }}</p>
                                <div class="flex gap-3 mt-1 text-sm">
                                    <span class="{{ $step->honor_after > $step->honor_before ? 'text-green-600' : ($step->honor_after < $step->honor_before ? 'text-red-600' : 'text-gray-500') }}">
                                        H: {{ $step->honor_before }} → {{ $step->honor_after }}
                                    </span>
                                    <span class="{{ $step->power_after > $step->power_before ? 'text-green-600' : ($step->power_after < $step->power_before ? 'text-red-600' : 'text-gray-500') }}">
                                        P: {{ $step->power_before }} → {{ $step->power_after }}
                                    </span>
                                    <span class="{{ $step->debt_after > $step->debt_before ? 'text-red-600' : ($step->debt_after < $step->debt_before ? 'text-green-600' : 'text-gray-500') }}">
                                        D: {{ $step->debt_before }} → {{ $step->debt_after }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No journey data available.</p>
            @endif
        </div>
    </div>
</x-layouts.app>
