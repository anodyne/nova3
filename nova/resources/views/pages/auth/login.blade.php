@extends('layouts.auth-simple')

@section('page-header', 'Sign in to your account')

@section('content')
    <x-form :action="route('login')">
        <x-fieldset>
            <x-fieldset.field-group>
                <x-fieldset.field label="Email" id="email" name="email" :error="$errors->first('email')">
                    <x-input.email
                        placeholder="john@example.com"
                        :value="old('email')"
                        data-cy="email"
                        required
                        autofocus
                    ></x-input.email>
                </x-fieldset.field>

                <x-fieldset.field label="Password" id="password" name="password">
                    <x-input.password placeholder="Your password" data-cy="password" required></x-input.password>
                </x-fieldset.field>

                <div class="flex items-center gap-x-2.5">
                    <x-switch name="remember" id="remember"></x-switch>
                    <x-fieldset.label for="status">Remember me</x-fieldset.label>
                </div>
            </x-fieldset.field-group>
        </x-fieldset>

        <x-fieldset>
            <x-fieldset.field-group>
                <x-button type="submit" class="w-full" color="primary">Sign in</x-button>
                <div class="flex items-center justify-center">
                    <x-button :href="route('password.request')" color="neutral" text>Forgot your password?</x-button>
                </div>
            </x-fieldset.field-group>
        </x-fieldset>
    </x-form>
@endsection
