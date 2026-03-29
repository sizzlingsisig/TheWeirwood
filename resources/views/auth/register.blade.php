<x-layouts.blank :title="__('Register')">
    <div class="min-h-screen flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-sm">
            <div class="relative bg-[rgba(26,21,18,0.95)] backdrop-blur-md border border-[var(--bark)] shadow-[0_4px_24px_rgba(0,0,0,0.8),0_0_40px_rgba(139,0,0,0.08)] rounded-sm overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[var(--blood)] to-transparent opacity-50"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[var(--blood)] to-transparent opacity-50"></div>
                
                <div class="p-6">
                    <div class="mb-5 text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 mb-3 rounded-full border border-[var(--bark)] bg-[var(--coal)]">
                            <svg class="w-5 h-5 text-[var(--blood)]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <h1 class="font-['Cinzel'] text-lg sm:text-xl font-semibold text-[var(--bone)] tracking-[0.08em] mb-1">{{ __('Seal your Pact') }}</h1>
                        <p class="text-[var(--mist)] text-xs font-['Crimson_Text'] italic">Begin your journey</p>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[var(--bark)] to-transparent"></div>
                        <span class="text-[10px] text-[var(--mist)] uppercase tracking-widest font-['Crimson_Text']">Join</span>
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[var(--bark)] to-transparent"></div>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
                        @csrf
                        <div>
                            <label for="name" class="block text-[var(--bone)] font-['Crimson_Text'] text-xs mb-1">{{ __('Full Name') }}</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                placeholder="{{ __('Your name') }}"
                                required
                                autofocus
                                class="w-full bg-[var(--ash)] text-[var(--bone)] font-['Crimson_Text'] text-xs px-3 py-2 rounded-sm border border-[var(--bark)] placeholder:text-[var(--mist)] focus:outline-none focus:border-[var(--blood)] focus:shadow-[0_0_8px_rgba(139,0,0,0.3)] transition-all duration-200"
                            />
                        </div>

                        <div>
                            <label for="email" class="block text-[var(--bone)] font-['Crimson_Text'] text-xs mb-1">{{ __('Email') }}</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="your@email.com"
                                required
                                class="w-full bg-[var(--ash)] text-[var(--bone)] font-['Crimson_Text'] text-xs px-3 py-2 rounded-sm border border-[var(--bark)] placeholder:text-[var(--mist)] focus:outline-none focus:border-[var(--blood)] focus:shadow-[0_0_8px_rgba(139,0,0,0.3)] transition-all duration-200"
                            />
                        </div>

                        <div>
                            <label for="password" class="block text-[var(--bone)] font-['Crimson_Text'] text-xs mb-1">{{ __('Password') }}</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="••••••••"
                                required
                                class="w-full bg-[var(--ash)] text-[var(--bone)] font-['Crimson_Text'] text-xs px-3 py-2 rounded-sm border border-[var(--bark)] placeholder:text-[var(--mist)] focus:outline-none focus:border-[var(--blood)] focus:shadow-[0_0_8px_rgba(139,0,0,0.3)] transition-all duration-200"
                            />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[var(--bone)] font-['Crimson_Text'] text-xs mb-1">{{ __('Confirm Password') }}</label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                placeholder="••••••••"
                                required
                                class="w-full bg-[var(--ash)] text-[var(--bone)] font-['Crimson_Text'] text-xs px-3 py-2 rounded-sm border border-[var(--bark)] placeholder:text-[var(--mist)] focus:outline-none focus:border-[var(--blood)] focus:shadow-[0_0_8px_rgba(139,0,0,0.3)] transition-all duration-200"
                            />
                        </div>

                        <button type="submit" class="w-full font-['Cinzel'] uppercase tracking-[0.12em] py-2.5 rounded-sm bg-[var(--blood)] text-[var(--bone)] border border-[rgba(139,0,0,0.5)] hover:bg-[var(--ember)] hover:border-[var(--ember)] hover:shadow-[0_0_15px_rgba(192,57,43,0.3)] active:scale-[0.99] transition-all duration-200 text-xs sm:text-sm">
                            {{ __('Create Account') }}
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-t border-[var(--bark)]">
                        <p class="text-xs text-[var(--mist)] font-['Crimson_Text']">
                            {{ __('Already initiated?') }}
                            <a href="{{ route('login') }}"
                               class="text-[var(--gold)] hover:text-[var(--ember)] font-semibold transition-colors duration-200">{{ __('Enter the Roots') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.blank>
