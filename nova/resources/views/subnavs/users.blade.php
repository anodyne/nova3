<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        @can('viewAny', Nova\Users\Models\User::class)
            <x-sidebar.subnav.item :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                All users
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Roles\Models\Role::class)
            <x-sidebar.subnav.item :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                Roles
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Roles\Models\Permission::class)
            <x-sidebar.subnav.item
                :href="route('admin.permissions.index')"
                :active="request()->routeIs('admin.permissions.*')"
            >
                Permissions
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
