@use('Nova\Ranks\Models\RankItem')

<x-admin-layout>
    <x-page-heading>
        @can('create', RankItem::class)
            <x-slot name="actions">
                <x-button :href="route('admin.ranks.items.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:rank-items-list />

    <x-tips section="ranks" />
</x-admin-layout>
