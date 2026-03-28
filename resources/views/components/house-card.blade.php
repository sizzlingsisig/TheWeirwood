<div class="bg-white rounded-lg shadow p-6 flex flex-col h-full">
    @if($house->sigil_image_path)
        <img src="{{ asset('storage/'.$house->sigil_image_path) }}" alt="{{ $house->name }} sigil" class="w-full h-32 object-contain mb-4">
    @endif
    <h2 class="text-xl font-bold mb-2">{{ $house->name }}</h2>
    <p class="italic text-gray-600 mb-2">{{ $house->motto }}</p>
    <div class="flex justify-between text-xs text-gray-500 mb-4">
        <span>Honor: <span class="font-semibold">{{ $house->starting_honor }}</span></span>
        <span>Power: <span class="font-semibold">{{ $house->starting_power }}</span></span>
        <span>Debt: <span class="font-semibold">{{ $house->starting_debt }}</span></span>
    </div>
    <div class="mt-auto flex gap-2">
        <a href="{{ route('houses.show', $house) }}" class="btn btn-sm btn-info">View</a>
        <a href="{{ route('houses.edit', $house) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('houses.destroy', $house) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this house?')">Delete</button>
        </form>
    </div>
</div>
