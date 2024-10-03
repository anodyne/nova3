@use('Nova\Departments\Models\Department')

<x-admin-layout>
    <x-page-header>
        @can('create', Department::class)
            <x-slot name="actions">
                <x-button :href="route('admin.departments.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:departments-list />

    <x-tips section="departments"></x-tips>
</x-admin-layout>
