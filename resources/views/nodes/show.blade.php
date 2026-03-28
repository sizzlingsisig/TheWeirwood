<x-layouts.app>
    <div class="mb-4">
        <a href="{{ route('nodes.index') }}" class="btn btn-sm">&larr; Back to Nodes</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <span class="text-sm text-gray-500">{{ $node->chapter_label }}</span>
                <h1 class="text-2xl font-bold">{{ $node->title }}</h1>
                <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $node->node_code }}</code>
            </div>
            @if($node->is_ending)
                <span class="bg-red-100 text-red-800 px-3 py-1 rounded text-sm font-medium">Ending</span>
            @endif
        </div>

        @if($node->art_image_path)
            <img src="{{ asset('storage/' . $node->art_image_path) }}" alt="Node art" class="w-full max-w-md mb-4 rounded">
        @endif

        <div class="prose max-w-none mb-4">
            <p class="whitespace-pre-wrap">{{ $node->narrative_text }}</p>
        </div>

        @if($node->debt_warning_text)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                <p class="font-medium">Debt Warning ({{ $node->debt_warning_threshold }}+)</p>
                <p>{{ $node->debt_warning_text }}</p>
            </div>
        @endif

        @can('create-houses')
            <div class="flex gap-2">
                <a href="{{ route('nodes.edit', $node) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('nodes.destroy', $node) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this node?')">Delete</button>
                </form>
            </div>
        @endcan
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Choices</h2>
            @can('create-houses')
                <a href="{{ route('nodes.choices.create', $node) }}" class="btn btn-primary btn-sm">Add Choice</a>
            @endcan
        </div>

        @if($node->choices->isEmpty())
            <p class="text-gray-500">No choices yet.</p>
        @else
            <div class="space-y-4">
                @foreach($node->choices->sortBy('display_order') as $choice)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-sm text-gray-500">Order: {{ $choice->display_order }}</span>
                                <p class="font-medium">{{ $choice->choice_text }}</p>
                                @if($choice->hint_text)
                                    <p class="text-sm text-gray-500">Hint: {{ $choice->hint_text }}</p>
                                @endif
                                @if($choice->requiredHouse)
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Requires: {{ $choice->requiredHouse->name }}</span>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-sm">
                                    @if($choice->honor_delta)Honor: {{ $choice->honor_delta > 0 ? '+' : '' }}{{ $choice->honor_delta }} @endif
                                    @if($choice->power_delta)Power: {{ $choice->power_delta > 0 ? '+' : '' }}{{ $choice->power_delta }} @endif
                                    @if($choice->debt_delta)Debt: {{ $choice->debt_delta > 0 ? '+' : '' }}{{ $choice->debt_delta }} @endif
                                </p>
                                <a href="{{ route('nodes.show', $choice->toNode) }}" class="text-blue-600 hover:underline text-sm">Go to: {{ $choice->toNode->title }}</a>
                            </div>
                        </div>
                        @can('create-houses')
                            <form action="{{ route('nodes.choices.destroy', [$node, $choice]) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 text-sm" onclick="return confirm('Delete this choice?')">Delete</button>
                            </form>
                        @endcan
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>
