<x-layouts.app>
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                ← Back to Dashboard
            </a>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Endings Catalogue</h1>
            <span class="text-gray-600 dark:text-gray-400">{{ count($discoveredEndingIds) }} / {{ $allEndings->count() }} Discovered</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($allEndings as $ending)
                @php
                    $isDiscovered = in_array($ending->node_id, $discoveredEndingIds);
                @endphp
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 {{ !$isDiscovered ? 'opacity-50' : '' }}">
                    @if(!$isDiscovered)
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">???</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Complete a run to discover</p>
                        </div>
                    @else
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">{{ $ending->ending_type }}</span>
                                @if($ending->unlockedHouse)
                                    <span class="text-xs text-green-600 dark:text-green-400">Unlocks: {{ $ending->unlockedHouse->name }}</span>
                                @endif
                            </div>
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-2">{{ $ending->verdict_label }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-4">{{ $ending->ending_text }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>
