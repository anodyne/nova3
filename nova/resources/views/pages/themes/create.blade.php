@use('Nova\Themes\Models\Theme')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Theme::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.themes.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.themes.store')">
            <x-fieldset
                x-data="{ name: '{{ old('name') }}', location: '{{ old('location') }}', suggestLocation: true }"
                x-init="$watch('name', value => {
                    if (suggestLocation) {
                        location = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
                    }
                })"
            >
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text x-model="name" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Location"
                        id="location"
                        name="location"
                        :error="$errors->first('location')"
                    >
                        <x-slot name="description">
                            Themes are stored in the
                            <code>themes/</code>
                            directory at the root level of Nova’s file tree.
                        </x-slot>

                        <x-input.text x-model="location" x-on:change="suggestLocation = false" leading="themes/" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Preview image filename"
                        id="preview"
                        name="preview"
                        :error="$errors->first('preview')"
                    >
                        <x-input.text />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Credits"
                        description="We strongly encourage providing detailed credits for your theme. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                        id="credits"
                        name="credits"
                    >
                        <x-input.textarea>{{ old('credits') }}</x-input.textarea>
                    </x-fieldset.field>

                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="status"
                            :value="old('status', 'active')"
                            on-value="active"
                            off-value="inactive"
                            id="status"
                        ></x-switch>
                        <x-fieldset.label for="status">Active</x-fieldset.label>
                    </div>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="typography"></x-icon>
                    <x-fieldset.legend>Fonts</x-fieldset.legend>
                    <x-fieldset.description>Customize your theme by changing the fonts used.</x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Headers font" id="public_font_header" name="public_font_header">
                        <livewire:settings-font-selector
                            section="public"
                            type="header"
                            provider="local"
                            provider-input-name="settings[fonts][headerProvider]"
                            family="Geist"
                            family-input-name="settings[fonts][headerFamily]"
                        />
                    </x-fieldset.field>

                    <x-fieldset.field label="Body font" id="public_font_body" name="public_font_body">
                        <livewire:settings-font-selector
                            section="public"
                            type="body"
                            provider="local"
                            provider-input-name="settings[fonts][bodyProvider]"
                            family="Inter"
                            family-input-name="settings[fonts][bodyFamily]"
                        />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.themes.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
