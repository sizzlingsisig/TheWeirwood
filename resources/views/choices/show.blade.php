<x-layouts.app>
    <div class="mb-4">
        <a href="{{ route('choices.index') }}" class="btn btn-sm">&larr; Back to Choices</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-2xl font-bold mb-4">Choice #{{ $choice->id }}</h1>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm text-gray-500">From Node</label>
                <p class="font-medium">{{ $choice->fromNode->title ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">To Node</label>
                <p class="font-medium">{{ $choice->toNode->title ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm text-gray-500">Choice Text</label>
            <p class="font-medium">{{ $choice->choice_text }}</p>
        </div>

        @if($choice->hint_text)
            <div class="mb-4">
                <label class="block text-sm text-gray-500">Hint</label>
                <p>{{ $choice->hint_text }}</p>
            </div>
        @endif

        @if($choice->requiredHouse)
            <div class="mb-4">
                <label class="block text-sm text-gray-500">Required House</label>
                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ $choice->requiredHouse->name }}</span>
            </div>
        @endif

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm text-gray-500">Honor Δ</label>
                <p class="font-medium">{{ $choice->honor_delta ?? 0 }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Power Δ</label>
                <p class="font-medium">{{ $choice->power_delta ?? 0 }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Debt Δ</label>
                <p class="font-medium">{{ $choice->debt_delta ?? 0 }}</p>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm text-gray-500">Display Order</label>
            <p>{{ $choice->display_order }}</p>
        </div>

        @if($choice->locks_on_high_debt)
            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Locks on high debt</span>
        @endif

        @can('create-houses')
            <div class="flex gap-2 mt-4">
                <a href="{{ route('choices.edit', $choice) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('choices.destroy', $choice) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this choice?')">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</x-layouts.app>
