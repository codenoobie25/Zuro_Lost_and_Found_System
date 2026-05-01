<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="pb-2">
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ __('Welcome, :name!', ['name' => auth()->user()->name ?? 'Staff Member']) }}
                    </h1>
                    <p class="mt-2 text-gray-500">{{ __('Manage found items, verify claims, and maintain inventory.') }}</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-600">{{ __('Total Items') }}</p>
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-8 text-4xl font-bold text-gray-900">{{ $totalItems }}</p>
                        <p class="mt-2 text-gray-500">{{ __('All items in system') }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-600">{{ __('Lost Items') }}</p>
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-100 text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-8 text-4xl font-bold text-gray-900">{{ $lostItems }}</p>
                        <p class="mt-2 text-gray-500">{{ __('Reported as lost') }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-600">{{ __('Found Items') }}</p>
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-8 text-4xl font-bold text-gray-900">{{ $foundItemsWaitingClaim }}</p>
                        <p class="mt-2 text-gray-500">{{ __('Waiting to be claimed') }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-600">{{ __('Total Users') }}</p>
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-violet-100 text-violet-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V9a2 2 0 00-2-2h-3m-3 13H9m4 0v-5a2 2 0 00-2-2H7a2 2 0 00-2 2v5m4 0H5m12-10a2 2 0 100-4 2 2 0 000 4zM7 10a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-8 text-4xl font-bold text-gray-900">{{ $totalUsers }}</p>
                        <p class="mt-2 text-gray-500">{{ __('Registered users') }}</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-2xl font-semibold text-gray-900">{{ __('Quick Actions') }}</h3>
                    <p class="mt-2 text-gray-500">{{ __('Common tasks for your role') }}</p>

                    <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <a href="{{ route('admin.search-items') }}" class="rounded-2xl border border-gray-200 p-5 transition hover:border-gray-300 hover:bg-gray-50">
                            <h4 class="text-xl font-semibold text-gray-900">{{ __('Search Items') }}</h4>
                            <p class="mt-2 text-gray-500">{{ __('Find any item in the system') }}</p>
                        </a>

                        <a href="{{ route('admin.inventory') }}" class="rounded-2xl border border-gray-200 p-5 transition hover:border-gray-300 hover:bg-gray-50">
                            <h4 class="text-xl font-semibold text-gray-900">{{ __('Inventory') }}</h4>
                            <p class="mt-2 text-gray-500">{{ __('View and manage all items') }}</p>
                        </a>

                        <a href="{{ route('admin.manage-users') }}" class="rounded-2xl border border-gray-200 p-5 transition hover:border-gray-300 hover:bg-gray-50">
                            <h4 class="text-xl font-semibold text-gray-900">{{ __('Manage Users') }}</h4>
                            <p class="mt-2 text-gray-500">{{ __('Add or edit user accounts') }}</p>
                        </a>

                        <a href="{{ route('admin.reports') }}" class="rounded-2xl border border-gray-200 p-5 transition hover:border-gray-300 hover:bg-gray-50 md:col-span-2 xl:col-span-1">
                            <h4 class="text-xl font-semibold text-gray-900">{{ __('Reports') }}</h4>
                            <p class="mt-2 text-gray-500">{{ __('View system reports') }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
