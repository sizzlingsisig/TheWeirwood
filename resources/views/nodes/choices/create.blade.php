<x-layouts.app>
    <div class="mb-4">
        <a href="{{ route('nodes.show', $node) }}" class="btn btn-sm">&larr; Back to Node</a>
    </div>

    <h1 class="text-2xl font-bold mb-4">Add Choice to: {{ $node->title }}</h1>

    <form action="{{ route('nodes.choices.store', $node) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">To Node *</label>
                <select name="to_node_id" class="form-select w-full" required>
                    <option value="">Select node...</option>
                    @foreach($nodes as $n)
                        <option value="{{ $n->id }}">{{ $n->title }} ({{ $n->node_code }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Display Order *</label>
                <input type="number" name="display_order" class="form-input w-full" min="1" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Choice Text *</label>
            <textarea name="choice_text" rows="2" class="form-textarea w-full" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Hint Text</label>
            <input type="text" name="hint_text" class="form-input w-full">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Required House</label>
            <select name="required_house_id" class="form-select w-full">
                <option value="">None</option>
                @foreach($houses as $house)
                    <option value="{{ $house->id }}">{{ $house->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Honor Δ</label>
                <input type="number" name="honor_delta" class="form-input w-full">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Power Δ</label>
                <input type="number" name="power_delta" class="form-input w-full">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Debt Δ</label>
                <input type="number" name="debt_delta" class="form-input w-full">
            </div>
        </div>

        <div class="mb-4">
            <input type="checkbox" name="locks_on_high_debt" id="locks_on_high_debt" class="mr-2">
            <label for="locks_on_high_debt">Lock this choice when debt is too high</label>
        </div>

        <button type="submit" class="btn btn-primary">Add Choice</button>
        <a href="{{ route('nodes.show', $node) }}" class="btn btn-secondary">Cancel</a>
    </form>
</x-layouts.app>
