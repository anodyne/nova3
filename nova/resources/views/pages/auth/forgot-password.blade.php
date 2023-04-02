@extends('layouts.auth-simple')

@section('page-header', 'Reset your password')

@section('content')
    @if (session('status'))
        <div class="rounded-lg bg-warning-50 border border-warning-300 text-warning-600 px-4 py-3 font-medium md:text-sm mb-6" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (session('message'))
        <div class="flex space-x-3 text-warning-600 font-medium mb-6" role="alert">
            @icon('alert', 'h-8 w-8 shrink-0 text-warning-500')
            <span>{{ session('message') }}</span>
        </div>
    @else
        <p class="text-gray-600 mb-6">If you can't remember your password, please provide your email address and we will send you a link which you may use to change your password.</p>
    @endif

    <x-form :action="route('password.email')" :divide="false">
        <x-input.group label="Email" for="email" :error="$errors->first('email')">
            <x-input.email id="email" name="email" :value="old('email')" data-cy="email" placeholder="john@example.com" required />
        </x-input.group>

        <x-button-filled type="submit" class="w-full" data-cy="submit">
            {{ __('Send Reset Link') }}
        </x-button-filled>
    </x-form>
@endsection
