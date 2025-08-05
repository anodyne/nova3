@use('Nova\Users\Models\Ban')

<x-admin-layout>
    <x-page-header>
        @can('create', Ban::class)
            <x-slot name="actions">
                <x-button :href="route('admin.bans.create')" color="primary">
                    <x-icon :name="Icon::Plus" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:bans-list />
</x-admin-layout>
