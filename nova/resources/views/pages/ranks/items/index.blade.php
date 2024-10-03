@use('Nova\Ranks\Models\RankItem')

<x-admin-layout>
    <x-page-header>
        @can('create', RankItem::class)
            <x-slot name="actions">
                <x-button :href="route('admin.ranks.items.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:rank-items-list />

    <x-tips section="ranks" />
</x-admin-layout>
