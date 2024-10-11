<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', $theme::class)
                    <x-button :href="route('admin.themes.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan

                @can('update', $theme)
                    <livewire:theme-settings :theme="$theme" :iconTrigger="false" />
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.themes.update', $theme)" method="PUT">
            @if (settings('appearance.theme') === $theme->location)
                <x-panel.primary icon="star" title="Current theme">
                    {{ $theme->name }} is currently set as the theme for your public-facing site. Be careful when
                    making any updates to this theme as it could impact your public-facing site.
                </x-panel.primary>
            @endif

            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name', $theme->name)" />
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

                        <x-input.text :value="old('location', $theme->location)" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Preview image filename"
                        id="preview"
                        name="preview"
                        :error="$errors->first('preview')"
                    >
                        <x-input.text :value="old('preview', $theme->preview)" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Credits"
                        description="We strongly encourage providing detailed credits for your theme. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                        id="credits"
                        name="credits"
                    >
                        <x-input.textarea>{{ old('credits', $theme->credits) }}</x-input.textarea>
                    </x-fieldset.field>

                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="status"
                            :value="old('status', $theme->status)"
                            on-value="active"
                            off-value="inactive"
                            id="status"
                        ></x-switch>
                        <x-fieldset.label for="status">Active</x-fieldset.label>
                    </div>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('admin.themes.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
