<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.game-overview')"
            :active="request()->routeIs('admin.reporting.game-overview')"
        >
            Overview
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.player-activity')"
            :active="request()->routeIs('admin.reporting.player-activity')"
        >
            Player activity
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.player-participation')"
            :active="request()->routeIs('admin.reporting.player-participation')"
        >
            Player participation
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.game-stats')"
            :active="request()->routeIs('admin.reporting.game-stats')"
        >
            Game stats
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.reporting.post-types')"
            :active="request()->routeIs('admin.reporting.post-types')"
        >
            Post types report
        </x-sidebar.subnav.item>
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
