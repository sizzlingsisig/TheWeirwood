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
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1000;
            opacity: 0.4;
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
    </style>
</head>
<body class="bg-[var(--coal)] text-[var(--bone)] font-['Crimson_Text'] text-[18px] antialiased min-h-screen overflow-x-hidden relative"
      style="background: radial-gradient(ellipse 60% 80% at 50% 0%, rgba(139,0,0,0.18) 0%, transparent 70%), radial-gradient(ellipse 40% 40% at 20% 100%, rgba(184,134,11,0.1) 0%, transparent 60%), var(--coal);">
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
    <div class="fixed inset-0 pointer-events-none z-[5] breathing-glow" style="background: radial-gradient(ellipse 80% 60% at 50% 100%, rgba(139,0,0,0.2) 0%, transparent 60%);"></div>
    <div class="ember"></div>
    <div class="ember"></div>
    <div class="ember"></div>
    <div class="ember"></div>
    <div class="ember"></div>
    <div class="ember"></div>
    <div class="ember"></div>
    <div class="fixed inset-0 pointer-events-none z-[3]">
        <svg class="absolute top-8 left-8 w-16 h-16 opacity-20" viewBox="0 0 40 40" fill="none">
            <path d="M20 2L20 38M2 20L38 20M6 6L34 34M34 6L6 34" stroke="#B8860B" stroke-width="1" stroke-linecap="round"/>
            <circle cx="20" cy="20" r="8" stroke="#B8860B" stroke-width="1"/>
        </svg>
        <svg class="absolute top-8 right-8 w-16 h-16 opacity-20" viewBox="0 0 40 40" fill="none">
            <path d="M20 2L20 38M2 20L38 20M6 6L34 34M34 6L6 34" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
            <circle cx="20" cy="20" r="8" stroke="#8B0000" stroke-width="1"/>
        </svg>
        <svg class="absolute bottom-8 left-8 w-16 h-16 opacity-20" viewBox="0 0 40 40" fill="none">
            <path d="M20 2L20 38M2 20L38 20M6 6L34 34M34 6L6 34" stroke="#8B0000" stroke-width="1" stroke-linecap="round"/>
            <circle cx="20" cy="20" r="8" stroke="#8B0000" stroke-width="1"/>
        </svg>
        <svg class="absolute bottom-8 right-8 w-16 h-16 opacity-20" viewBox="0 0 40 40" fill="none">
            <path d="M20 2L20 38M2 20L38 20M6 6L34 34M34 6L6 34" stroke="#B8860B" stroke-width="1" stroke-linecap="round"/>
            <circle cx="20" cy="20" r="8" stroke="#B8860B" stroke-width="1"/>
        </svg>
    </div>
    <div class="relative z-10">
        {{ $slot }}
    </div>
</body>
</html>
