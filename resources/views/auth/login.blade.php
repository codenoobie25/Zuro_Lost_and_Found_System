<x-guest-layout :show-logo="false">
    <div class="w-full sm:max-w-md mx-auto px-6 py-8 bg-white shadow-sm overflow-hidden sm:rounded-2xl border border-gray-200">
        
        <div class="text-center mb-8">
            <div class="flex justify-center mb-5">
                <a href="/" class="inline-flex items-center justify-center rounded-2xl bg-gray-50 p-3 shadow-sm ring-1 ring-gray-200">
                    <x-application-logo class="w-16 h-16 fill-current text-gray-500" />
                </a>
            </div>

            <h2 class="mt-4 text-2xl font-bold text-gray-900">
                {{ __('Sign in to Zoru') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ __('Enter your details to access your account.') }}
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" required autofocus class="w-full rounded-xl bg-gray-50 border-gray-200 focus:border-[#4a6b41] focus:bg-white focus:ring-[#4a6b41] px-4 py-3 text-sm text-gray-900">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required class="w-full rounded-xl bg-gray-50 border-gray-200 focus:border-[#4a6b41] focus:bg-white focus:ring-[#4a6b41] px-4 py-3 text-sm text-gray-900">
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#4a6b41] shadow-sm focus:ring-[#4a6b41]" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-[#4a6b41] hover:text-[#3a5433] transition" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-[#4a6b41] hover:bg-[#3a5433] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4a6b41] transition">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm text-gray-600">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="font-bold text-[#4a6b41] hover:text-[#3a5433] hover:underline transition">
                {{ __('Create one here') }}
            </a>
        </div>

    </div>
</x-guest-layout>