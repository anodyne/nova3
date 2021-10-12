@extends($meta->template)

@section('page-header', 'Sign in to your account')

@section('content')
<x-form :action="route('login')" :divide="false">
    <x-input.group label="Email" for="email" :error="$errors->first('email')">
        <x-input.email id="email" name="email" :value="old('email')" data-cy="email" required autofocus />
    </x-input.group>

    <x-input.group label="Password" for="password">
        <x-input.password id="password" name="password" data-cy="password" required />
    </x-input.group>

    <div class="flex items-center justify-between text-sm">
        <x-input.checkbox label="Remember me" for="remember" id="remember" name="remember" class="h-4 w-4" />

        <div class="text-sm">
            <x-link :href="route('password.request')" color="blue-text" size="none">
                Forgot your password?
            </x-link>
        </div>
    </div>

    <div>
        <x-button type="submit" color="blue" full-width>
            Sign in
        </x-button>
    </div>
</x-form>

@env(['local', 'dev'])
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-6"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-gray-1 text-gray-11">
                    Or sign in with
                </span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-3">
            <div>
                <x-link :href="route('dev-login', 'admin@admin.com')" size="sm" full-width>Test Admin Account</x-link>
            </div>

            <div>
                <x-link :href="route('dev-login', 'user@user.com')" size="sm" full-width>Test User Account</x-link>
            </div>
        </div>
    </div>
@endenv
@endsection
