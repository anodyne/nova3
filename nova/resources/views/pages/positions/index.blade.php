@use('Nova\Departments\Models\Position')

<x-admin-layout>
    <x-page-heading>
        @can('create', Position::class)
            <x-slot name="actions">
                <x-button :href="route('admin.positions.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:positions-list />

    <x-tips section="positions" />
</x-admin-layout>
