<x-layouts.app>
    <h1 class="text-2xl font-bold mb-4">Edit House</h1>
    <form action="{{ route('houses.update', $house) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" class="form-input w-full" value="{{ old('name', $house->name) }}" required>
        </div>
        <div class="mb-4">
            <label>Motto</label>
            <input type="text" name="motto" class="form-input w-full" value="{{ old('motto', $house->motto) }}">
        </div>
        <div class="mb-4">
            <label>Description</label>
            <textarea name="description" class="form-textarea w-full">{{ old('description', $house->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label>Sigil Image</label>
            @if($house->sigil_image_path)
                <img src="{{ asset('storage/' . $house->sigil_image_path) }}" alt="Current sigil" class="w-24 h-24 object-cover mb-2 rounded">
            @endif
            <input type="file" name="sigil_image" class="form-input w-full" accept="image/*">
        </div>
        <div class="mb-4">
            <label>Starting Honor</label>
            <input type="number" name="starting_honor" class="form-input w-full" min="0" max="100" value="{{ old('starting_honor', $house->starting_honor) }}" required>
        </div>
        <div class="mb-4">
            <label>Starting Power</label>
            <input type="number" name="starting_power" class="form-input w-full" min="0" max="100" value="{{ old('starting_power', $house->starting_power) }}" required>
        </div>
        <div class="mb-4">
            <label>Starting Debt</label>
            <input type="number" name="starting_debt" class="form-input w-full" min="0" max="100" value="{{ old('starting_debt', $house->starting_debt) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('houses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</x-layouts.app>
