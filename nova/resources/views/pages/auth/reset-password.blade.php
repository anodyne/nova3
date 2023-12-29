@extends('layouts.auth-simple')

@section('page-header', 'Reset your password')

@section('content')
    <x-form :action="route('password.update')">
        <x-input.group label="Email" for="email" :error="$errors->first('email')">
            <x-input.email
                id="email"
                name="email"
                :value="old('email')"
                placeholder="john@example.com"
                data-cy="email"
                required
                autofocus
            />
        </x-input.group>

        <x-input.group label="Password" for="password" :error="$errors->first('password')">
            <x-input.password id="password" name="password" placeholder="Password" data-cy="password" required />
        </x-input.group>

        <x-input.group label="Confirm Password" for="password-confirm" :error="$errors->first('password-confirm')">
            <x-input.password
                id="password-confirm"
                name="password_confirmation"
                placeholder="Confirm your password"
                data-cy="password-confirm"
                required
            />
        </x-input.group>

        <x-button type="submit" class="w-full" color="primary">
            {{ __('Reset Password') }}
        </x-button>

        <input type="hidden" name="token" value="{{ request()->route('token') }}" />
    </x-form>
@endsection
