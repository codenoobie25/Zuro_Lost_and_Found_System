<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/sytle.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Reports') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl bg-gradient-to-r from-violet-700 via-fuchsia-600 to-rose-600 p-8 text-white shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight">{{ __('Reports') }}</h1>
                        <p class="mt-2 text-lg text-white/85">{{ __('Comprehensive insights reports into Zoru operations') }}</p>
                    </div>

                    <a href="{{ route('admin.reports.export') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-semibold text-violet-700 transition hover:bg-violet-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" />
                        </svg>
                        {{ __('Export PDF') }}
                    </a>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('Total Items') }}</p>
                            <p class="mt-2 text-4xl font-bold text-blue-600">{{ $totalItems }}</p>
                            <p class="mt-1 text-xs text-gray-400">{{ __(':found found, :lost lost', ['found' => $foundItems, 'lost' => $lostItems]) }}</p>
                        </div>
                        <span class="text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('Total Claims') }}</p>
                            <p class="mt-2 text-4xl font-bold text-violet-600">{{ $pendingClaims + $verifiedClaims + $rejectedClaims }}</p>
                            <p class="mt-1 text-xs text-gray-400">{{ __(':pending pending review', ['pending' => $pendingClaims]) }}</p>
                        </div>
                        <span class="text-violet-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5-5v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2h5l2 2h5a2 2 0 012 2z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('Total Users') }}</p>
                            <p class="mt-2 text-4xl font-bold text-emerald-600">{{ $totalUsers }}</p>
                            <p class="mt-1 text-xs text-gray-400">{{ __(':staff staff, :admins admins', ['staff' => $staffUsers, 'admins' => $adminUsers]) }}</p>
                        </div>
                        <span class="text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V9a2 2 0 00-2-2h-3m-3 13H9m4 0v-5a2 2 0 00-2-2H7a2 2 0 00-2 2v5m4 0H5m12-10a2 2 0 100-4 2 2 0 000 4zM7 10a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('Success Rate') }}</p>
                            <p class="mt-2 text-4xl font-bold text-orange-500">{{ number_format($successRate, 1) }}%</p>
                            <p class="mt-1 text-xs text-gray-400">{{ __('Claims verified') }}</p>
                        </div>
                        <span class="text-orange-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 19l6-6 4 4 6-6" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Item Status Distribution') }}</h3>
                    <div class="mt-6 grid grid-cols-2 gap-4 text-sm">
                        <div class="col-span-2 flex items-center justify-center rounded-xl bg-gray-50 p-6">
                            <div class="h-48 w-48 rounded-full border border-gray-200 bg-[conic-gradient(#ef4444_0_33%,#3b82f6_33%_100%)]"></div>
                        </div>
                        <div class="text-center text-red-500">{{ __('Lost: :count', ['count' => $lostItems]) }}</div>
                        <div class="text-center text-blue-500">{{ __('Found: :count', ['count' => $foundItems]) }}</div>
                        <div class="text-center text-amber-500">{{ __('Claimed: :count', ['count' => $claimedItems]) }}</div>
                        <div class="text-center text-emerald-500">{{ __('Returned: :count', ['count' => $itemsReturned]) }}</div>
                    </div>
                    <div class="mt-5 flex flex-wrap gap-4 text-sm">
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-red-500"></span>{{ __('Lost') }}</span>
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-blue-500"></span>{{ __('Found') }}</span>
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-amber-500"></span>{{ __('Claimed') }}</span>
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-emerald-500"></span>{{ __('Returned') }}</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Claim Status Distribution') }}</h3>
                    <div class="mt-6 grid grid-cols-2 gap-4 text-sm">
                        <div class="col-span-2 flex items-center justify-center rounded-xl bg-gray-50 p-6">
                            <div class="h-48 w-48 rounded-full border border-gray-200 bg-[conic-gradient(#f59e0b_0_100%)]"></div>
                        </div>
                        <div class="text-center text-amber-500">{{ __('Pending: :count', ['count' => $pendingClaims]) }}</div>
                        <div class="text-center text-emerald-500">{{ __('Verified: :count', ['count' => $verifiedClaims]) }}</div>
                        <div class="text-center text-red-500">{{ __('Rejected: :count', ['count' => $rejectedClaims]) }}</div>
                    </div>
                    <div class="mt-5 flex flex-wrap gap-4 text-sm">
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-amber-500"></span>{{ __('Pending') }}</span>
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-emerald-500"></span>{{ __('Verified') }}</span>
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-red-500"></span>{{ __('Rejected') }}</span>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Items by Category') }}</h3>
                    <div class="mt-6 flex items-end gap-4 rounded-xl bg-gray-50 p-6" style="min-height: 260px;">
                        @php $maxCategory = max(1, collect($itemCategories)->max('count')); @endphp
                        @foreach ($itemCategories as $category)
                            <div class="flex flex-1 flex-col items-center gap-2">
                                <div class="w-full rounded-t-xl bg-violet-500" style="height: {{ max(40, (int) (($category['count'] / $maxCategory) * 180)) }}px;"></div>
                                <span class="text-xs text-gray-500">{{ $category['name'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('7-Day Activity Trend') }}</h3>
                    <div class="mt-6 rounded-xl bg-gray-50 p-6">
                        <div class="flex items-end gap-3" style="min-height: 260px;">
                            @php $maxActivity = max(1, max(collect($activityItems)->max(), collect($activityClaims)->max())); @endphp
                            @foreach ($activityLabels as $index => $label)
                                <div class="flex flex-1 flex-col items-center justify-end gap-3">
                                    <div class="flex w-full flex-col items-center gap-2">
                                        <div class="h-2 w-2 rounded-full bg-violet-500"></div>
                                        <div class="w-full rounded-t-lg bg-violet-400/70" style="height: {{ max(8, (int) (($activityItems[$index] / $maxActivity) * 52)) }}px;"></div>
                                        <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                                        <div class="w-full rounded-t-lg bg-blue-400/70" style="height: {{ max(8, (int) (($activityClaims[$index] / $maxActivity) * 52)) }}px;"></div>
                                    </div>
                                    <span class="text-[10px] text-gray-500">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                            <span class="inline-flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-violet-500"></span>{{ __('items') }}</span>
                            <span class="inline-flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-blue-500"></span>{{ __('claims') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border border-amber-100 bg-amber-50 p-5 shadow-sm">
                    <p class="text-sm text-amber-500">{{ __('Pending Claims') }}</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $pendingClaims }}</p>
                </div>
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-5 shadow-sm">
                    <p class="text-sm text-emerald-500">{{ __('Items Returned') }}</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $itemsReturned }}</p>
                </div>
                <div class="rounded-2xl border border-red-100 bg-red-50 p-5 shadow-sm">
                    <p class="text-sm text-red-500">{{ __('Active Lost Items') }}</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $activeLostItems }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
