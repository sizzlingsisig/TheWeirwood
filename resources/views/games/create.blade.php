<x-layouts.app x-data="{ entryMode: 'blind' }">
    <div class="max-w-4xl mx-auto py-4">
        <div class="mb-4">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition text-sm">
                ← Back to Dashboard
            </a>
        </div>

        <div class="rounded-xl p-6">
            <h1 class="text-2xl font-['Cinzel'] font-bold text-white mb-1">Begin Your Journey</h1>
            <p class="text-gray-400 text-sm mb-4">Choose how you will enter the tree.</p>

            <!-- Legend -->
            <div class="flex justify-center gap-6 mb-6 p-3 bg-gradient-to-br from-[rgba(61,43,31,0.4)] to-[rgba(26,21,18,0.7)] rounded-lg border border-[rgba(184,134,11,0.2)]">
                <div class="flex items-center gap-2">
                    <span class="text-amber-400 font-['Cinzel'] text-sm font-semibold">Power</span>
                    <span class="text-gray-500 text-xs">influence & strength</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-red-400 font-['Cinzel'] text-sm font-semibold">Honor</span>
                    <span class="text-gray-500 text-xs">reputation & morality</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-purple-400 font-['Cinzel'] text-sm font-semibold">Debt</span>
                    <span class="text-gray-500 text-xs">cost of choices</span>
                </div>
            </div>

            <form action="{{ route('games.start') }}" method="POST">
                @csrf

                <!-- Entry Mode Selection -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-amber-500 mb-2 tracking-wider uppercase">Choose Your Path</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="cursor-pointer group">
                            <input type="radio" name="entry_mode" value="map" class="peer sr-only" x-model="entryMode" {{ $userHouses->isEmpty() ? 'disabled' : '' }}>
                            <div class="p-3 rounded-lg border-2 border-[rgba(184,134,11,0.3)] bg-gradient-to-br from-[rgba(61,43,31,0.6)] to-[rgba(26,21,18,0.9)] peer-checked:border-amber-400 peer-checked:shadow-[0_0_15px_rgba(218,165,32,0.4)] peer-checked:bg-amber-500/15 hover:border-amber-400 hover:shadow-[0_0_10px_rgba(218,165,32,0.3)] hover:scale-[1.02] transition-all duration-200 {{ $userHouses->isEmpty() ? 'opacity-40' : '' }}">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-1 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    <span class="font-['Cinzel'] font-semibold text-white text-base">Map</span>
                                    <p class="text-xs text-gray-400 mt-1">
                                        @if($userHouses->isEmpty())
                                            🔒 Unlock houses
                                        @else
                                            Choose house
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer group">
                            <input type="radio" name="entry_mode" value="blind" class="peer sr-only" x-model="entryMode" checked>
                            <div class="p-3 rounded-lg border-2 border-[rgba(184,134,11,0.3)] bg-gradient-to-br from-[rgba(61,43,31,0.6)] to-[rgba(26,21,18,0.9)] peer-checked:border-amber-400 peer-checked:shadow-[0_0_15px_rgba(218,165,32,0.4)] peer-checked:bg-amber-500/15 hover:border-amber-400 hover:shadow-[0_0_10px_rgba(218,165,32,0.3)] hover:scale-[1.02] transition-all duration-200">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-1 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span class="font-['Cinzel'] font-semibold text-white text-base">Blind</span>
                                    <p class="text-xs text-gray-400 mt-1">Tree chooses</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- House Selection -->
                <div class="mb-4" id="house-selection" :class="entryMode === 'blind' ? 'opacity-40 pointer-events-none' : ''">
                    <label class="block text-xs font-semibold text-amber-500 mb-2 tracking-wider uppercase">Select Your House</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($houses as $house)
                            <label class="cursor-pointer group">
                                <input type="radio" name="house_id" value="{{ $house->id }}" class="peer sr-only" 
                                    :disabled="entryMode === 'blind'"
                                    {{ !$userHouses->contains($house->id) ? 'disabled' : '' }}>
                                <div class="p-3 rounded-lg border-2 border-[rgba(184,134,11,0.3)] bg-gradient-to-br from-[rgba(61,43,31,0.6)] to-[rgba(26,21,18,0.9)] peer-checked:border-amber-400 peer-checked:shadow-[0_0_15px_rgba(218,165,32,0.4)] peer-checked:bg-amber-500/15 hover:border-amber-400 hover:shadow-[0_0_10px_rgba(218,165,32,0.3)] hover:scale-[1.02] transition-all duration-200 {{ !$userHouses->contains($house->id) ? 'opacity-40' : '' }}">
                                    <div class="text-center">
                                        <span class="font-['Cinzel'] font-semibold text-white block text-sm">{{ $house->name }}</span>
                                        <div class="flex justify-center gap-2 mt-1 text-xs text-gray-400">
                                            <span class="text-red-400">{{ $house->starting_honor }}</span>
                                            <span class="text-amber-400">{{ $house->starting_power }}</span>
                                            <span class="text-purple-400">{{ $house->starting_debt }}</span>
                                        </div>
                                        @if(!$userHouses->contains($house->id))
                                            <span class="text-xs text-gray-500">🔒</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('house_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-red-700 text-white px-6 py-2 rounded-lg font-['Cinzel'] font-semibold hover:bg-red-600 transition-all duration-200">
                        Begin Game
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
