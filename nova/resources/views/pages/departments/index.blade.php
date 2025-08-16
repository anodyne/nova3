@use('Nova\Departments\Models\Department')

<x-admin-layout>
    <x-page-header>
        @can('create', Department::class)
            <x-slot name="actions">
                <x-button :href="route('admin.departments.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:departments-list />

    <x-tips section="departments" />
</x-admin-layout>
