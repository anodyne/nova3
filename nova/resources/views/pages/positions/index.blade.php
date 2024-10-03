@use('Nova\Departments\Models\Position')

<x-admin-layout>
    <x-page-header>
        @can('create', Position::class)
            <x-slot name="actions">
                <x-button :href="route('admin.positions.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:positions-list />

    <x-tips section="positions" />
</x-admin-layout>
