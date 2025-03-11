@use('Nova\Settings\Enums\ServerEnvironment')

<x-modal.slide-over title="Environment settings" icon="leaf">
    <x-form action="">
        <x-fieldset.field-group>
            <x-fieldset.field label="Environment" id="environment" name="environment">
                <flux:radio.group wire:model.live="form.environment" variant="segmented" data-slot="control">
                    @foreach (ServerEnvironment::cases() as $environment)
                        <flux:radio :value="$environment->value" :label="$environment->getLabel()" />
                    @endforeach
                </flux:radio.group>

                @if ($form->environment === ServerEnvironment::Local)
                    <x-slot name="description">
                        The local environment is intended only for development purposes. Some features may not work as
                        expected when operating in this mode.
                    </x-slot>
                @endif
            </x-fieldset.field>

            <x-switch.field>
                <x-fieldset.label for="form.debugMode">Debug mode</x-fieldset.label>
                <x-fieldset.description>
                    Enabling debug mode will allow informational messages, warnings, and errors to be displayed on
                    screen.

                    @if ($form->debugMode === true && $form->environment === ServerEnvironment::Production)
                        <x-fieldset.error-message class="mt-2 font-semibold">
                            In a production environment, debug mode should always be off. If debug mode is on in
                            production, you risk exposing sensitive configuration values to your end users.
                        </x-fieldset.error-message>
                    @endif
                </x-fieldset.description>
                <x-switch id="debugMode" name="debugMode" wire:model.live="form.debugMode"></x-switch>
            </x-switch.field>

            <x-fieldset.field
                label="Site URL"
                description="Use caution when changing your site’s URL as it could have unintended side effects."
                id="url"
                name="url"
            >
                <x-input.text wire:model.blur="form.url" placeholder="Update your site URL"></x-input.text>
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-form>

    <x-slot name="footer">
        <x-button wire:click="save" color="primary">Update</x-button>
        <x-button wire:click="close" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
