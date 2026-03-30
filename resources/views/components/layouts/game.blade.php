<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="A branching narrative where every choice has a price and every debt compounds. Enter the tree.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;900&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --blood: #8B0000;
            --ember: #C0392B;
            --gold: #B8860B;
            --gold-light: #DAA520;
            --bone: #E8DCC8;
            --parchment: #F5EDD8;
            --ash: #2A2520;
            --coal: #1A1512;
            --bark: #3D2B1F;
            --mist: #6B5A4E;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1000;
            opacity: 0.4;
        }
        @keyframes pulse-glow {
            0%, 100% { filter: drop-shadow(0 0 12px rgba(139,0,0,0.6)); }
            50% { filter: drop-shadow(0 0 28px rgba(139,0,0,0.9)) drop-shadow(0 0 50px rgba(139,0,0,0.3)); }
        }
        .animate-pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }
        @keyframes float-up {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { transform: translateY(-20vh) scale(1); opacity: 0; }
        }
        .ember {
            position: fixed;
            width: 4px;
            height: 4px;
            background: radial-gradient(circle, #C0392B 0%, #8B0000 50%, transparent 100%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 2;
            animation: float-up 8s linear infinite;
        }
        .ember:nth-child(1) { left: 10%; animation-delay: 0s; animation-duration: 7s; }
        .ember:nth-child(2) { left: 20%; animation-delay: 1s; animation-duration: 9s; }
        .ember:nth-child(3) { left: 35%; animation-delay: 2s; animation-duration: 6s; }
        .ember:nth-child(4) { left: 50%; animation-delay: 3s; animation-duration: 8s; }
        .ember:nth-child(5) { left: 65%; animation-delay: 0.5s; animation-duration: 7s; }
        .ember:nth-child(6) { left: 80%; animation-delay: 2.5s; animation-duration: 9s; }
        .ember:nth-child(7) { left: 90%; animation-delay: 1.5s; animation-duration: 6s; }
        @keyframes breathe {
            0%, 100% { opacity: 0.15; }
            50% { opacity: 0.25; }
        }
        .breathing-glow {
            animation: breathe 6s ease-in-out infinite;
        }
        .root-veins {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            opacity: 0.12;
        }
        .root-veins svg {
            position: absolute;
            width: 45%;
            height: 45%;
        }
        .root-veins .bottom-left {
            bottom: 0;
            left: 0;
            transform: scaleX(-1);
        }
        .root-veins .bottom-right {
            bottom: 0;
            right: 0;
            transform: scaleY(-1);
        }
        .root-veins .top-right {
            top: 0;
            right: 0;
            transform: scale(-1);
        }
    </style>

</head>

<body class="bg-[var(--coal)] text-[var(--bone)] font-['Crimson_Text'] text-[18px] antialiased min-h-screen overflow-x-hidden relative"
      style="background: radial-gradient(ellipse 60% 80% at 50% 0%, rgba(139,0,0,0.18) 0%, transparent 70%), radial-gradient(ellipse 40% 40% at 20% 100%, rgba(184,134,11,0.1) 0%, transparent 60%), var(--coal);"
      x-data="{
          navOpen: false,
          toggleNav() {
              this.navOpen = !this.navOpen;
          },
      }">

    <div class="min-h-screen flex flex-col relative">
        
        <!-- Root Veins Decorations -->
        <div class="root-veins">
            <svg class="bottom-left" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 200C30 180 60 160 80 140C100 120 110 100 120 80C130 60 140 40 150 20" stroke="#8B0000" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M80 140C90 130 100 125 110 115" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
                <path d="M110 115C120 105 130 95 140 85" stroke="#8B0000" stroke-width="0.8" stroke-linecap="round"/>
                <path d="M120 80C125 70 130 60 135 50" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
                <path d="M150 20C145 40 140 60 135 80" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
                <path d="M135 80C125 90 115 100 105 110" stroke="#8B0000" stroke-width="0.8" stroke-linecap="round"/>
                <path d="M40 200C50 180 65 165 85 150" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
                <path d="M85 150C95 140 105 130 115 120" stroke="#8B0000" stroke-width="0.8" stroke-linecap="round"/>
                <path d="M20 200C35 185 50 170 65 155" stroke="#8B0000" stroke-width="0.7" stroke-linecap="round"/>
                <path d="M160 60C150 70 145 85 140 100C135 115 130 130 125 145" stroke="#8B0000" stroke-width="0.6" stroke-linecap="round"/>
            </svg>
            <svg class="bottom-right" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 200C30 180 60 160 80 140C100 120 110 100 120 80C130 60 140 40 150 20" stroke="#8B0000" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M80 140C90 130 100 125 110 115" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
                <path d="M110 115C120 105 130 95 140 85" stroke="#8B0000" stroke-width="0.8" stroke-linecap="round"/>
                <path d="M120 80C125 70 130 60 135 50" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
                <path d="M150 20C145 40 140 60 135 80" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
                <path d="M135 80C125 90 115 100 105 110" stroke="#8B0000" stroke-width="0.8" stroke-linecap="round"/>
                <path d="M40 200C50 180 65 165 85 150" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
                <path d="M85 150C95 140 105 130 115 120" stroke="#8B0000" stroke-width="0.8" stroke-linecap="round"/>
                <path d="M20 200C35 185 50 170 65 155" stroke="#8B0000" stroke-width="0.7" stroke-linecap="round"/>
            </svg>
            <svg class="top-right" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M200 0C170 20 140 40 120 60C100 80 90 100 80 120C70 140 60 160 50 180" stroke="#B8860B" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M120 60C110 70 100 75 90 85" stroke="#B8860B" stroke-width="1" stroke-linecap="round"/>
                <path d="M90 85C80 95 70 105 60 115" stroke="#B8860B" stroke-width="0.8" stroke-linecap="round"/>
                <path d="M80 120C75 130 70 140 65 150" stroke="#B8860B" stroke-width="1" stroke-linecap="round"/>
                <path d="M50 180C55 160 60 140 65 120" stroke="#B8860B" stroke-width="1" stroke-linecap="round"/>
                <path d="M65 120C75 110 85 100 95 90" stroke="#B8860B" stroke-width="0.8" stroke-linecap="round"/>
                <path d="M160 200C150 180 135 165 115 150" stroke="#B8860B" stroke-width="1" stroke-linecap="round"/>
                <path d="M115 150C105 140 95 130 85 120" stroke="#B8860B" stroke-width="0.8" stroke-linecap="round"/>
                <path d="M180 200C165 185 150 170 135 155" stroke="#B8860B" stroke-width="0.7" stroke-linecap="round"/>
            </svg>
        </div>
        
        <!-- Breathing Glow -->
        <div class="fixed inset-0 pointer-events-none z-[5] breathing-glow" style="background: radial-gradient(ellipse 80% 60% at 50% 100%, rgba(139,0,0,0.2) 0%, transparent 60%);"></div>

        <!-- Top Navigation Bar - App Style with Game Elements -->
        <header class="bg-[#1A1512] shadow-sm z-20 border-b border-[rgba(107,90,78,0.3)] w-full">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 w-full">
                
                <!-- Left: Menu Button + Game Icon + Title -->
                <div class="flex items-center">
                    <button @click="toggleNav()"
                        class="p-2 rounded-md text-[#6B5A4E] hover:text-[#E8DCC8] focus:outline-none transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            The Weirwood
                        </span>
                    </a>
                    
                    <!-- House/Location - Game Specific -->
                    <div class="hidden md:flex items-center ml-6 pl-6 border-l border-[rgba(107,90,78,0.3)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--gold)] mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="text-sm text-[var(--mist)]">Playing:</span>
                        <span class="font-['Cinzel'] text-[var(--gold-light)] font-semibold text-sm ml-2">{{ $houseName ?? 'Unknown House' }}</span>
                    </div>
                </div>

                <!-- Center: Resource Stats (compact for mobile, expanded for desktop) -->
                <div class="flex items-center gap-3 sm:gap-5">
                    <!-- Honor -->
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-[var(--bark)] border border-[var(--gold)]/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 text-[#4A90D9]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="text-right hidden sm:block">
                            <span class="text-[10px] uppercase tracking-wider text-[var(--mist)]">Honor</span>
                            <p class="font-['Cinzel'] font-bold text-[#4A90D9] text-sm">{{ $honor ?? 0 }}</p>
                        </div>
                        <span class="sm:hidden font-['Cinzel'] font-bold text-[#4A90D9] text-sm">{{ $honor ?? 0 }}</span>
                    </div>

                    <!-- Power -->
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-[var(--bark)] border border-[var(--gold)]/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 text-[#9B59B6]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="text-right hidden sm:block">
                            <span class="text-[10px] uppercase tracking-wider text-[var(--mist)]">Power</span>
                            <p class="font-['Cinzel'] font-bold text-[#9B59B6] text-sm">{{ $power ?? 0 }}</p>
                        </div>
                        <span class="sm:hidden font-['Cinzel'] font-bold text-[#9B59B6] text-sm">{{ $power ?? 0 }}</span>
                    </div>

                    <!-- Debt -->
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-[var(--bark)] border border-[var(--gold)]/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 text-[#E74C3C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-right hidden sm:block">
                            <span class="text-[10px] uppercase tracking-wider text-[var(--mist)]">Debt</span>
                            <p class="font-['Cinzel'] font-bold text-[#E74C3C] text-sm">{{ $debt ?? 0 }}</p>
                        </div>
                        <span class="sm:hidden font-['Cinzel'] font-bold text-[#E74C3C] text-sm">{{ $debt ?? 0 }}</span>
                    </div>
                </div>

                <!-- Right: User Menu -->
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

        <!-- Main Content Area -->
        <main class="flex-1 relative z-10 overflow-auto">
            {{ $slot }}
        </main>

        <!-- Full Screen Navigation Overlay -->
        <div x-show="navOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="navOpen = false"
            class="fixed inset-0 z-50 bg-black/80"
            style="display: none;">
        </div>

        <!-- Full Screen Navigation Panel -->
        <div x-show="navOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center"
            @click.stop>
            
            <!-- Close Button -->
            <button @click="navOpen = false" class="absolute top-4 right-4 p-2 hover:bg-white/10 rounded-lg text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <nav class="w-full max-w-md px-4">
                <ul class="space-y-6 text-center">
                    <li>
                        <a href="{{ route('dashboard') }}" @click="navOpen = false" 
                            class="block py-3 text-3xl font-bold text-white hover:text-amber-300 transition-all duration-300 hover:scale-105 {{ request()->routeIs('dashboard') ? 'text-amber-400 drop-shadow-[0_0_15px_rgba(218,165,32,0.9)]' : '' }}">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('games.create') }}" @click="navOpen = false" 
                            class="block py-3 text-3xl font-bold text-white hover:text-amber-300 transition-all duration-300 hover:scale-105 {{ request()->routeIs('games.create') ? 'text-amber-400 drop-shadow-[0_0_15px_rgba(218,165,32,0.9)]' : '' }}">
                            Begin Journey
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('runs.index') }}" @click="navOpen = false" 
                            class="block py-3 text-3xl font-bold text-white hover:text-amber-300 transition-all duration-300 hover:scale-105 {{ request()->routeIs('runs.*') ? 'text-amber-400 drop-shadow-[0_0_15px_rgba(218,165,32,0.9)]' : '' }}">
                            Chronicle
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('houses.index') }}" @click="navOpen = false" 
                            class="block py-3 text-3xl font-bold text-white hover:text-amber-300 transition-all duration-300 hover:scale-105 {{ request()->routeIs('houses.*') ? 'text-amber-400 drop-shadow-[0_0_15px_rgba(218,165,32,0.9)]' : '' }}">
                            Hall of Houses
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('endings.index') }}" @click="navOpen = false" 
                            class="block py-3 text-3xl font-bold text-white hover:text-amber-300 transition-all duration-300 hover:scale-105 {{ request()->routeIs('endings.index') ? 'text-amber-400 drop-shadow-[0_0_15px_rgba(218,165,32,0.9)]' : '' }}">
                            Endings
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Ember particles -->
        <div class="ember"></div>
        <div class="ember"></div>
        <div class="ember"></div>
        <div class="ember"></div>
        <div class="ember"></div>
        <div class="ember"></div>
        <div class="ember"></div>
    </div>

</body>

</html>
