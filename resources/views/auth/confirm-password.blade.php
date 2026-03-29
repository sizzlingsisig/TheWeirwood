<x-layouts.blank :title="__('Confirm Password')">
    <div class="min-h-screen flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-sm">
            <div class="relative bg-[rgba(26,21,18,0.95)] backdrop-blur-md border border-[var(--bark)] shadow-[0_4px_24px_rgba(0,0,0,0.8),0_0_40px_rgba(139,0,0,0.08)] rounded-sm overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[var(--blood)] to-transparent opacity-50"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[var(--blood)] to-transparent opacity-50"></div>
                
                <div class="p-6">
                    <div class="mb-5 text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 mb-3 rounded-full border border-[var(--bark)] bg-[var(--coal)]">
                            <svg class="w-5 h-5 text-[var(--blood)]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                            </svg>
                        </div>
                        <h1 class="font-['Cinzel'] text-lg sm:text-xl font-semibold text-[var(--bone)] tracking-[0.08em] mb-1">{{ __('Prove Your Identity') }}</h1>
                        <p class="text-[var(--mist)] text-xs font-['Crimson_Text'] italic">The tree must know its own</p>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[var(--bark)] to-transparent"></div>
                        <span class="text-[10px] text-[var(--mist)] uppercase tracking-widest font-['Crimson_Text']">Verify</span>
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[var(--bark)] to-transparent"></div>
                    </div>

                    <div class="mb-4 p-3 bg-[var(--ash)] border border-[var(--bark)] rounded-sm">
                        <p class="text-xs text-[var(--mist)] font-['Crimson_Text'] text-center">
                            {{ __('Please confirm your password before continuing.') }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-3.5">
                        @csrf
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

                        <button type="submit" class="w-full font-['Cinzel'] uppercase tracking-[0.12em] py-2.5 rounded-sm bg-[var(--blood)] text-[var(--bone)] border border-[rgba(139,0,0,0.5)] hover:bg-[var(--ember)] hover:border-[var(--ember)] hover:shadow-[0_0_15px_rgba(192,57,43,0.3)] active:scale-[0.99] transition-all duration-200 text-xs sm:text-sm">
                            {{ __('Confirm') }}
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-t border-[var(--bark)]">
                        <a href="{{ route('password.request') }}"
                           class="text-xs text-[var(--mist)] font-['Crimson_Text'] hover:text-[var(--bone)] transition-colors duration-200">{{ __('Forgot Password?') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.blank>
