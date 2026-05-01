<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/sytle.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">
                @if (session('status'))
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div>
                            <div class="admin_title_manage_users">
                                {{ __('Manage Users') }}
                            </div>
                            <p class="admin_subtitle_manage_users">
                                {{ __('Create, edit, and manage user accounts') }}
                            </p>
                        </div>

                        <button type="button"
                            class="inline-flex items-center gap-2 rounded-lg bg-green-700 px-4 py-2 text-sm font-medium text-white opacity-60 cursor-not-allowed"
                            title="Add user flow is not configured yet" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 9v6m3-3h-6M5 20h8a2 2 0 002-2v-1a4 4 0 00-4-4H9a4 4 0 00-4 4v1a2 2 0 002 2zm4-14a4 4 0 110 8 4 4 0 010-8z" />
                            </svg>
                            {{ __('Add User') }}
                        </button>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-4">
                        <h3 class="text-2xl font-semibold text-gray-900">{{ __('All Users') }} ({{ $users->count() }})</h3>
                        <p class="text-gray-500">{{ __('Manage user accounts and permissions') }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left text-sm font-medium text-gray-700">
                                    <th class="px-4 py-3">{{ __('Name') }}</th>
                                    <th class="px-4 py-3">{{ __('Username') }}</th>
                                    <th class="px-4 py-3">{{ __('Email') }}</th>
                                    <th class="px-4 py-3">{{ __('Role') }}</th>
                                    <th class="px-4 py-3">{{ __('Created') }}</th>
                                    <th class="px-4 py-3">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-4 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-4">{{ \Illuminate\Support\Str::before($user->email, '@') }}</td>
                                        <td class="px-4 py-4">{{ $user->email }}</td>
                                        <td class="px-4 py-4">
                                            @php
                                                $isCurrentUser = auth()->id() === $user->id;
                                                $badgeClasses = match ($user->role) {
                                                    'admin' => 'bg-violet-100 text-violet-700',
                                                    'staff' => 'bg-blue-100 text-blue-700',
                                                    default => 'bg-gray-100 text-gray-700',
                                                };
                                            @endphp

                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $badgeClasses }}">
                                                    {{ $user->role }}
                                                </span>

                                                <form method="POST" action="{{ route('admin.users.role.update', $user) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="role"
                                                        class="rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        onchange="this.form.submit()" @disabled($isCurrentUser)>
                                                        <option value="admin" @selected($user->role === 'admin')>admin</option>
                                                        <option value="staff" @selected($user->role === 'staff')>staff</option>
                                                        <option value="user" @selected($user->role === 'user')>user</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">{{ $user->created_at->format('n/j/Y') }}</td>
                                        <td class="px-4 py-4">
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex rounded p-1.5 text-red-600 hover:bg-red-50"
                                                    onclick="return confirm('Delete this account?')" @disabled($isCurrentUser)
                                                    title="Delete account">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 7h12M9 7V5h6v2m-7 4v6m4-6v6m4-6v6M7 7l1 12h8l1-12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">{{ __('No users found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
