<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} — The Weirwood Decision Simulator</title>
    <meta name="description" content="A branching narrative where every choice has a price and every debt compounds. Enter the tree.">
    
    {{-- Google Fonts: Cinzel & Crimson Text (Updated weights per your CSS) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;900&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
    {{-- Alpine.js for scroll animations --}}
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

        /* Noise Texture Overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1000;
            opacity: 0.4;
        }

        /* Pulse Glow for Hero Tree */
        @keyframes pulse-glow {
            0%, 100% { filter: drop-shadow(0 0 12px rgba(139,0,0,0.6)); }
            50% { filter: drop-shadow(0 0 28px rgba(139,0,0,0.9)) drop-shadow(0 0 50px rgba(139,0,0,0.3)); }
        }
        .animate-pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }
    </style>
</head>

{{-- Applying Base Colors and Radial Gradients to Body --}}
<body class="bg-[var(--coal)] text-[var(--bone)] font-['Crimson_Text'] text-[18px] antialiased min-h-screen overflow-x-hidden"
      style="background: radial-gradient(ellipse 60% 80% at 50% 0%, rgba(139,0,0,0.18) 0%, transparent 70%), radial-gradient(ellipse 40% 40% at 20% 100%, rgba(184,134,11,0.1) 0%, transparent 60%), var(--coal);">

    <main>

        {{-- ── HERO ── --}}
        {{-- Appbar and top padding removed so this centers perfectly --}}
        <section class="min-h-screen flex flex-col items-center justify-center text-center px-6 relative"
            x-data="{ visible: false }"
            x-init="setTimeout(() => visible = true, 100)">

            <div class="mb-8 transition duration-700"
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                
                {{-- Updated Detailed SVG Sigil --}}
                <svg class="w-[120px] h-[120px] mx-auto animate-pulse-glow" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
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
            </div>

            <div class="transition duration-700 delay-150"
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                <h1 class="font-['Cinzel'] font-black text-[clamp(2.8rem,7vw,5.5rem)] text-[var(--bone)] leading-none tracking-wide mb-2 drop-shadow-[0_0_30px_rgba(139,0,0,0.5)]">
                    THE<br>WEIRWOOD
                </h1>
                <p class="font-['Cinzel'] text-[clamp(0.75rem,2vw,1rem)] tracking-[0.35em] text-[var(--gold)] uppercase mb-10">
                    Decision Simulator
                </p>
                <p class="text-[1.2rem] text-[var(--mist)] italic max-w-[520px] mx-auto mb-14 leading-relaxed">
                    "The tree remembers every choice. Every oath. Every betrayal.<br>
                    What you spend today, you shall repay in blood tomorrow."
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 transition duration-700 delay-300 w-full"
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                <a href="{{ route('register') }}"
                    class="bg-gradient-to-br from-[rgba(139,0,0,0.8)] to-[rgba(90,0,0,0.9)] border border-[rgba(139,0,0,0.6)] text-[var(--bone)] font-['Cinzel'] text-xs tracking-[0.25em] uppercase px-10 py-4 rounded-sm hover:from-[rgba(168,0,0,0.9)] hover:to-[#780000] hover:shadow-[0_0_24px_rgba(139,0,0,0.5)] hover:-translate-y-0.5 transition-all w-full sm:w-auto text-center">
                    Begin Your Fate
                </a>
                <a href="{{ route('login') }}"
                    class="bg-transparent border border-[rgba(107,90,78,0.4)] text-[var(--mist)] font-['Cinzel'] text-xs tracking-[0.2em] uppercase px-10 py-4 rounded-sm hover:border-[rgba(184,134,11,0.5)] hover:text-[var(--gold)] transition-all w-full sm:w-auto text-center">
                    Sign In
                </a>
            </div>

            <div class="mt-20 flex items-center justify-center gap-4 w-full max-w-[400px] transition duration-1000 delay-700"
                :class="visible ? 'opacity-100' : 'opacity-0'">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[rgba(184,134,11,0.4)] to-transparent"></div>
                <span class="text-[var(--gold)] text-lg">✦</span>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[rgba(184,134,11,0.4)] to-transparent"></div>
            </div>
        </section>

        {{-- ── ENTRY POINTS ── --}}
        <section class="py-24 px-6 border-t border-[var(--bark)]/30" id="entry">
            <div class="max-w-5xl mx-auto">

                <div class="text-center mb-14">
                    <p class="font-['Cinzel'] text-[0.7rem] tracking-[0.4em] text-[var(--gold)] uppercase mb-3">Three Gates</p>
                    <h2 class="font-['Cinzel'] text-[clamp(1.8rem,4vw,2.8rem)] font-semibold text-[var(--bone)] leading-tight">How Will You Enter?</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    @foreach([
                        [
                            'icon'  => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            'title' => 'House Quiz',
                            'body'  => 'Answer five questions. The tree assigns your House and opens your starting path.',
                        ],
                        [
                            'icon'  => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
                            'title' => 'Kingdom Map',
                            'body'  => 'Choose your region. Every hold carries different starting Honor and Power.',
                        ],
                        [
                            'icon'  => 'M13 10V3L4 14h7v7l9-11h-7z',
                            'title' => 'Enter Blindly',
                            'body'  => 'No house. No allegiance. Walk into the dark and see what the tree offers.',
                        ],
                    ] as $card)
                        {{-- Bark-to-Coal Gradient Card --}}
                        <div class="bg-gradient-to-br from-[rgba(61,43,31,0.9)] to-[rgba(26,21,18,0.95)] border border-[rgba(184,134,11,0.25)] hover:border-[rgba(184,134,11,0.6)] hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.6),0_0_20px_rgba(139,0,0,0.2)] rounded-sm p-8 flex flex-col transition-all duration-300 relative overflow-hidden group">
                            
                            {{-- Hover Blood Glow --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-[rgba(139,0,0,0.08)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            {{-- Title Top --}}
                            <h3 class="font-['Cinzel'] text-[0.85rem] tracking-[0.2em] text-[var(--gold)] uppercase mb-5 relative z-10">{{ $card['title'] }}</h3>
                            
                            {{-- SVG Icon (Larger & Gold) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-[var(--gold)] mb-6 relative z-10 group-hover:text-[var(--gold-light)] group-hover:scale-110 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="{{ $card['icon'] }}"/>
                 </svg>
                            
                            {{-- Body --}}
                            <p class="text-[0.95rem] text-[var(--mist)] leading-relaxed flex-1 relative z-10">{{ $card['body'] }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

    </main>

    <footer class="border-t border-[var(--bark)]/30 py-8 px-6 bg-[rgba(26,21,18,0.4)]">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="font-['Cinzel'] text-[0.6rem] tracking-[0.3em] uppercase text-[rgba(107,90,78,0.4)]">
                {{ config('app.name') }} v0.1 — Prototype Build
            </span>
        </div>
    </footer>

</body>
</html>