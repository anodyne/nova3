<x-auth-layout page-header="Reset your password">
    <x-panel variant="well">
        <x-panel>
            <x-spacing size="md">
                <x-form :action="route('password.update')">
                    <x-fieldset>
                        <x-fieldset.group>
                            <x-input.email
                                label="Email"
                                name="email"
                                :value="old('email')"
                                placeholder="john@example.com"
                                required
                                autofocus
                                autocomplete="email"
                            />

                            <x-input.password
                                label="Password"
                                name="password"
                                placeholder="Password"
                                required
                                autocomplete="new-password"
                            />

                            <x-input.password
                                label="Confirm Password"
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                required
                                autocomplete="off"
                            />
                        </x-fieldset.group>
                    </x-fieldset>

                    <x-fieldset>
                        <x-button type="submit" class="w-full" variant="primary">Reset password</x-button>
                        <input type="hidden" name="token" value="{{ request()->route('token') }}" />
                    </x-fieldset>
                </x-form>
            </x-spacing>
        </x-panel>

        <x-panel.footer>
            <div class="flex items-center justify-center">
                <x-link href="/">Back home</x-link>
            </div>
        </x-panel.footer>
    </x-panel>
</x-auth-layout>
