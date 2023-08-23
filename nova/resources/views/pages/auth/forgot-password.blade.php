@extends('layouts.auth-simple')

@section('page-header', 'Reset your password')

@section('content')
    @if (session('status'))
        <div
            class="mb-6 rounded-lg border border-warning-300 bg-warning-50 px-4 py-3 font-medium text-warning-600 md:text-sm"
            role="alert"
        >
            {{ session('status') }}
        </div>
    @endif

    @if (session('message'))
        <div class="mb-6 flex space-x-3 font-medium text-warning-600" role="alert">
            <x-icon name="alert" size="xl" class="shrink-0 text-warning-500"></x-icon>
            <span>{{ session('message') }}</span>
        </div>
    @else
        <p class="mb-6 text-gray-600">
            If you can't remember your password, please provide your email address and we will send you a link which you
            may use to change your password.
        </p>
    @endif

    <x-form :action="route('password.email')" :divide="false">
        <x-input.group label="Email" for="email" :error="$errors->first('email')">
            <x-input.email
                id="email"
                name="email"
                :value="old('email')"
                data-cy="email"
                placeholder="john@example.com"
                required
            />
        </x-input.group>

        <x-button.filled type="submit" class="w-full" color="primary">
            {{ __('Send Reset Link') }}
        </x-button.filled>
    </x-form>
@endsection
