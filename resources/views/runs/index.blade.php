<x-layouts.app>
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                ← Back to Dashboard
            </a>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Run History</h1>

        @if($runs->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
                <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't completed any runs yet.</p>
                <a href="{{ route('games.create') }}" class="text-red-600 hover:text-red-700 font-medium">
                    Start Your First Journey →
                </a>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">House</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Final Stats</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Verdict</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($runs as $run)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $run->house->name ?? 'Unknown' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-3 text-sm">
                                        <span class="{{ $run->final_honor <= 0 ? 'text-red-600' : 'text-gray-600 dark:text-gray-400' }}">H: {{ $run->final_honor }}</span>
                                        <span class="text-gray-600 dark:text-gray-400">P: {{ $run->final_power }}</span>
                                        <span class="{{ $run->final_debt >= 100 ? 'text-red-600' : 'text-gray-600 dark:text-gray-400' }}">D: {{ $run->final_debt }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($run->is_victory)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Victory
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Defeat
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $run->completed_at?->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('runs.show', $run) }}" class="text-red-600 hover:text-red-700 font-medium">
                                        View Details →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
