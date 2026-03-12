@use('Nova\Ranks\Models\RankGroup')

<x-admin-layout>
    <x-page-heading>
        @can('create', RankGroup::class)
            <x-slot name="actions">
                <x-button :href="route('admin.ranks.groups.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:rank-groups-list />

    <x-tips section="ranks" />
</x-admin-layout>
