<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Items') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                <h1 class="text-2xl font-semibold text-gray-900">Search Items</h1>
                <p class="mt-2 text-gray-500">Search all found and lost items in the system.</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                <form method="GET" action="{{ route('user.search-items') }}" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-12">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Search by title, description, location, or tags"
                            class="h-11 w-full rounded-xl border-0 bg-gray-100 px-4 text-sm text-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-green-700 lg:col-span-5"
                        />

                        <select name="status" class="h-11 w-full rounded-xl border-0 bg-gray-100 px-4 text-sm text-gray-700 focus:ring-2 focus:ring-green-700 lg:col-span-3">
                            <option value="">All Status</option>
                            <option value="lost" @selected(($status ?? '') === 'lost')>Lost</option>
                            <option value="found" @selected(($status ?? '') === 'found')>Found</option>
                            <option value="claimed" @selected(($status ?? '') === 'claimed')>Claimed</option>
                            <option value="returned" @selected(($status ?? '') === 'returned')>Returned</option>
                        </select>

                        <input
                            type="text"
                            name="category"
                            value="{{ $category ?? '' }}"
                            placeholder="Filter by category"
                            class="h-11 w-full rounded-xl border-0 bg-gray-100 px-4 text-sm text-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-green-700 lg:col-span-4"
                        />
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-green-800 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-green-700">
                            Search
                        </button>
                        <a href="{{ route('user.search-items') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-900">Results</h3>
                        <p class="mt-1 text-gray-500">{{ $items->count() }} item(s) found</p>
                    </div>
                </div>

                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200 text-sm text-gray-700">
                                <th class="px-3 py-4 font-medium">Image</th>
                                <th class="px-3 py-4 font-medium">Title</th>
                                <th class="px-3 py-4 font-medium">Category</th>
                                <th class="px-3 py-4 font-medium">Location</th>
                                <th class="px-3 py-4 font-medium">Status</th>
                                <th class="px-3 py-4 font-medium">Date</th>
                                <th class="px-3 py-4 font-medium">Reported By</th>
                                <th class="px-3 py-4 font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse ($items as $item)
                                <tr class="border-b border-gray-100">
                                    <td class="px-3 py-4">
                                        @if ($item->image_path)
                                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="h-14 w-14 rounded-xl object-cover ring-1 ring-gray-200">
                                        @else
                                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gray-100 text-xs text-gray-500">N/A</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 font-medium text-gray-900">{{ $item->title }}</td>
                                    <td class="px-3 py-4">{{ $item->category }}</td>
                                    <td class="px-3 py-4">{{ $item->location }}</td>
                                    <td class="px-3 py-4">
                                        <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-green-700">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4">{{ $item->date_found?->format('M d, Y') ?? 'N/A' }}</td>
                                    <td class="px-3 py-4">{{ $item->reporter?->name ?? 'Unknown' }}</td>
                                    <td class="px-3 py-4">
                                        @if ($item->status === 'found')
                                            <form action="{{ route('user.claims.store') }}" method="POST" class="space-y-2">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <textarea id="reason-{{ $item->id }}" name="reason" rows="2" placeholder="Why is this your item?" class="w-56 rounded-lg border border-gray-200 px-3 py-2 text-xs text-gray-700 focus:border-green-600 focus:outline-none"></textarea>
                                                <button id="submit-claim-{{ $item->id }}" type="submit" disabled class="inline-flex items-center rounded-lg bg-green-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-800 disabled:bg-gray-400 disabled:cursor-not-allowed">
                                                    Submit Claim
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-500">Unavailable</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-3 py-10 text-center text-gray-500">No items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Find all reason textareas
            const reasonTextareas = document.querySelectorAll('[id^="reason-"]');
            
            reasonTextareas.forEach(textarea => {
                const itemId = textarea.id.replace('reason-', '');
                const submitButton = document.getElementById(`submit-claim-${itemId}`);
                
                if (submitButton) {
                    // Function to update button state
                    const updateButtonState = () => {
                        const isValid = textarea.value.trim().length > 0;
                        submitButton.disabled = !isValid;
                    };
                    
                    // Add event listeners
                    textarea.addEventListener('input', updateButtonState);
                    textarea.addEventListener('change', updateButtonState);
                }
            });
        });
    </script>
</x-app-layout>
