<x-auth-layout page-header="Sign in to your account">
    <x-panel variant="well">
        <x-panel>
            <x-spacing size="md">
                <x-form :action="route('login')">
                    <x-fieldset>
                        <x-fieldset.group>
                            <x-input.email
                                label="Email"
                                name="email"
                                :value="old('email')"
                                placeholder="john@example.com"
                                autocomplete="email"
                            />

                            <x-input.password label="Password" name="password" placeholder="Your password" />

                            <x-switch label="Remember me" name="remember" align="left" />
                        </x-fieldset.group>
                    </x-fieldset>

                    <x-fieldset>
                        <x-fieldset.group>
                            <x-button type="submit" class="w-full" variant="primary">Sign in</x-button>
                        </x-fieldset.group>
                    </x-fieldset>
                </x-form>
            </x-spacing>
        </x-panel>

        <x-panel.footer class="flex items-center justify-center">
            <x-button :href="route('password.request')" variant="subtle" inset="top bottom">
                Forgot your password?
            </x-button>
        </x-panel.footer>
    </x-panel>
</x-auth-layout>
