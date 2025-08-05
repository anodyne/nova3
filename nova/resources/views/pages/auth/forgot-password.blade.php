<x-auth-layout page-header="Reset your password">
    @if (session('status'))
        <div
            class="border-warning-300 bg-warning-50 text-warning-600 mb-6 rounded-lg border px-4 py-3 font-medium md:text-sm"
            role="alert"
        >
            {{ session('status') }}
        </div>
    @endif

    <x-panel variant="well">
        <x-panel>
            <x-spacing size="md">
                <x-form :action="route('password.email')">
                    <x-fieldset>
                        @if (session('message'))
                            <x-fieldset.warning-message>
                                {{ session('message') }}
                            </x-fieldset.warning-message>
                        @else
                            <x-fieldset.description>
                                If you can’t remember your password, please provide your email address and we’ll send
                                you instructions onw how to reset your password.
                            </x-fieldset.description>
                        @endif

                        <x-fieldset.field-group>
                            <x-fieldset.field label="Email" id="email" name="email" :error="$errors->first('email')">
                                <x-input.email
                                    :value="old('email')"
                                    data-cy="email"
                                    placeholder="john@example.com"
                                    autocomplete="email"
                                />
                            </x-fieldset.field>
                        </x-fieldset.field-group>
                    </x-fieldset>

                    <x-fieldset>
                        <x-button type="submit" class="w-full" color="primary">Send reset link</x-button>
                    </x-fieldset>
                </x-form>
            </x-spacing>
        </x-panel>

        <x-panel.footer>
            <div class="flex items-center justify-center">
                <x-button href="/" text>Back home</x-button>
            </div>
        </x-panel.footer>
    </x-panel>
</x-auth-layout>
