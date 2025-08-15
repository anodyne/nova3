@use('Nova\Addons\Enums\AddonType')
@use('Nova\Foundation\Enums\BasicStatus')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', $addon::class)
                    <x-button :href="route('admin.addons.index')" variant="ghost" inset="right">&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.addons.update', $addon)" method="PUT">
            <x-fieldset>
                <x-fieldset.fields constrained>
                    <x-input label="Name" name="name" :value="old('name', $addon->name)" />

                    <x-input.field>
                        <x-input.label>Location</x-input.label>

                        <x-input.group>
                            <x-input.group.prefix>addons/</x-input.group.prefix>
                            <x-input name="location" :value="old('location', $addon->location)"></x-input>
                        </x-input.group>
                    </x-input.field>

                    <x-input
                        label="Version"
                        description="Be careful when updating the version number for existing add-ons as this could cause issues with any version checking"
                        name="version"
                        :value="old('version', $addon->version)"
                    />

                    <x-input label="Preview image filename" name="preview" :value="old('preview', $addon->preview)" />

                    <x-radio.group label="Type" name="type" variant="segmented">
                        @foreach (AddonType::cases() as $addonType)
                            <x-radio
                                :value="$addonType->value"
                                :label="$addonType->getLabel()"
                                :checked="$addon->type->value === $addonType->value"
                            />
                        @endforeach
                    </x-radio.group>

                    <x-textarea
                        label="Credits"
                        description="We strongly encourage providing detailed credits for your add-on. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                        name="credits"
                    >
                        {{ old('credits', $addon->credits) }}
                    </x-textarea>

                    <x-switch
                        label="Active"
                        name="status"
                        :checked="old('status', $addon->status === BasicStatus::Active)"
                        align="left"
                    ></x-switch>
                </x-fieldset.fields>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.addons.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
