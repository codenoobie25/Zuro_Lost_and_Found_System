<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verify Claims') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Verify Claims') }}</h1>
                <p class="mt-2 text-gray-500">{{ __('Review and verify item claims from users') }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-gray-100 p-2 shadow-sm">
                <div class="flex flex-wrap gap-2 sm:flex-nowrap">
                    <a href="{{ route('staff.verify-claims', ['status' => 'pending']) }}" class="flex-1 flex items-center justify-center gap-2 rounded-xl {{ ($status ?? 'pending') === 'pending' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:bg-white hover:text-gray-900' }} py-2.5 px-4 text-sm font-semibold transition">
                        <span>Pending ({{ $counts['pending'] ?? 0 }})</span>
                    </a>
                    <a href="{{ route('staff.verify-claims', ['status' => 'verified']) }}" class="flex-1 flex items-center justify-center gap-2 rounded-xl {{ ($status ?? '') === 'verified' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:bg-white hover:text-gray-900' }} py-2.5 px-4 text-sm font-semibold transition">
                        <span>Verified ({{ $counts['verified'] ?? 0 }})</span>
                    </a>
                    <a href="{{ route('staff.verify-claims', ['status' => 'rejected']) }}" class="flex-1 flex items-center justify-center gap-2 rounded-xl {{ ($status ?? '') === 'rejected' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:bg-white hover:text-gray-900' }} py-2.5 px-4 text-sm font-semibold transition">
                        <span>Rejected ({{ $counts['rejected'] ?? 0 }})</span>
                    </a>
                    <a href="{{ route('staff.verify-claims', ['status' => 'completed']) }}" class="flex-1 flex items-center justify-center gap-2 rounded-xl {{ ($status ?? '') === 'completed' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:bg-white hover:text-gray-900' }} py-2.5 px-4 text-sm font-semibold transition">
                        <span>Completed ({{ $counts['completed'] ?? 0 }})</span>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                @if ($claims->isEmpty())
                    <div class="py-10 text-center text-gray-500">No claims to verify.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-200 text-sm text-gray-700">
                                    <th class="px-3 py-4 font-medium">Item</th>
                                    <th class="px-3 py-4 font-medium">Claimant</th>
                                    <th class="px-3 py-4 font-medium">Reason</th>
                                    <th class="px-3 py-4 font-medium">Status</th>
                                    <th class="px-3 py-4 font-medium">Submitted</th>
                                    <th class="px-3 py-4 font-medium">Reviewed By</th>
                                    <th class="px-3 py-4 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-800">
                                @foreach ($claims as $claim)
                                    <tr class="border-b border-gray-100">
                                        <td class="px-3 py-4 font-medium text-gray-900">{{ $claim->item?->title ?? 'Unknown Item' }}</td>
                                        <td class="px-3 py-4">{{ $claim->user?->name ?? 'Unknown User' }}</td>
                                        <td class="px-3 py-4">{{ $claim->reason ?? 'No reason provided' }}</td>
                                        <td class="px-3 py-4">
                                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-green-700">{{ $claim->status }}</span>
                                        </td>
                                        <td class="px-3 py-4">{{ $claim->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                                        <td class="px-3 py-4">{{ $claim->reviewer?->name ?? '—' }}</td>
                                        <td class="px-3 py-4">
                                            @if ($claim->status === 'pending')
                                                <div class="flex flex-wrap gap-2">
                                                    <form action="{{ route('claims.verify', $claim) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="rounded-lg bg-green-700 px-4 py-2 text-xs font-semibold text-white hover:bg-green-800">Verify</button>
                                                    </form>
                                                    <form action="{{ route('claims.reject', $claim) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-xs font-semibold text-white hover:bg-red-700">Reject</button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-500">Processed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
