@use('Nova\Menus\Models\MenuItem')

<x-admin-layout>
    <x-page-heading>
        @can('create', MenuItem::class)
            <x-slot name="actions">
                <x-button :href="route('admin.menu-items.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:menu-items-list />

    <x-tips section="menus"></x-tips>
</x-admin-layout>
