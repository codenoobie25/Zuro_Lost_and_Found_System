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

                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <p class="text-sm font-medium text-gray-600">{{ __('Found Items') }}</p>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $foundItems ?? '2' }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ __('In inventory') }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <p class="text-sm font-medium text-gray-600">{{ __('Pending Claims') }}</p>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-orange-100 text-orange-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $pendingClaims ?? '1' }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Awaiting verification') }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <p class="text-sm font-medium text-gray-600">{{ __('Verified Claims') }}</p>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $verifiedClaims ?? '0' }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Ready for pickup') }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <p class="text-sm font-medium text-gray-600">{{ __('Total Items') }}</p>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $totalItems ?? '3' }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ __('All items tracked') }}</p>
                    </div>

                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Quick Actions') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Common tasks for your role') }}</p>

                    <div class="mt-6 grid gap-4 md:grid-cols-3">
                        
                        <a href="{{ route('staff.report-found') }}" class="rounded-xl border border-gray-200 p-5 transition hover:border-gray-300 hover:bg-gray-50">
                            <h4 class="text-md font-semibold text-gray-900">{{ __('Report Found Item') }}</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Log a newly found item') }}</p>
                        </a>

                        <a href="{{ route('staff.verify-claims') }}" class="rounded-xl border border-gray-200 p-5 transition hover:border-gray-300 hover:bg-gray-50">
                            <h4 class="text-md font-semibold text-gray-900">{{ __('Verify Claims') }}</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Review pending claims') }}</p>
                        </a>

                        <a href="{{ route('admin.inventory') }}" class="rounded-xl border border-gray-200 p-5 transition hover:border-gray-300 hover:bg-gray-50">
                            <h4 class="text-md font-semibold text-gray-900">{{ __('Manage Inventory') }}</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ __('View and update items') }}</p>
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout> 