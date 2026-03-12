@use('Nova\Settings\Enums\ServerEnvironment')

<x-modal.slide-over title="Environment settings" color="success" :icon="Tabler::Leaf">
    <x-form action="">
        <x-fieldset.group>
            <x-radio.group label="Environment" wire:model.live="form.environment" variant="segmented">
                @foreach (ServerEnvironment::cases() as $environment)
                    <x-radio :value="$environment->value" :label="$environment->getLabel()" />
                @endforeach
            </x-radio.group>

            @if ($form->environment === ServerEnvironment::Local)
                <x-callout.warning>
                    The local environment is intended only for development purposes. Some features may not work as
                    expected when operating in this mode.
                </x-callout.warning>
            @endif

            <x-switch
                label="Debug mode"
                description="Enabling debug mode will allow informational messages, warnings, and errors to be displayed on screen"
                wire:model.live="form.debugMode"
            />

            @if ($form->debugMode === true && $form->environment === ServerEnvironment::Production)
                <x-callout.danger>
                    In a production environment, debug mode should always be off. If debug mode is on in production, you
                    risk exposing sensitive configuration values to your end users.
                </x-callout.danger>
            @endif

            <x-input
                label="Site URL"
                description="Use caution when changing your site’s URL as it could have unintended side effects"
                wire:model.blur="form.url"
                placeholder="Update your site URL"
            />
        </x-fieldset.group>
    </x-form>

    <x-slot name="footer">
        <x-button wire:click="save" variant="primary">Update</x-button>
        <x-button wire:click="close" variant="ghost" :loading="false">Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
