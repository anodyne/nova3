<x-modal.slide-over :size-class="$this->sizeClass()">
    <x-slot name="title">{{ $theme?->name }} theme settings</x-slot>

    <x-form action="">
        <x-fieldset>
            <x-fieldset.heading :icon="Tabler::Typography" heading="Fonts">
                <x-description>Customize the theme by changing the fonts used.</x-description>
            </x-fieldset.heading>

            <x-fieldset.group constrained>
                <x-field>
                    <x-label>Public headers font</x-label>
                    <div>
                        <livewire:settings-font-selector
                            section="public"
                            type="header"
                            :family="$theme->settings->fonts->headerFamily"
                            :provider="$theme->settings->fonts->headerProvider"
                            @font-updated="fontUpdated($event.detail.data)"
                        />
                    </div>
                </x-field>

                <x-field>
                    <x-label>Public body font</x-label>
                    <div>
                        <livewire:settings-font-selector
                            section="public"
                            type="body"
                            :family="$theme->settings->fonts->bodyFamily"
                            :provider="$theme->settings->fonts->bodyProvider"
                            @font-updated="fontUpdated($event.detail.data)"
                        />
                    </div>
                </x-field>
            </x-fieldset.group>
        </x-fieldset>

        @if ($theme->settings->hasSettings())
            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Adjustments" heading="Additional theme settings">
                    <x-description>Customize various options for the theme.</x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    {{ $this->form }}
                </x-fieldset.group>
            </x-fieldset>
        @endif
    </x-form>

    <x-slot name="footer">
        <x-button type="button" wire:click="save" variant="primary">Update</x-button>
        <x-button type="button" wire:click="close" variant="ghost">Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
