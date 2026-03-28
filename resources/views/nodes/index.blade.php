<x-layouts.app>
    <h1 class="text-2xl font-bold mb-4">Nodes</h1>
    @can('create-houses')
        <a href="{{ route('nodes.create') }}" class="btn btn-primary mb-4">Add Node</a>
    @endcan
    <table class="w-full bg-white rounded-lg shadow">
        <thead>
            <tr class="border-b">
                <th class="p-4 text-left">Code</th>
                <th class="p-4 text-left">Chapter</th>
                <th class="p-4 text-left">Title</th>
                <th class="p-4 text-left">Ending?</th>
                <th class="p-4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nodes as $node)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-mono">{{ $node->node_code }}</td>
                    <td class="p-4">{{ $node->chapter_label }}</td>
                    <td class="p-4">{{ $node->title }}</td>
                    <td class="p-4">{{ $node->is_ending ? 'Yes' : 'No' }}</td>
                    <td class="p-4">
                        <a href="{{ route('nodes.show', $node) }}" class="btn btn-sm btn-info">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $nodes->links() }}</div>
</x-layouts.app>
