<x-layouts.app>
    <div class="mb-4">
        <a href="{{ route('nodes.index') }}" class="btn btn-sm">&larr; Back to Nodes</a>
    </div>

    <h1 class="text-2xl font-bold mb-4">Create Node</h1>

    <form action="{{ route('nodes.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Node Code *</label>
                <input type="text" name="node_code" class="form-input w-full" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Chapter Label</label>
                <input type="text" name="chapter_label" class="form-input w-full">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Title *</label>
            <input type="text" name="title" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Art Image</label>
            <input type="file" name="art_image" class="form-input w-full" accept="image/*">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Narrative Text *</label>
            <textarea name="narrative_text" rows="6" class="form-textarea w-full" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Debt Warning Text</label>
            <textarea name="debt_warning_text" rows="2" class="form-textarea w-full"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Debt Warning Threshold</label>
                <input type="number" name="debt_warning_threshold" class="form-input w-full" min="0" max="100">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_ending" id="is_ending" class="mr-2">
                <label for="is_ending">Is Ending?</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create Node</button>
        <a href="{{ route('nodes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</x-layouts.app>
