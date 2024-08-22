<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item
            :href="route('admin.characters.index')"
            :active="request()->routeIs('admin.characters.*')"
        >
            @can('viewAny', Nova\Characters\Models\Character::class)
                All characters
            @else
                My characters
            @endcan
        </x-sidebar.subnav.item>

        @can('viewAny', Nova\Departments\Models\Department::class)
            <x-sidebar.subnav.item
                :href="route('admin.departments.index')"
                :active="request()->routeIs('admin.departments.*')"
            >
                Departments
            </x-sidebar.subnav.item>
            <x-sidebar.subnav.item
                :href="route('admin.positions.index')"
                :active="request()->routeIs('admin.positions.*')"
            >
                Positions
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Ranks\Models\RankGroup::class)
            <x-sidebar.subnav.item
                :href="route('admin.ranks.groups.index')"
                :active="request()->routeIs('admin.ranks.groups.*')"
            >
                Rank groups
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Ranks\Models\RankName::class)
            <x-sidebar.subnav.item
                :href="route('admin.ranks.names.index')"
                :active="request()->routeIs('admin.ranks.names.*')"
            >
                Rank names
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Ranks\Models\RankItem::class)
            <x-sidebar.subnav.item
                :href="route('admin.ranks.items.index')"
                :active="request()->routeIs('admin.ranks.items.*')"
            >
                Rank items
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
