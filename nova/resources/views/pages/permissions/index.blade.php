@use('Nova\Roles\Models\Role')

<x-admin-layout>
    <x-page-heading>
        @can('viewAny', Role::class)
            <x-slot name="actions">
                <x-button :href="route('admin.roles.index')">
                    <x-icon :name="Tabler::ShieldLock" size="sm" />
                    View roles
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:permissions-list />

    <x-tips section="roles" />
</x-admin-layout>
