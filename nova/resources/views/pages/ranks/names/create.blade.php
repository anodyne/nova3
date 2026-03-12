@use('Nova\Ranks\Models\RankName')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', RankName::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.ranks.names.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <x-form :action="route('admin.ranks.names.store')">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Name" name="name" :value="old('name')" />

                    <x-switch label="Active" name="status" :checked="old('status')" align="left" />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.ranks.names.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
