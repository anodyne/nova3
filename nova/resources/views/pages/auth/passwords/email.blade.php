@extends($__novaTemplate)

@section('page-header', 'Reset your password')

@section('content')
    @if (session('status'))
        <div class="rounded font-semibold bg-sucess-200 border-2 border-success-300 text-success-700 mb-6" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (session('message'))
        <div class="alert alert-warning" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <p class="text-gray-700 mb-6">If you can't remember your password, please provide your email address and we will send you a link which you may use to change your password.</p>

    <x-form :action="route('password.email')" :divide="false">
        <x-input.group label="Email" for="email" :error="$errors->first('email')">
            <x-input.email id="email" class="form-field" name="email" :value="old('email')" data-cy="email" placeholder="john@example.com" required />
        </x-input.group>

        <x-button type="submit" color="blue" :full-width="true" data-cy="submit">
            {{ __('Send Reset Link') }}
        </x-button>
    </x-form>
@endsection