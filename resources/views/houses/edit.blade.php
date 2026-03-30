<x-layouts.app>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-[#E8DCC8]">Edit House Records</h1>

        <form action="{{ route('houses.update', $house) }}" method="POST" enctype="multipart/form-data" class="bg-[#1A1512]/80 p-8 rounded-lg shadow-2xl border border-[rgba(107,90,78,0.3)]">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label class="block font-semibold mb-1 text-[#E8DCC8] tracking-wide">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" class="form-input w-full bg-black/40 border-[rgba(107,90,78,0.5)] text-[#E8DCC8] focus:ring-[#E8DCC8] focus:border-[#E8DCC8] @error('name') border-red-500 @enderror" value="{{ old('name', $house->name) }}" required>
                @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-5">
                <label class="block font-semibold mb-1 text-[#E8DCC8] tracking-wide">Motto</label>
                <input type="text" name="motto" class="form-input w-full bg-black/40 border-[rgba(107,90,78,0.5)] text-[#E8DCC8] focus:ring-[#E8DCC8] focus:border-[#E8DCC8] @error('motto') border-red-500 @enderror" value="{{ old('motto', $house->motto) }}">
                @error('motto') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-5">
                <label class="block font-semibold mb-1 text-[#E8DCC8] tracking-wide">Description</label>
                <textarea name="description" rows="4" class="form-textarea w-full bg-black/40 border-[rgba(107,90,78,0.5)] text-[#E8DCC8] focus:ring-[#E8DCC8] focus:border-[#E8DCC8] @error('description') border-red-500 @enderror">{{ old('description', $house->description) }}</textarea>
                @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6 p-5 border border-[rgba(107,90,78,0.3)] rounded bg-black/30">
                <label class="block font-semibold mb-3 text-[#E8DCC8] tracking-wide">Sigil Image</label>
                
                @if($house->sigil_image_path)
                    <div class="mb-4 flex items-center gap-4 p-3 bg-black/40 border border-[rgba(107,90,78,0.2)] rounded">
                        <img src="{{ asset('storage/' . $house->sigil_image_path) }}" alt="Current sigil" class="w-16 h-16 object-cover rounded shadow-lg border border-[rgba(107,90,78,0.5)]">
                        <span class="text-sm text-[rgba(232,220,200,0.6)] italic">Current Sigil in Records</span>
                    </div>
                @endif

                <p class="text-sm text-[rgba(232,220,200,0.6)] mb-3">Upload a new image to replace the current one (JPEG, PNG, WEBP). Max size: 2MB.</p>
                <input type="file" name="sigil_image" class="form-input w-full text-[#E8DCC8] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-[rgba(107,90,78,0.5)] file:text-[#E8DCC8] hover:file:bg-[rgba(107,90,78,0.8)] file:cursor-pointer @error('sigil_image') border-red-500 @enderror" accept="image/jpeg,image/png,image/webp">
                @error('sigil_image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 pt-4 border-t border-[rgba(107,90,78,0.3)]">
                <div>
                    <label class="block font-semibold mb-1 text-[#E8DCC8] tracking-wide text-center">Starting Honor <span class="text-red-500">*</span></label>
                    <input type="number" name="starting_honor" class="form-input w-full text-center bg-black/40 border-[rgba(107,90,78,0.5)] text-[#E8DCC8] focus:ring-[#E8DCC8] focus:border-[#E8DCC8] @error('starting_honor') border-red-500 @enderror" min="0" max="100" value="{{ old('starting_honor', $house->starting_honor) }}" required>
                    @error('starting_honor') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1 text-[#E8DCC8] tracking-wide text-center">Starting Power <span class="text-red-500">*</span></label>
                    <input type="number" name="starting_power" class="form-input w-full text-center bg-black/40 border-[rgba(107,90,78,0.5)] text-[#E8DCC8] focus:ring-[#E8DCC8] focus:border-[#E8DCC8] @error('starting_power') border-red-500 @enderror" min="0" max="100" value="{{ old('starting_power', $house->starting_power) }}" required>
                    @error('starting_power') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1 text-red-800 tracking-wide text-center">Starting Debt <span class="text-red-500">*</span></label>
                    <input type="number" name="starting_debt" class="form-input w-full text-center bg-black/40 border-red-900/50 text-[#E8DCC8] focus:ring-red-900 focus:border-red-900 @error('starting_debt') border-red-500 @enderror" min="0" max="100" value="{{ old('starting_debt', $house->starting_debt) }}" required>
                    @error('starting_debt') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-4">
                <a href="{{ route('houses.index') }}" class="px-6 py-2 border border-[rgba(107,90,78,0.5)] text-[#E8DCC8] hover:bg-black/50 transition-colors rounded">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-[rgba(107,90,78,0.6)] text-[#E8DCC8] hover:bg-[rgba(107,90,78,0.8)] border border-[rgba(107,90,78,0.8)] transition-colors rounded font-semibold tracking-wide">Update Records</button>
            </div>
        </form>
    </div>
</x-layouts.app>