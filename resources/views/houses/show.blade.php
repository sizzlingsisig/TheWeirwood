<x-layouts.app>
    <h1 class="text-2xl font-bold mb-4">{{ $house->name }}</h1>
    <p><strong>Motto:</strong> {{ $house->motto }}</p>
    <p><strong>Description:</strong> {{ $house->description }}</p>
    <p><strong>Honor:</strong> {{ $house->starting_honor }}</p>
    <p><strong>Power:</strong> {{ $house->starting_power }}</p>
    <p><strong>Debt:</strong> {{ $house->starting_debt }}</p>
    @if($house->sigil_image_path)
        <img src="{{ asset('storage/' . $house->sigil_image_path) }}" alt="Sigil" class="w-32 h-32 my-4">
    @endif
    <a href="{{ route('houses.edit', $house) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('houses.index') }}" class="btn btn-secondary">Back to List</a>
</x-layouts.app>
