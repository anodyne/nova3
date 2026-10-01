<x-auth-layout page-header="Sign in to your account">
    <flux:card size="lg">
        <flux:card.body>
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

                        <x-input.password label="Password" name="password" placeholder="Your password"/>

                        <x-switch label="Remember me" name="remember" align="left"/>
                    </x-fieldset.group>
                </x-fieldset>

                <x-fieldset>
                    <x-fieldset.group>
                        <x-button type="submit" class="w-full" variant="primary">Sign in</x-button>
                    </x-fieldset.group>
                </x-fieldset>
            </x-form>
        </flux:card.body>

        <flux:card.footer>
            <x-button :href="route('password.request')" variant="subtle" inset="top">
                Forgot your password?
            </x-button>
        </flux:card.footer>
    </flux:card>
</x-auth-layout>
