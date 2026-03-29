<x-layouts.app>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Create Player</h1>
        <form method="POST" action="{{ route('players.store') }}">
            @csrf
            <div class="mb-4">
                <label for="display_name" class="block text-gray-700">Display Name</label>
                <input type="text" name="display_name" id="display_name" class="mt-1 block w-full border-gray-300 rounded" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>
</x-layouts.app>
