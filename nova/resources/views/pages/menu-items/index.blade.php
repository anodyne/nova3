@use('Nova\Menus\Models\MenuItem')

<x-admin-layout>
    <x-page-header>
        @can('create', MenuItem::class)
            <x-slot name="actions">
                <x-button :href="route('admin.menu-items.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:menu-items-list />

    <x-tips section="menus"></x-tips>
</x-admin-layout>
