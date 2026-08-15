@use('Nova\Foundation\Enums\BasicStatus')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                @can('viewAny', $theme::class)
                    <x-button :href="route('admin.themes.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('update', $theme)
                    <x-button
                        x-on:click="Livewire.dispatch('modal-open', {modal: 'theme-settings', props: {'theme': '{{ $theme->location }}'}})"
                    >
                        Theme settings
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <x-form :action="route('admin.themes.update', $theme)" method="PUT">
            @if (settings('appearance.theme') === $theme->location)
                <x-callout.primary heading="Current theme" :icon="Tabler::Star">
                    {{ $theme->name }} is currently set as the theme for your public-facing site. Be careful when
                    making any updates to this theme as it could impact your public-facing site.
                </x-callout.primary>
            @endif

            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Name" name="name" :value="old('name', $theme->name)" />

                    <x-field>
                        <x-label>Location</x-label>

                        <x-input.group>
                            <x-input.group.prefix>themes/</x-input.group.prefix>
                            <x-input name="location" :value="old('location', $theme->location)" />
                        </x-input.group>
                    </x-field>

                    <x-input
                        label="Version"
                        description="Be careful when updating the version number for existing themes as this could cause issues with any version checking"
                        name="version"
                        :value="old('version', $theme->version)"
                    />

                    <x-input label="Preview image filename" name="preview" :value="old('preview', $theme->preview)" />

                    <x-textarea
                        label="Credits"
                        description="We strongly encourage providing detailed credits for your theme. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                        name="credits"
                    >
                        {{ old('credits', $theme->credits) }}
                    </x-textarea>

                    <x-switch
                        label="Active"
                        name="status"
                        :checked="old('status', $theme->status === BasicStatus::Active)"
                        align="left"
                    />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.themes.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
