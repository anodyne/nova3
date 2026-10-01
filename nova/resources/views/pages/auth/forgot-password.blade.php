<x-auth-layout page-header="Reset your password">
    @if (session('status'))
        <flux:callout variant="warning" :heading="session('status')"/>
    @endif

    <flux:card size="lg">
        <flux:card.body>
            <x-form :action="route('password.email')">
                <x-fieldset>
                    @if (session('message'))
                        <x-description.warning>
                            {{ session('message') }}
                        </x-description.warning>
                    @else
                        <x-description>
                            If you can’t remember your password, please provide your email address and we’ll send
                            you instructions onw how to reset your password.
                        </x-description>
                    @endif

                    <x-fieldset.group>
                        <x-input.email
                            label="Email"
                            name="email"
                            :value="old('email')"
                            placeholder="john@example.com"
                            autocomplete="email"
                        />
                    </x-fieldset.group>
                </x-fieldset>

                <x-fieldset>
                    <x-button type="submit" class="w-full" variant="primary">Send reset link</x-button>
                </x-fieldset>
            </x-form>
        </flux:card.body>

        <flux:card.footer>
            <x-button href="/" variant="subtle" inset="top">
                Back home
            </x-button>
        </flux:card.footer>
    </flux:card>
</x-auth-layout>
