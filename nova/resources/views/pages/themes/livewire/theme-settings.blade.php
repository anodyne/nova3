<x-modal.slide-over>
    <x-slot name="title">{{ $theme?->name }} theme settings</x-slot>

    <x-form action="">
        <x-fieldset>
            <x-fieldset.heading>
                <x-icon :name="Icon::Typography"></x-icon>
                <x-fieldset.legend>Fonts</x-fieldset.legend>
                <x-fieldset.description>Customize the theme by changing the fonts used.</x-fieldset.description>
            </x-fieldset.heading>

            <x-fieldset.field-group constrained>
                <x-fieldset.field label="Public headers font" id="public_font_header" name="public_font_header">
                    <livewire:settings-font-selector
                        section="public"
                        type="header"
                        :family="$theme->settings->fonts->headerFamily"
                        :provider="$theme->settings->fonts->headerProvider"
                        @font-updated="fontUpdated($event.detail.data)"
                    />
                </x-fieldset.field>

                <x-fieldset.field label="Public body font" id="public_font_body" name="public_font_body">
                    <livewire:settings-font-selector
                        section="public"
                        type="body"
                        :family="$theme->settings->fonts->bodyFamily"
                        :provider="$theme->settings->fonts->bodyProvider"
                        @font-updated="fontUpdated($event.detail.data)"
                    />
                </x-fieldset.field>
            </x-fieldset.field-group>
        </x-fieldset>

        @if ($theme->settings->hasSettings())
            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon :name="Icon::Preferences"></x-icon>
                    <x-fieldset.legend>Additional theme settings</x-fieldset.legend>
                    <x-fieldset.description>Customize various options for the theme.</x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    {{ $this->form }}
                </x-fieldset.field-group>
            </x-fieldset>
        @endif
    </x-form>

    <x-slot name="footer">
        <x-button type="button" wire:click="save" color="primary">Update</x-button>
        <x-button type="button" wire:click="close" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
