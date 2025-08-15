@use('Nova\Addons\Enums\AddonType')
@use('Nova\Addons\Models\Addon')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Addon::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.addons.index')" variant="ghost" inset="right">&larr; Back</x-button>
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
                <x-fieldset.fields constrained>
                    <x-input label="Name" name="name" x-model="name" />

                    <x-input.field>
                        <x-input.label>Location</x-input.label>

                        <x-input.group>
                            <x-input.group.prefix>addons/</x-input.group.prefix>
                            <x-input name="location" x-model="location" x-on:change="suggestLocation = false" />
                        </x-input.group>
                    </x-input.field>

                    <x-input label="Version" name="version" :value="old('version', '1.0')" />

                    <x-input label="Preview image filename" name="preview" :value="old('preview')" />

                    <x-radio.group label="Type" name="type" variant="segmented">
                        @foreach (AddonType::cases() as $addonType)
                            <x-radio :value="$addonType->value" :label="$addonType->getLabel()" />
                        @endforeach
                    </x-radio.group>

                    <x-textarea
                        label="Credits"
                        description="We strongly encourage providing detailed credits for your add-on. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                        name="credits"
                    >
                        {{ old('credits') }}
                    </x-textarea>

                    <x-switch label="Active" name="status" :checked="old('status')" align="left"></x-switch>
                </x-fieldset.fields>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.addons.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
