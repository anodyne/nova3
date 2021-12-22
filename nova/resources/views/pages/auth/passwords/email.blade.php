@extends($meta->template)

@section('page-header', 'Reset your password')

@section('content')
    @if (session('status'))
        <div class="rounded-lg bg-yellow-3 border border-yellow-6 text-yellow-11 px-4 py-3 font-medium md:text-sm mb-6" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (session('message'))
        <div class="flex space-x-3 text-yellow-11 font-medium mb-6" role="alert">
            @icon('alert', 'h-8 w-8 shrink-0 text-yellow-9')
            <span>{{ session('message') }}</span>
        </div>
    @else
        <p class="text-gray-11 mb-6">If you can't remember your password, please provide your email address and we will send you a link which you may use to change your password.</p>
    @endif

    <x-form :action="route('password.email')" :divide="false">
        <x-input.group label="Email" for="email" :error="$errors->first('email')">
            <x-input.email id="email" name="email" :value="old('email')" data-cy="email" placeholder="john@example.com" required />
        </x-input.group>

        <x-button type="submit" color="blue" full-width data-cy="submit">
            {{ __('Send Reset Link') }}
        </x-button>
    </x-form>
@endsection
