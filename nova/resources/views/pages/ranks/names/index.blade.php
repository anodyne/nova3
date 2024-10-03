@use('Nova\Ranks\Models\RankName')

<x-admin-layout>
    <x-page-header>
        @can('create', RankName::class)
            <x-slot name="actions">
                <x-button :href="route('admin.ranks.names.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:rank-names-list />

    <x-tips section="ranks" />
</x-admin-layout>
