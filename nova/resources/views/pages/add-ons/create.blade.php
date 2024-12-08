@use('Nova\Addons\Enums\AddonType')
@use('Nova\Addons\Models\Addon')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Addon::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.addons.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.addons.store')">
            <x-fieldset
                x-data="{ name: '{{ old('name') }}', location: '{{ old('location') }}', suggestLocation: true }"
                x-init="$watch('name', value => {
                    if (suggestLocation) {
                        location = value.replace(/[^\w ]+/g,'').replace(/ +/g,'');
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
                            Add-ons are stored in the
                            <code>addons/</code>
                            directory at the root level of Nova’s file tree.
                        </x-slot>

                        <x-input.text x-model="location" x-on:change="suggestLocation = false" leading="themes/" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Version" id="version" name="version" :error="$errors->first('version')">
                        <x-input.text :value="old('version', '1.0')" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Preview image filename"
                        id="preview"
                        name="preview"
                        :error="$errors->first('preview')"
                    >
                        <x-input.text />
                    </x-fieldset.field>

                    <x-fieldset.field label="Type" id="type" name="type" :error="$errors->first('type')">
                        <x-select class="w-full md:w-2/3">
                            <option value="">Choose a type</option>
                            @foreach (AddonType::toOptions() as $value => $text)
                                <option value="{{ $value }}">{{ $text }}</option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Credits"
                        description="We strongly encourage providing detailed credits for your add-on. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
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

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.addons.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
