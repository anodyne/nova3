@extends($__novaTemplate)

@section('page-header', 'Reset your password')

@section('content')
    <x-form :action="route('password.update')" :divide="false">
        <x-input.group label="Email" for="email" :error="$errors->first('email')">
            <x-input.email id="email" class="form-field" name="email" :value="old('email', $email)" placeholder="john@example.com" data-cy="email" required autofocus />
        </x-input.group>

        <x-input.group label="Password" for="password" :error="$errors->first('password')">
            <x-input.password id="password" class="form-field" name="password" placeholder="Password" data-cy="password" required />
        </x-input.group>

        <x-input.group label="Confirm Password" for="password-confirm" :error="$errors->first('password-confirm')">
            <x-input.password id="password-confirm" class="form-field" name="password_confirmation" placeholder="Confirm your password" data-cy="password-confirm" required />
        </x-input.group>

        <x-button type="submit" color="blue" :full-width="true" data-cy="submit">
            {{ __('Reset Password') }}
        </x-button>

        <input type="hidden" name="token" value="{{ $token }}">
    </x-form>
@endsection