@use('Nova\Users\Models\Ban')

<x-admin-layout>
    <x-page-heading>
        @can('create', Ban::class)
            <x-slot name="actions">
                <x-button :href="route('admin.bans.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:bans-list />

    <x-tips section="bans" />
</x-admin-layout>
