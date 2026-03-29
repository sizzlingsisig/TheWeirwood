<x-layouts.blank :title="__('Verify Email')">
    <div class="min-h-screen flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-sm">
            <div class="relative bg-[rgba(26,21,18,0.95)] backdrop-blur-md border border-[var(--bark)] shadow-[0_4px_24px_rgba(0,0,0,0.8),0_0_40px_rgba(139,0,0,0.08)] rounded-sm overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[var(--blood)] to-transparent opacity-50"></div>
                <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[var(--blood)] to-transparent opacity-50"></div>
                
                <div class="p-6">
                    <div class="mb-5 text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 mb-3 rounded-full border border-[var(--bark)] bg-[var(--coal)]">
                            <svg class="w-5 h-5 text-[var(--blood)]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <h1 class="font-['Cinzel'] text-lg sm:text-xl font-semibold text-[var(--bone)] tracking-[0.08em] mb-1">{{ __('Verify Your Mark') }}</h1>
                        <p class="text-[var(--mist)] text-xs font-['Crimson_Text'] italic">Confirm your bloodline</p>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[var(--bark)] to-transparent"></div>
                        <span class="text-[10px] text-[var(--mist)] uppercase tracking-widest font-['Crimson_Text']">Confirm</span>
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-[var(--bark)] to-transparent"></div>
                    </div>

                    <div class="mb-4 p-3 bg-[var(--ash)] border border-[var(--bark)] rounded-sm">
                        <p class="text-xs text-[var(--mist)] font-['Crimson_Text'] text-center">
                            {{ __('Check your email for a verification link. If you did not receive the email, request another below.') }}
                        </p>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mb-4 p-3 bg-[var(--ash)] border border-[var(--gold)] rounded-sm">
                            <p class="text-xs text-[var(--gold)] font-['Crimson_Text'] text-center">
                                {{ __('A new verification link has been sent to your email.') }}
                            </p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.store') }}" class="space-y-3.5">
                        @csrf
                        <button type="submit" class="w-full font-['Cinzel'] uppercase tracking-[0.12em] py-2.5 rounded-sm bg-[var(--blood)] text-[var(--bone)] border border-[rgba(139,0,0,0.5)] hover:bg-[var(--ember)] hover:border-[var(--ember)] hover:shadow-[0_0_15px_rgba(192,57,43,0.3)] active:scale-[0.99] transition-all duration-200 text-xs sm:text-sm">
                            {{ __('Resend Verification') }}
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-t border-[var(--bark)]">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-[var(--mist)] font-['Crimson_Text'] hover:text-[var(--bone)] transition-colors duration-200">
                                {{ __('Sign Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.blank>
