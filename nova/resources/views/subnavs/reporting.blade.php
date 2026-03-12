<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.game-overview')"
            :current="request()->routeIs('admin.reporting.game-overview')"
        >
            Overview
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.player-activity')"
            :current="request()->routeIs('admin.reporting.player-activity')"
        >
            Player activity
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.player-participation')"
            :current="request()->routeIs('admin.reporting.player-participation')"
        >
            Player participation
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.game-stats')"
            :current="request()->routeIs('admin.reporting.game-stats')"
        >
            Game stats
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.post-types')"
            :current="request()->routeIs('admin.reporting.post-types')"
        >
            Post types report
        </x-sidebar.subnav.item>
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
