<x-layouts.app>
    <h1 class="text-2xl font-bold mb-4">Add House</h1>
    <form action="{{ route('houses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" class="form-input w-full" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label>Motto</label>
            <input type="text" name="motto" class="form-input w-full" value="{{ old('motto') }}">
        </div>
        <div class="mb-4">
            <label>Description</label>
            <textarea name="description" class="form-textarea w-full">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label>Sigil Image</label>
            <input type="file" name="sigil_image" class="form-input w-full" accept="image/*">
        </div>
        <div class="mb-4">
            <label>Starting Honor</label>
            <input type="number" name="starting_honor" class="form-input w-full" min="0" max="100" value="{{ old('starting_honor', 50) }}" required>
        </div>
        <div class="mb-4">
            <label>Starting Power</label>
            <input type="number" name="starting_power" class="form-input w-full" min="0" max="100" value="{{ old('starting_power', 50) }}" required>
        </div>
        <div class="mb-4">
            <label>Starting Debt</label>
            <input type="number" name="starting_debt" class="form-input w-full" min="0" max="100" value="{{ old('starting_debt', 20) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('houses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</x-layouts.app>
