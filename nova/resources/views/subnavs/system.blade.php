@use('Nova\Addons\Models\Addon')
@use('Nova\Menus\Models\MenuItem')
@use('Nova\Themes\Models\Theme')
@use('Spatie\Activitylog\Models\Activity')

<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        @permission('system.overview')
            <x-sidebar.subnav.item
                href="{{ route('admin.system-overview') }}"
                :current="request()->routeIs('admin.system-overview')"
            >
                Overview
            </x-sidebar.subnav.item>
        @endpermission

        @can('viewAny', Addon::class)
            <x-sidebar.subnav.item
                :href="route('admin.addons.index')"
                :current="request()->routeIs('admin.addons.*')"
            >
                Add-ons
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', MenuItem::class)
            <x-sidebar.subnav.item
                :href="route('admin.menu-items.index')"
                :current="request()->routeIs('admin.menu-items.*')"
            >
                Menu items
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Theme::class)
            <x-sidebar.subnav.item
                :href="route('admin.themes.index')"
                :current="request()->routeIs('admin.themes.*')"
            >
                Themes
            </x-sidebar.subnav.item>
        @endcan

        @permission('system.error-logs')
            <x-sidebar.subnav.item
                :href="route('admin.error-logs.index')"
                :current="request()->routeIs('admin.error-logs.*')"
            >
                Error logs
            </x-sidebar.subnav.item>
        @endpermission
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
