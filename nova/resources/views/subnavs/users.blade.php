<x-nav.sub>
    <x-nav.sub-group>
        @can('viewAny', Nova\Users\Models\User::class)
            <x-nav.sub-item :href="route('users.index')" :active="request()->routeIs('users.*')">
                All users
            </x-nav.sub-item>
        @endcan
    </x-nav.sub-group>

    @can('viewAny', Nova\Roles\Models\Role::class)
        <x-nav.sub-group>
            <x-nav.sub-item :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                Roles
            </x-nav.sub-item>
        </x-nav.sub-group>
    @endcan

    @can('viewAny', Nova\Roles\Models\Permission::class)
        <x-nav.sub-group>
            <x-nav.sub-item :href="route('permissions.index')" :active="request()->routeIs('permissions.*')">
                Permissions
            </x-nav.sub-item>
        </x-nav.sub-group>
    @endcan
</x-nav.sub>
