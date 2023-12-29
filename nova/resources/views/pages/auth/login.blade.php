@extends('layouts.auth-simple')

@section('page-header', 'Sign in to your account')

@section('content')
    <x-form :action="route('login')">
        <x-input.group label="Email" for="email" :error="$errors->first('email')">
            <x-input.email
                id="email"
                name="email"
                placeholder="john@example.com"
                :value="old('email')"
                data-cy="email"
                required
                autofocus
            >
                <x-slot name="leading">
                    <x-icon name="mail" size="md"></x-icon>
                </x-slot>
            </x-input.email>
        </x-input.group>

        <x-input.group label="Password" for="password">
            <x-input.password id="password" name="password" placeholder="Your password" data-cy="password" required>
                <x-slot name="leading">
                    <x-icon name="key" size="md"></x-icon>
                </x-slot>
            </x-input.password>
        </x-input.group>

        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center gap-x-2">
                <x-switch name="remember" id="remember"></x-switch>
                <x-fieldset.label for="remember">Remember me</x-fieldset.label>
            </div>

            <x-button :href="route('password.request')" color="neutral" text>Forgot your password?</x-button>
        </div>

        <div>
            <x-button type="submit" class="w-full" color="primary">Sign in</x-button>
        </div>
    </x-form>
@endsection
