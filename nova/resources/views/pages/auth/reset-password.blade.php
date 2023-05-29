@extends('layouts.auth-simple')

@section('page-header', 'Reset your password')

@section('content')
    <x-form :action="route('password.update')" :divide="false">
        <x-input.group label="Email" for="email" :error="$errors->first('email')">
            <x-input.email id="email" name="email" :value="old('email', $email)" placeholder="john@example.com" data-cy="email" required autofocus />
        </x-input.group>

        <x-input.group label="Password" for="password" :error="$errors->first('password')">
            <x-input.password id="password" name="password" placeholder="Password" data-cy="password" required />
        </x-input.group>

        <x-input.group label="Confirm Password" for="password-confirm" :error="$errors->first('password-confirm')">
            <x-input.password id="password-confirm" name="password_confirmation" placeholder="Confirm your password" data-cy="password-confirm" required />
        </x-input.group>

        <x-button.filled type="submit" class="w-full">
            {{ __('Reset Password') }}
        </x-button.filled>

        <input type="hidden" name="token" value="{{ $token }}">
    </x-form>
@endsection
