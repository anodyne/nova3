@use('Nova\Addons\Enums\AddonType')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', $addon::class)
                    <x-button :href="route('admin.addons.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan

                @can('updateSettings', $addon)
                    <livewire:addon-settings :addon="$addon" :iconTrigger="false" />
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.addons.update', $addon)" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name', $addon->name)" />
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

                        <x-input.text :value="old('location', $addon->location)" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Version"
                        description="Be careful when updating the version number for existing add-ons as this could cause issues with any version checking."
                        id="version"
                        name="version"
                        :error="$errors->first('version')"
                    >
                        <x-input.text :value="old('version', $addon->version)"></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Preview image filename"
                        id="preview"
                        name="preview"
                        :error="$errors->first('preview')"
                    >
                        <x-input.text :value="old('preview', $addon->preview)" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Type" id="type" name="type" :error="$errors->first('type')">
                        <x-select class="w-full md:w-2/3">
                            <option value="">Choose a type</option>
                            @foreach (AddonType::cases() as $addonType)
                                <option
                                    value="{{ $addonType->value }}"
                                    @selected($addon->type->value === $addonType->value)
                                >
                                    {{ $addonType->getLabel() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Credits"
                        description="We strongly encourage providing detailed credits for your add-on. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                        id="credits"
                        name="credits"
                    >
                        <x-input.textarea>{{ old('credits', $addon->credits) }}</x-input.textarea>
                    </x-fieldset.field>

                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="status"
                            :value="old('status', $addon->status)"
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
                <x-button :href="route('admin.addons.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
