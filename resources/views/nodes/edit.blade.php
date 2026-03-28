<x-layouts.app>
    <div class="mb-4">
        <a href="{{ route('nodes.show', $node) }}" class="btn btn-sm">&larr; Back to Node</a>
    </div>

    <h1 class="text-2xl font-bold mb-4">Edit Node</h1>

    <form action="{{ route('nodes.update', $node) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Node Code *</label>
                <input type="text" name="node_code" class="form-input w-full" value="{{ old('node_code', $node->node_code) }}" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Chapter Label</label>
                <input type="text" name="chapter_label" class="form-input w-full" value="{{ old('chapter_label', $node->chapter_label) }}">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Title *</label>
            <input type="text" name="title" class="form-input w-full" value="{{ old('title', $node->title) }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Art Image</label>
            @if($node->art_image_path)
                <img src="{{ asset('storage/' . $node->art_image_path) }}" alt="Current art" class="w-32 h-32 object-cover mb-2 rounded">
            @endif
            <input type="file" name="art_image" class="form-input w-full" accept="image/*">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Narrative Text *</label>
            <textarea name="narrative_text" rows="6" class="form-textarea w-full" required>{{ old('narrative_text', $node->narrative_text) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Debt Warning Text</label>
            <textarea name="debt_warning_text" rows="2" class="form-textarea w-full">{{ old('debt_warning_text', $node->debt_warning_text) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Debt Warning Threshold</label>
                <input type="number" name="debt_warning_threshold" class="form-input w-full" min="0" max="100" value="{{ old('debt_warning_threshold', $node->debt_warning_threshold) }}">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_ending" id="is_ending" class="mr-2" {{ old('is_ending', $node->is_ending) ? 'checked' : '' }}>
                <label for="is_ending">Is Ending?</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Node</button>
        <a href="{{ route('nodes.show', $node) }}" class="btn btn-secondary">Cancel</a>
    </form>
</x-layouts.app>
