@use('Nova\Themes\Models\Theme')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', Theme::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.themes.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <x-form :action="route('admin.themes.store')">
            <x-fieldset
                x-data="{ name: '{{ old('name') }}', location: '{{ old('location') }}', suggestLocation: true }"
                x-init="$watch('name', value => {
                    if (suggestLocation) {
                        location = value.replace(/[^\w ]+/g,'').replace(/ +/g,'');
                    }
                })"
            >
                <x-fieldset.group constrained>
                    <x-input label="Name" name="name" x-model="name" />

                    <x-field>
                        <x-label>Location</x-label>

                        <x-input.group>
                            <x-input.group.prefix>themes/</x-input.group.prefix>
                            <x-input name="location" x-model="location" x-on:change="suggestLocation = false" />
                        </x-input.group>
                    </x-field>

                    <x-input label="Version" name="version" :value="old('version', '1.0')" />

                    <x-input label="Preview image filename" name="preview" />

                    <x-textarea
                        label="Credits"
                        description="We strongly encourage providing detailed credits for your theme. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                        name="credits"
                    >
                        {{ old('credits') }}
                    </x-textarea>

                    <x-switch label="Active" name="status" :checked="old('status')" align="left" />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Typography" heading="Fonts">
                    <x-description>Customize your theme by changing the fonts used.</x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-field>
                        <x-label>Headers font</x-label>
                        <div>
                            <livewire:settings-font-selector
                                section="public"
                                type="header"
                                provider="local"
                                provider-input-name="settings[fonts][headerProvider]"
                                family="Geist"
                                family-input-name="settings[fonts][headerFamily]"
                            />
                        </div>
                    </x-field>

                    <x-field>
                        <x-label>Body font</x-label>
                        <div>
                            <livewire:settings-font-selector
                                section="public"
                                type="body"
                                provider="local"
                                provider-input-name="settings[fonts][bodyProvider]"
                                family="Inter"
                                family-input-name="settings[fonts][bodyFamily]"
                            />
                        </div>
                    </x-field>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.themes.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
