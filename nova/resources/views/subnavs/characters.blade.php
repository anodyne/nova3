<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item :href="route('characters.index')" :active="request()->routeIs('characters.*')">
            @can('viewAny', Nova\Characters\Models\Character::class)
                All characters
            @else
                My characters
            @endcan
        </x-sidebar.subnav.item>

        @can('viewAny', Nova\Departments\Models\Department::class)
            <x-sidebar.subnav.item :href="route('departments.index')" :active="request()->routeIs('departments.*')">
                Departments
            </x-sidebar.subnav.item>
            <x-sidebar.subnav.item :href="route('positions.index')" :active="request()->routeIs('positions.*')">
                Positions
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Ranks\Models\RankGroup::class)
            <x-sidebar.subnav.item :href="route('ranks.groups.index')" :active="request()->routeIs('ranks.groups.*')">
                Rank groups
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Ranks\Models\RankName::class)
            <x-sidebar.subnav.item :href="route('ranks.names.index')" :active="request()->routeIs('ranks.names.*')">
                Rank names
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Ranks\Models\RankItem::class)
            <x-sidebar.subnav.item :href="route('ranks.items.index')" :active="request()->routeIs('ranks.items.*')">
                Rank items
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
