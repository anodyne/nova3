@use('Nova\Roles\Models\Role')

<x-admin-layout>
    <x-page-heading>
        <x-slot name="actions">
            @can('viewAny', Role::class)
                <x-button :href="route('admin.permissions.index')" variant="ghost">
                    <x-icon :name="Tabler::Key" size="sm" />
                    View permissions
                </x-button>
            @endcan

            @can('create', Role::class)
                <x-button :href="route('admin.roles.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-heading>

    <livewire:roles-list />

    <x-tips section="roles" />
</x-admin-layout>
