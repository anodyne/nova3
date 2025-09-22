@use('Nova\Ranks\Models\RankGroup')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', RankGroup::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.ranks.groups.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.ranks.groups.store')">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Name" name="name" :value="old('name')" />

                    <x-switch label="Active" name="status" :checked="old('status')" align="left" />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.ranks.groups.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
