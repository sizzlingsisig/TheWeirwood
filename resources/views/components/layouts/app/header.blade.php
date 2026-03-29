<header class="bg-[#1A1512] shadow-sm z-20 border-b border-[rgba(107,90,78,0.3)] w-full">
    {{-- Removed max-w-7xl so it spans the full screen, pushed padding to edges --}}
    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="flex items-center">
            <button @click="$dispatch('toggle-nav')"
                class="p-2 rounded-md text-[#6B5A4E] hover:text-[#E8DCC8] focus:outline-none transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
            <a href="{{ route('dashboard') }}" class="ml-4 flex items-center gap-3 group">
                <svg class="w-8 h-8 group-hover:scale-105 transition-transform duration-300" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="58" stroke="rgba(139,0,0,0.3)" stroke-width="1"/>
                    <circle cx="60" cy="60" r="50" stroke="rgba(184,134,11,0.2)" stroke-width="0.5"/>
                    <rect x="57" y="40" width="6" height="36" fill="rgba(139,0,0,0.7)" rx="2"/>
                    <path d="M60 48 L40 28 M60 48 L50 25 M60 48 L80 28 M60 48 L70 25" stroke="rgba(139,0,0,0.7)" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M60 52 L35 40 M60 52 L85 40" stroke="rgba(139,0,0,0.5)" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M60 76 L38 96 M60 76 L48 98 M60 76 L82 96 M60 76 L72 98" stroke="rgba(139,0,0,0.5)" stroke-width="2" stroke-linecap="round"/>
                    <path d="M60 80 L32 88 M60 80 L88 88" stroke="rgba(139,0,0,0.35)" stroke-width="1.5" stroke-linecap="round"/>
                    <ellipse cx="60" cy="56" rx="4" ry="2.5" fill="rgba(139,0,0,0.8)"/>
                    <ellipse cx="60" cy="56" rx="1.5" ry="1.5" fill="rgba(200,50,50,1)"/>
                    <circle cx="47" cy="60" r="1.2" fill="rgba(139,0,0,0.6)"/>
                    <circle cx="73" cy="58" r="0.9" fill="rgba(139,0,0,0.5)"/>
                </svg>
                <span class="font-['Cinzel'] font-bold text-lg text-[#E8DCC8] tracking-widest uppercase hidden sm:block mt-1">
                    {{ config('app.name', 'The Weirwood') }}
                </span>
            </a>
        </div>

        <div class="flex items-center">
            
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center focus:outline-none group">
                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-sm border border-[rgba(107,90,78,0.4)] group-hover:border-[rgba(184,134,11,0.6)] transition-colors">
                        <span class="flex h-full w-full items-center justify-center bg-[rgba(26,21,18,0.8)] font-['Cinzel'] text-[#E8DCC8] text-xs">
                            @auth
                                {{ Auth::user()->initials() }}
                            @else
                                W
                            @endauth
                        </span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-[#6B5A4E] group-hover:text-[#B8860B] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-[#1A1512] rounded-sm shadow-[0_8px_25px_rgba(0,0,0,0.8)] py-1 z-50 border border-[rgba(107,90,78,0.3)]">
                    
                    <a href="{{ route('settings.profile.edit') }}"
                        class="block px-4 py-3 text-xs tracking-widest uppercase font-['Cinzel'] text-[#E8DCC8] hover:bg-[rgba(61,43,31,0.5)] hover:text-[#B8860B] transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </div>
                    </a>
                    
                    <div class="border-t border-[rgba(107,90,78,0.2)] my-1"></div>
                    
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-3 text-xs tracking-widest uppercase font-['Cinzel'] text-[#E74C3C] hover:bg-[rgba(139,0,0,0.15)] transition-colors">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>