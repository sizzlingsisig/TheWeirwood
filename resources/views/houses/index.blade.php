<x-layouts.app>
    <div class="fixed inset-0 pointer-events-none z-[3] overflow-hidden">
        <svg class="absolute top-20 left-0 w-40 h-40 text-[var(--gold)]/10" viewBox="0 0 100 100" fill="currentColor">
            <path d="M0 50 Q20 30 40 40 Q60 50 80 30 Q100 10 100 0" stroke="currentColor" stroke-width="2" fill="none"/>
            <path d="M20 50 Q30 60 40 50 Q50 40 60 50" stroke="currentColor" stroke-width="1" fill="none"/>
            <path d="M40 40 Q50 30 60 40" stroke="currentColor" stroke-width="1" fill="none"/>
        </svg>
        <svg class="absolute top-20 right-0 w-40 h-40 text-[var(--blood)]/10 scale-x-[-1]" viewBox="0 0 100 100" fill="currentColor">
            <path d="M0 50 Q20 30 40 40 Q60 50 80 30 Q100 10 100 0" stroke="currentColor" stroke-width="2" fill="none"/>
            <path d="M20 50 Q30 60 40 50 Q50 40 60 50" stroke="currentColor" stroke-width="1" fill="none"/>
            <path d="M40 40 Q50 30 60 40" stroke="currentColor" stroke-width="1" fill="none"/>
        </svg>
    </div>

    {{-- Expanded max-width to 1400px to accommodate 4 columns gracefully --}}
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <h1 class="font-['Cinzel'] text-4xl font-bold text-[#E8DCC8] tracking-widest uppercase drop-shadow-[0_0_15px_rgba(139,0,0,0.3)]">
                    The Great Houses
                </h1>
                <p class="font-['Crimson_Text'] text-[#6B5A4E] text-xl italic mt-3">
                    "Blood, gold, and the debts between them."
                </p>
            </div>

            {{-- Protected Archivist Actions --}}
            <div class="flex gap-3">
                @can('edit-houses')
                    <button type="button" 
                            x-data 
                            @click="$dispatch('open-archivist-modal')"
                            class="border border-[rgba(184,134,11,0.4)] text-[var(--gold)] font-['Cinzel'] text-xs tracking-[0.2em] uppercase px-6 py-3 rounded-sm hover:bg-[rgba(184,134,11,0.2)] hover:border-[rgba(184,134,11,0.6)] transition-all text-center inline-block whitespace-nowrap">
                        🏛️ Ask the Archivist
                    </button>
                    <a href="{{ route('houses.trashed') }}"
                       class="border border-[rgba(107,90,78,0.4)] text-[#E8DCC8] font-['Cinzel'] text-xs tracking-[0.2em] uppercase px-6 py-3 rounded-sm hover:bg-[rgba(107,90,78,0.2)] hover:border-[rgba(184,134,11,0.6)] transition-all text-center inline-block whitespace-nowrap">
                        View Archives
                    </a>
                    <a href="{{ route('houses.create') }}"
                       class="bg-gradient-to-br from-[rgba(139,0,0,0.8)] to-[rgba(90,0,0,0.9)] border border-[rgba(139,0,0,0.6)] text-[#E8DCC8] font-['Cinzel'] text-xs tracking-[0.2em] uppercase px-8 py-4 rounded-sm hover:from-[rgba(168,0,0,0.9)] hover:to-[#780000] hover:shadow-[0_0_24px_rgba(139,0,0,0.5)] transition-all text-center inline-block whitespace-nowrap">
                        + Add House
                    </a>
                @endcan
            </div>
        </div>

        <form action="{{ route('houses.index') }}" method="GET" class="mb-10 flex items-center bg-[#1A1512]/80 border border-[rgba(107,90,78,0.4)] rounded-sm shadow-xl max-w-2xl">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ledger by name or motto..."
                class="flex-1 bg-transparent border-none text-[#E8DCC8] focus:ring-0 placeholder-[rgba(232,220,200,0.4)] font-['Crimson_Text'] text-lg px-6 py-3">
            
            <button type="submit" class="px-6 py-3 border-l border-[rgba(107,90,78,0.4)] text-[rgba(232,220,200,0.6)] hover:text-[#E8DCC8] hover:bg-black/40 font-['Cinzel'] tracking-widest text-sm transition-colors uppercase">
                Search
            </button>
            
            @if(request('search'))
                <a href="{{ route('houses.index') }}" class="px-6 py-3 border-l border-[rgba(107,90,78,0.4)] text-red-800/80 hover:text-red-500 hover:bg-black/40 font-['Cinzel'] tracking-widest text-sm transition-colors uppercase">
                    Clear
                </a>
            @endif
        </form>

        {{-- ── GRID AREA (4 Columns) ── --}}
        @if($houses->isEmpty())
            <div class="bg-[#1A1512]/60 border border-[rgba(107,90,78,0.3)] p-16 text-center rounded shadow-lg">
                <p class="font-['Crimson_Text'] text-[rgba(232,220,200,0.6)] text-2xl italic">The archivists found no records matching your query.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($houses as $house)
                    <x-house-card :house="$house" />
                @endforeach
            </div>
        @endif

        {{-- PAGINATION --}}
        @if ($houses->hasPages())
            <div class="mt-16 pt-8 border-t border-[rgba(107,90,78,0.2)]">
                {{ $houses->links() }}
            </div>
        @endif

    </div>

    {{-- 🏛️ Archivist Modal --}}
    <div x-data="archivist()" 
         @open-archivist-modal.window="open = true"
         @close-archivist-modal.window="open = false"
         x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
         style="display: none;">
        
        {{-- Modal Content --}}
        <div @click.outside="open = false"
             x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="bg-[#1A1512] border border-[rgba(184,134,11,0.4)] rounded-lg shadow-2xl w-full max-w-2xl max-h-[80vh] overflow-hidden">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-[rgba(139,0,0,0.3)] to-[rgba(184,134,11,0.2)] px-6 py-4 border-b border-[rgba(184,134,11,0.3)]">
                <div class="flex items-center justify-between">
                    <h2 class="font-['Cinzel'] text-xl text-[var(--gold)] tracking-widest">
                        🏛️ The Three-Eyed Raven
                    </h2>
                    <button @click="open = false" class="text-[rgba(232,220,200,0.6)] hover:text-[#E8DCC8] transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <p class="font-['Crimson_Text'] text-[rgba(232,220,200,0.6)] text-sm italic mt-1">
                    Archivist of House Records and Keeper of Westerosi Lore
                </p>
            </div>

            {{-- Query Input --}}
            <div class="p-6 border-b border-[rgba(107,90,78,0.3)]">
                <form @submit.prevent="ask">
                    <textarea x-model="prompt" 
                              rows="2"
                              placeholder="Ask about a house's history, or request to create/update/delete a house..."
                              class="w-full bg-[#0D0B09] border border-[rgba(107,90,78,0.4)] rounded p-4 text-[#E8DCC8] placeholder-[rgba(232,220,200,0.3)] font-['Crimson_Text'] focus:ring-1 focus:ring-[var(--gold)] focus:border-[var(--gold)] resize-none"></textarea>
                    <div class="flex justify-end mt-3">
                        <button type="submit" 
                                :disabled="loading"
                                class="bg-gradient-to-br from-[rgba(139,0,0,0.8)] to-[rgba(90,0,0,0.9)] border border-[rgba(139,0,0,0.6)] text-[#E8DCC8] font-['Cinzel'] text-xs tracking-[0.2em] uppercase px-6 py-3 rounded-sm hover:from-[rgba(168,0,0,0.9)] hover:to-[#780000] disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            <span x-show="!loading">📜 Consult the Archives</span>
                            <span x-show="loading">Consulting...</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Response --}}
            <div class="p-6 overflow-y-auto max-h-[40vh]" x-show="response">
                <div class="bg-[#0D0B09]/50 border border-[rgba(107,90,78,0.3)] rounded p-4 font-['Crimson_Text'] text-[#E8DCC8] text-sm leading-relaxed space-y-3 [&_h1]:text-lg [&_h1]:font-['Cinzel'] [&_h1]:font-bold [&_h1]:mb-2 [&_h2]:text-base [&_h2]:font-['Cinzel'] [&_h2]:font-semibold [&_h2]:mb-2 [&_p]:mb-2 [&_ul]:list-disc [&_ul]:list-inside [&_ul]:mb-2 [&_ol]:list-decimal [&_ol]:list-inside [&_ol]:mb-2 [&_li]:mb-1 [&_strong]:font-bold [&_em]:italic [&_code]:bg-[rgba(107,90,78,0.3)] [&_code]:px-1 [&_code]:rounded [&_code]:text-sm [&_blockquote]:border-l-2 [&_blockquote]:border-[rgba(139,0,0,0.6)] [&_blockquote]:pl-3 [&_blockquote]:italic" x-html="response">
                </div>
            </div>

            {{-- Error --}}
            <div class="p-6 overflow-y-auto max-h-[40vh]" x-show="error">
                <div class="bg-red-900/20 border border-red-800 rounded p-4">
                    <p x-text="error" class="text-red-400 font-['Crimson_Text'] text-sm"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
    function archivist() {
        return {
            open: false,
            prompt: '',
            response: '',
            error: '',
            loading: false,

            ask() {
                if (!this.prompt.trim() || this.loading) return;

                this.loading = true;
                this.response = '';
                this.error = '';

                fetch('{{ route('houses.archivist') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ prompt: this.prompt })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        this.error = data.error;
                    } else {
                        this.response = data.response;
                    }
                })
                .catch(err => {
                    this.error = 'The Archivist is unresponsive. Please try again.';
                })
                .finally(() => {
                    this.loading = false;
                });
            }
        }
    }
    </script>
</x-layouts.app>