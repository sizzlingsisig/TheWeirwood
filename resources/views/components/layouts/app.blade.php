<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script>
        window.setAppearance = function(appearance) {
            let setDark = () => document.documentElement.classList.add('dark')
            let setLight = () => document.documentElement.classList.remove('dark')
            let setButtons = (appearance) => {
                document.querySelectorAll('button[onclick^="setAppearance"]').forEach((button) => {
                    button.setAttribute('aria-pressed', String(appearance === button.value))
                })
            }
            if (appearance === 'system') {
                let media = window.matchMedia('(prefers-color-scheme: dark)')
                window.localStorage.removeItem('appearance')
                media.matches ? setDark() : setLight()
            } else if (appearance === 'dark') {
                window.localStorage.setItem('appearance', 'dark')
                setDark()
            } else if (appearance === 'light') {
                window.localStorage.setItem('appearance', 'light')
                setLight()
            }
            if (document.readyState === 'complete') {
                setButtons(appearance)
            } else {
                document.addEventListener("DOMContentLoaded", () => setButtons(appearance))
            }
        }
        window.setAppearance(
            "{{ auth()->user()->theme_preference ?? '' }}" || 
            window.localStorage.getItem('appearance') || 
            'system'
        )
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased" x-data="{
    sidebarOpen: false,
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
    },
}" @toggle-nav.window="toggleSidebar()">

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col relative">

        <x-layouts.app.header @click="toggleSidebar()" class="cursor-pointer" />

        <!-- Main Content Area -->
        <div class="flex flex-1 overflow-hidden">

            <!-- Main Content -->
            <main class="flex-1 overflow-auto bg-gray-100 dark:bg-gray-900 transition-all duration-300" :class="{ 'opacity-30': sidebarOpen }">
                <div class="p-6">
                    <!-- Success Message -->
                    @session('status')
                        <div x-data="{ showStatusMessage: true }" x-show="showStatusMessage"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="mb-6 bg-green-50 dark:bg-green-900 border-l-4 border-green-500 p-4 rounded-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500 dark:text-green-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700 dark:text-green-200">{{ session('status') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button @click="showStatusMessage = false"
                                            class="inline-flex rounded-md p-1.5 text-green-500 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <span class="sr-only">{{ __('Dismiss') }}</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endsession

                    {{ $slot }}

                </div>
            </main>
        </div>

        <!-- Full Screen Navigation Modal -->
        <div x-show="sidebarOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-50 bg-black/80"
            style="display: none;">
        </div>

        <!-- Full Screen Navigation Panel -->
        <div x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center"
            @click.stop>
            
            <!-- Close Button -->
            <button @click="sidebarOpen = false" class="absolute top-4 right-4 p-2 hover:bg-white/10 rounded-lg text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Navigation Links - Centered Column -->
            <nav class="w-full max-w-md px-4">
                <ul class="space-y-4 text-center">
                    <li>
                        <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="block py-4 text-2xl font-semibold text-white hover:text-red-400 transition {{ request()->routeIs('dashboard') ? 'text-red-400' : '' }}">
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('games.create') }}" @click="sidebarOpen = false" class="block py-4 text-2xl font-semibold text-white hover:text-red-400 transition {{ request()->routeIs('games.create') ? 'text-red-400' : '' }}">
                            Play
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('runs.index') }}" @click="sidebarOpen = false" class="block py-4 text-2xl font-semibold text-white hover:text-red-400 transition {{ request()->routeIs('runs.*') ? 'text-red-400' : '' }}">
                            Run History
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('houses.index') }}" @click="sidebarOpen = false" class="block py-4 text-2xl font-semibold text-white hover:text-red-400 transition {{ request()->routeIs('houses.*') ? 'text-red-400' : '' }}">
                            Houses
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('endings.index') }}" @click="sidebarOpen = false" class="block py-4 text-2xl font-semibold text-white hover:text-red-400 transition {{ request()->routeIs('endings.index') ? 'text-red-400' : '' }}">
                            Endings
                        </a>
                    </li>

                    @if(Auth::user()?->is_admin)
                    <li class="pt-8 pb-2">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Admin</span>
                    </li>
                    <li>
                        <a href="{{ route('nodes.index') }}" @click="sidebarOpen = false" class="block py-4 text-xl font-semibold text-white hover:text-red-400 transition {{ request()->routeIs('nodes.*') ? 'text-red-400' : '' }}">
                            Nodes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('choices.index') }}" @click="sidebarOpen = false" class="block py-4 text-xl font-semibold text-white hover:text-red-400 transition {{ request()->routeIs('choices.*') ? 'text-red-400' : '' }}">
                            Choices
                        </a>
                    </li>
                    @endif

                    <li class="pt-8">
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-lg text-gray-400 hover:text-white transition">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</body>

</html>
