@use('Nova\Ranks\Models\RankGroup')

<x-admin-layout>
    <x-page-header>
        @can('create', RankGroup::class)
            <x-slot name="actions">
                <x-button :href="route('admin.ranks.groups.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:rank-groups-list />

    <x-tips section="ranks" />
</x-admin-layout>
