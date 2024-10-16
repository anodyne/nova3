<x-auth-layout page-header="Reset your password">
    @if (session('status'))
        <div
            class="mb-6 rounded-lg border border-warning-300 bg-warning-50 px-4 py-3 font-medium text-warning-600 md:text-sm"
            role="alert"
        >
            {{ session('status') }}
        </div>
    @endif

    <x-panel well>
        <x-spacing size="2xs">
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
                                    If you can’t remember your password, please provide your email address and we’ll
                                    send you instructions onw how to reset your password.
                                </x-fieldset.description>
                            @endif

                            <x-fieldset.field-group>
                                <x-fieldset.field
                                    label="Email"
                                    id="email"
                                    name="email"
                                    :error="$errors->first('email')"
                                >
                                    <x-input.email
                                        :value="old('email')"
                                        data-cy="email"
                                        placeholder="john@example.com"
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
        </x-spacing>

        <x-spacing width="sm" top="2xs" bottom="sm">
            <div class="flex items-center justify-center">
                <x-button href="/" text>Back home</x-button>
            </div>
        </x-spacing>
    </x-panel>
</x-auth-layout>
