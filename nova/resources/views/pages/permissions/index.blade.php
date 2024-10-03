@use('Nova\Roles\Models\Role')

<x-admin-layout>
    <x-page-header>
        @can('viewAny', Role::class)
            <x-slot name="actions">
                <x-button :href="route('admin.roles.index')" color="neutral">
                    <x-icon name="shield" size="sm"></x-icon>
                    View roles
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:permissions-list />

    <x-tips section="roles" />
</x-admin-layout>
