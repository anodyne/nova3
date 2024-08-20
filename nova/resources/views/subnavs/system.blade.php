@use('Nova\Menus\Models\MenuItem')

<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item href="{{ route('system-overview') }}" :active="request()->routeIs('system-overview')">
            Overview
        </x-sidebar.subnav.item>

        @can('viewAny', MenuItem::class)
            <x-sidebar.subnav.item :href="route('menu-items.index')" :active="request()->routeIs('menu-items.*')">
                Menu items
            </x-sidebar.subnav.item>
        @endcan

        {{-- <x-sidebar.subnav.item href="#">Add-ons</x-sidebar.subnav.item> --}}
        {{--
            <x-sidebar.subnav.item href="{{ route('themes.index') }}" :active="request()->routeIs('themes.*')">
            Themes
            </x-sidebar.subnav.item>
        --}}
        @can('viewAny', Spatie\Activitylog\Models\Activity::class)
            <x-sidebar.subnav.item
                href="{{ route('activity-log.index') }}"
                :active="request()->routeIs('activity-log.*')"
            >
                Activity log
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
