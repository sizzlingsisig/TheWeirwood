<x-layouts.app>
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                ← Back to Dashboard
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">Begin Your Journey</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Choose how you will enter the game.</p>

            <form action="{{ route('games.start') }}" method="POST">
                @csrf

                <!-- Entry Mode Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Choose Your Path</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="entry_mode" value="map" class="peer sr-only" checked>
                            <div class="p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900 hover:border-gray-300 transition">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">Map</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Choose your house directly</p>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="entry_mode" value="quiz" class="peer sr-only">
                            <div class="p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900 hover:border-gray-300 transition">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">Quiz</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Let fate decide your house</p>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="entry_mode" value="blind" class="peer sr-only">
                            <div class="p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900 hover:border-gray-300 transition">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">Blind</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Random house selection</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- House Selection (for Map mode) -->
                <div class="mb-8" id="house-selection">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Select Your House</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($houses as $house)
                            <label class="cursor-pointer">
                                <input type="radio" name="house_id" value="{{ $house->id }}" class="peer sr-only" 
                                    {{ !$userHouses->contains($house->id) ? 'disabled' : '' }}>
                                <div class="p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900 hover:border-gray-300 transition {{ !$userHouses->contains($house->id) ? 'opacity-50' : '' }}">
                                    <div class="text-center">
                                        <span class="font-semibold text-gray-800 dark:text-gray-100 block">{{ $house->name }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block mt-1">
                                            H: {{ $house->starting_honor }} / P: {{ $house->starting_power }} / D: {{ $house->starting_debt }}
                                        </span>
                                        @if(!$userHouses->contains($house->id))
                                            <span class="text-xs text-red-500 block mt-1">🔒 Locked</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('house_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                        Begin Game
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
