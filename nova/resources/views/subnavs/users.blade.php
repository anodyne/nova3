@use('Nova\Roles\Models\Permission')
@use('Nova\Roles\Models\Role')
@use('Nova\Users\Models\Ban')
@use('Nova\Users\Models\User')

<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        @can('viewAny', User::class)
            <x-sidebar.subnav.item :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')">
                All users
            </x-sidebar.subnav.item>
        @endcan

        @can('updateAny', User::class)
            <x-sidebar.subnav.item
                :href="route('admin.user-moderation')"
                :current="request()->routeIs('admin.user-moderation')"
            >
                Moderation
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Role::class)
            <x-sidebar.subnav.item :href="route('admin.roles.index')" :current="request()->routeIs('admin.roles.*')">
                Roles
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Permission::class)
            <x-sidebar.subnav.item
                :href="route('admin.permissions.index')"
                :current="request()->routeIs('admin.permissions.*')"
            >
                Permissions
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Ban::class)
            <x-sidebar.subnav.item :href="route('admin.bans.index')" :current="request()->routeIs('admin.bans.*')">
                Bans
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
