<x-layouts.app>
    <h1 class="text-2xl font-bold mb-4">Houses</h1>
    <a href="{{ route('houses.create') }}" class="btn btn-primary mb-4">Add House</a>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($houses as $house)
            <x-house-card :house="$house" />
        @endforeach
    </div>
        <div class="mt-4">
            {{ $houses->links() }}
        </div>
</x-layouts.app>
