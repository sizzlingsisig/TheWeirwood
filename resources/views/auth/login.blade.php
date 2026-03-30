<x-layouts.blank :title="__('Login')">
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
                        <h1 class="font-['Cinzel'] text-lg sm:text-xl font-semibold text-[var(--bone)] tracking-[0.08em] mb-1">{{ __('Approach the Heart Tree') }}</h1>
                        <p class="text-[var(--mist)] text-xs font-['Crimson_Text'] italic">State your lineage</p>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[var(--bark)] to-transparent"></div>
                        <span class="text-[10px] text-[var(--mist)] uppercase tracking-widest font-['Crimson_Text']">Access</span>
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[var(--bark)] to-transparent"></div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-[rgba(139,0,0,0.1)] border border-[var(--blood)] rounded-sm">
                            <ul class="text-[var(--blood)] text-xs font-['Crimson_Text'] list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-3.5">
                        @csrf
                        <div>
                            <label for="email" class="block text-[var(--bone)] font-['Crimson_Text'] text-xs mb-1">{{ __('Email') }}</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="your@email.com"
                                required
                                autofocus
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

                            <div class="flex items-center justify-between mt-2.5">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-xs text-[var(--mist)] font-['Crimson_Text'] hover:text-[var(--bone)] transition-colors duration-200">{{ __('Forgot Password?') }}</a>
                                @endif
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="remember"
                                        id="remember"
                                        class="w-3.5 h-3.5 rounded-sm border border-[var(--bark)] bg-[var(--ash)] accent-[var(--blood)] cursor-pointer"
                                    />
                                    <span class="text-xs text-[var(--mist)] font-['Crimson_Text']">{{ __('Bind this Oath') }}</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full font-['Cinzel'] uppercase tracking-[0.12em] py-2.5 rounded-sm bg-[var(--blood)] text-[var(--bone)] border border-[rgba(139,0,0,0.5)] hover:bg-[var(--ember)] hover:border-[var(--ember)] hover:shadow-[0_0_15px_rgba(192,57,43,0.3)] active:scale-[0.99] transition-all duration-200 text-xs sm:text-sm">
                            {{ __('Enter the Roots') }}
                        </button>
                    </form>

                    @if (Route::has('register'))
                        <div class="text-center mt-4 pt-3 border-t border-[var(--bark)]">
                            <p class="text-xs text-[var(--mist)] font-['Crimson_Text']">
                                {{ __('Uninitiated?') }}
                                <a href="{{ route('register') }}"
                                   class="text-[var(--gold)] hover:text-[var(--ember)] font-semibold transition-colors duration-200">{{ __('Seal your Pact') }}</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.blank>
