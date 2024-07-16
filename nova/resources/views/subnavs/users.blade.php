<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        @can('viewAny', Nova\Users\Models\User::class)
            <x-sidebar.subnav.item :href="route('users.index')" :active="request()->routeIs('users.*')">
                All users
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Roles\Models\Role::class)
            <x-sidebar.subnav.item :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                Roles
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Roles\Models\Permission::class)
            <x-sidebar.subnav.item :href="route('permissions.index')" :active="request()->routeIs('permissions.*')">
                Permissions
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
