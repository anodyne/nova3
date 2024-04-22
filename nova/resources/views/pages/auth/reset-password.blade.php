@extends('layouts.auth-simple')

@section('page-header', 'Reset your password')

@section('content')
    <x-panel well>
        <x-spacing size="2xs">
            <x-panel>
                <x-spacing size="md">
                    <x-form :action="route('password.update')">
                        <x-fieldset>
                            <x-fieldset.field-group>
                                <x-fieldset.field
                                    label="Email"
                                    id="email"
                                    name="email"
                                    :error="$errors->first('email')"
                                >
                                    <x-input.email
                                        :value="old('email')"
                                        placeholder="john@example.com"
                                        data-cy="email"
                                        required
                                        autofocus
                                    />
                                </x-fieldset.field>

                                <x-fieldset.field
                                    label="Password"
                                    id="password"
                                    name="password"
                                    :error="$errors->first('password')"
                                >
                                    <x-input.password placeholder="Password" data-cy="password" required />
                                </x-fieldset.field>

                                <x-fieldset.field
                                    label="Confirm Password"
                                    id="password-confirm"
                                    name="password_confirmation"
                                    :error="$errors->first('password-confirm')"
                                >
                                    <x-input.password
                                        placeholder="Confirm your password"
                                        data-cy="password-confirm"
                                        required
                                    />
                                </x-fieldset.field>
                            </x-fieldset.field-group>
                        </x-fieldset>

                        <x-fieldset>
                            <x-button type="submit" class="w-full" color="primary">Reset password</x-button>
                            <input type="hidden" name="token" value="{{ request()->route('token') }}" />
                        </x-fieldset>
                    </x-form>
                </x-spacing>
            </x-panel>
        </x-spacing>

        <x-spacing width="sm" top="2xs" bottom="sm">
            <div class="flex items-center justify-center">
                <x-button href="/" text>Back home</x-button>
            </div>
        </x-spacing>
    </x-panel>
@endsection
