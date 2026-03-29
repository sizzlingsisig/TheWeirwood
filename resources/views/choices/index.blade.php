<x-layouts.app>
    <h1 class="text-2xl font-bold mb-4">Choices</h1>
    @can('create-houses')
        <a href="{{ route('choices.create') }}" class="btn btn-primary mb-4">Add Choice</a>
    @endcan
    <table class="w-full bg-white rounded-lg shadow">
        <thead>
            <tr class="border-b">
                <th class="p-4 text-left">From</th>
                <th class="p-4 text-left">To</th>
                <th class="p-4 text-left">Text</th>
                <th class="p-4 text-left">Order</th>
                <th class="p-4 text-left">Stats</th>
                <th class="p-4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($choices as $choice)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 text-sm">{{ $choice->fromNode->title ?? 'N/A' }}</td>
                    <td class="p-4 text-sm">{{ $choice->toNode->title ?? 'N/A' }}</td>
                    <td class="p-4 text-sm">{{ Str::limit($choice->choice_text, 40) }}</td>
                    <td class="p-4">{{ $choice->display_order }}</td>
                    <td class="p-4 text-sm">
                        @if($choice->honor_delta)H: {{ $choice->honor_delta }}@endif
                        @if($choice->power_delta)P: {{ $choice->power_delta }}@endif
                        @if($choice->debt_delta)D: {{ $choice->debt_delta }}@endif
                    </td>
                    <td class="p-4">
                        <a href="{{ route('choices.show', $choice) }}" class="btn btn-sm btn-info">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $choices->links() }}</div>
</x-layouts.app>
