<x-auth-layout page-header="Sign in to your account">
    <x-panel variant="well">
        <x-panel>
            <x-spacing size="md">
                <x-form :action="route('login')">
                    <x-fieldset>
                        <x-fieldset.field-group>
                            <x-fieldset.field label="Email" id="email" name="email" :error="$errors->first('email')">
                                <x-input.email
                                    placeholder="john@example.com"
                                    :value="old('email')"
                                    autocomplete="email"
                                    required
                                    autofocus
                                ></x-input.email>
                            </x-fieldset.field>

                            <x-fieldset.field label="Password" id="password" name="password">
                                <x-input.password
                                    placeholder="Your password"
                                    autocomplete="current-password"
                                    required
                                ></x-input.password>
                            </x-fieldset.field>

                            <flux:field variant="inline">
                                <flux:switch name="remember" id="remember"></flux:switch>
                                <flux:label>Remember me</flux:label>
                            </flux:field>
                        </x-fieldset.field-group>
                    </x-fieldset>

                    <x-fieldset>
                        <x-fieldset.field-group>
                            <x-button type="submit" class="w-full" color="primary">Sign in</x-button>
                        </x-fieldset.field-group>
                    </x-fieldset>
                </x-form>
            </x-spacing>
        </x-panel>

        <x-panel.footer class="flex items-center justify-center">
            <x-button :href="route('password.request')" text>Forgot your password?</x-button>
        </x-panel.footer>
    </x-panel>
</x-auth-layout>
