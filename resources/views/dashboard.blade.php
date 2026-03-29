<x-layouts.app>

    <div class="mb-10 mt-4">
        <h1 class="font-['Cinzel'] text-3xl font-bold text-[#E8DCC8] tracking-widest uppercase drop-shadow-[0_0_15px_rgba(139,0,0,0.3)]">The Weirwood</h1>
        <p class="font-['Crimson_Text'] text-[#6B5A4E] text-lg italic mt-2">"Welcome back, bastard of the realm."</p>
    </div>

    <div class="relative overflow-hidden bg-gradient-to-br from-[rgba(61,43,31,0.9)] to-[rgba(26,21,18,0.95)] border border-[rgba(139,0,0,0.5)] rounded-sm shadow-[0_8px_30px_rgba(0,0,0,0.6)] p-8 mb-10 group">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(139,0,0,0.15)] to-transparent pointer-events-none"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="font-['Cinzel'] text-2xl font-bold text-[#B8860B] tracking-[0.15em] uppercase mb-2">Begin Your Journey</h2>
                <p class="font-['Crimson_Text'] text-[#F5EDD8] text-[1.1rem] italic mb-6">The Iron Bank is calling. Will you answer?</p>
                <a href="{{ route('games.create') }}" 
                   class="bg-gradient-to-br from-[rgba(139,0,0,0.8)] to-[rgba(90,0,0,0.9)] border border-[rgba(139,0,0,0.6)] text-[#E8DCC8] font-['Cinzel'] text-xs tracking-[0.25em] uppercase px-8 py-3 rounded-sm hover:from-[rgba(168,0,0,0.9)] hover:to-[#780000] hover:shadow-[0_0_24px_rgba(139,0,0,0.5)] transition-all inline-block">
                    Start New Game
                </a>
            </div>
            <div class="hidden md:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-28 w-28 text-[#8B0000] opacity-40 group-hover:scale-105 group-hover:opacity-60 transition-all duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <div class="bg-gradient-to-br from-[rgba(61,43,31,0.5)] to-[rgba(26,21,18,0.8)] border border-[rgba(184,134,11,0.2)] rounded-sm p-6 flex items-center justify-between shadow-lg">
            <div>
                <p class="font-['Cinzel'] text-[0.65rem] font-bold tracking-[0.2em] text-[#6B5A4E] uppercase mb-1">Runs Completed</p>
                <p class="font-['Cinzel'] text-3xl font-bold text-[#E8DCC8] drop-shadow-md">{{ $totalRuns ?? 0 }}</p>
            </div>
            <div class="text-[#B8860B] opacity-80">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[rgba(61,43,31,0.5)] to-[rgba(26,21,18,0.8)] border border-[rgba(184,134,11,0.2)] rounded-sm p-6 flex items-center justify-between shadow-lg">
            <div>
                <p class="font-['Cinzel'] text-[0.65rem] font-bold tracking-[0.2em] text-[#6B5A4E] uppercase mb-1">Houses Unlocked</p>
                <p class="font-['Cinzel'] text-3xl font-bold text-[#E8DCC8] drop-shadow-md">{{ $unlockedHouses ?? 0 }} / 9</p>
            </div>
            <div class="text-[#B8860B] opacity-80">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[rgba(61,43,31,0.5)] to-[rgba(26,21,18,0.8)] border border-[rgba(184,134,11,0.2)] rounded-sm p-6 flex items-center justify-between shadow-lg">
            <div>
                <p class="font-['Cinzel'] text-[0.65rem] font-bold tracking-[0.2em] text-[#6B5A4E] uppercase mb-1">Endings Discovered</p>
                <p class="font-['Cinzel'] text-3xl font-bold text-[#E8DCC8] drop-shadow-md">{{ $discoveredEndings ?? 0 }} / 13</p>
            </div>
            <div class="text-[#B8860B] opacity-80">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-12">
        
        <a href="{{ route('runs.index') }}" class="bg-gradient-to-br from-[rgba(61,43,31,0.4)] to-[rgba(26,21,18,0.7)] border border-[rgba(107,90,78,0.3)] rounded-sm p-6 hover:border-[rgba(184,134,11,0.6)] hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(0,0,0,0.5)] transition-all group">
            <div class="flex items-center">
                <div class="mr-5 text-[#6B5A4E] group-hover:text-[#C0392B] transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-['Cinzel'] text-[0.85rem] font-bold tracking-[0.15em] text-[#E8DCC8] uppercase group-hover:text-[#B8860B] transition-colors">Run History</h3>
                    <p class="font-['Crimson_Text'] text-[1rem] text-[#6B5A4E] italic mt-1 group-hover:text-[#F5EDD8] transition-colors">View your past playthroughs</p>
                </div>
            </div>
        </a>

        <a href="{{ route('houses.index') }}" class="bg-gradient-to-br from-[rgba(61,43,31,0.4)] to-[rgba(26,21,18,0.7)] border border-[rgba(107,90,78,0.3)] rounded-sm p-6 hover:border-[rgba(184,134,11,0.6)] hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(0,0,0,0.5)] transition-all group">
            <div class="flex items-center">
                <div class="mr-5 text-[#6B5A4E] group-hover:text-[#C0392B] transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-['Cinzel'] text-[0.85rem] font-bold tracking-[0.15em] text-[#E8DCC8] uppercase group-hover:text-[#B8860B] transition-colors">Houses</h3>
                    <p class="font-['Crimson_Text'] text-[1rem] text-[#6B5A4E] italic mt-1 group-hover:text-[#F5EDD8] transition-colors">View unlocked houses</p>
                </div>
            </div>
        </a>

        <a href="{{ route('endings.index') }}" class="bg-gradient-to-br from-[rgba(61,43,31,0.4)] to-[rgba(26,21,18,0.7)] border border-[rgba(107,90,78,0.3)] rounded-sm p-6 hover:border-[rgba(184,134,11,0.6)] hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(0,0,0,0.5)] transition-all group">
            <div class="flex items-center">
                <div class="mr-5 text-[#6B5A4E] group-hover:text-[#C0392B] transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-['Cinzel'] text-[0.85rem] font-bold tracking-[0.15em] text-[#E8DCC8] uppercase group-hover:text-[#B8860B] transition-colors">Endings</h3>
                    <p class="font-['Crimson_Text'] text-[1rem] text-[#6B5A4E] italic mt-1 group-hover:text-[#F5EDD8] transition-colors">View discovered endings</p>
                </div>
            </div>
        </a>

        @if(Auth::user()?->is_admin)
        <a href="{{ route('nodes.index') }}" class="bg-gradient-to-br from-[rgba(61,43,31,0.4)] to-[rgba(26,21,18,0.7)] border border-[rgba(107,90,78,0.3)] rounded-sm p-6 hover:border-[rgba(139,0,0,0.6)] hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(139,0,0,0.3)] transition-all group">
            <div class="flex items-center">
                <div class="mr-5 text-[#6B5A4E] group-hover:text-[#8B0000] transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-['Cinzel'] text-[0.85rem] font-bold tracking-[0.15em] text-[#E8DCC8] uppercase group-hover:text-[#8B0000] transition-colors">Admin Panel</h3>
                    <p class="font-['Crimson_Text'] text-[1rem] text-[#6B5A4E] italic mt-1 group-hover:text-[#F5EDD8] transition-colors">Manage game content</p>
                </div>
            </div>
        </a>
        @endif
        
    </div>

</x-layouts.app>