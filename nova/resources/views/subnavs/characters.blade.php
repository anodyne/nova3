<x-nav.sub>
    <x-nav.sub-header>Characters</x-nav.sub-header>

    <x-nav.sub-group>
        <x-nav.sub-item :href="route('characters.index')" :active="request()->routeIs('characters.*')">
            @can('viewAny', Nova\Characters\Models\Character::class)
                All Characters
            @else
                My Characters
            @endcan
        </x-nav.sub-item>
    </x-nav.sub-group>

    @can('viewAny', Nova\Departments\Models\Department::class)
        <x-nav.sub-group>
            <x-nav.sub-item :href="route('departments.index')" :active="request()->routeIs('departments.*')">Departments</x-nav.sub-item>
            <x-nav.sub-item :href="route('positions.index')" :active="request()->routeIs('positions.*')">Positions</x-nav.sub-item>
        </x-nav.sub-group>
    @endcan

    <x-nav.sub-group>
        @can('viewAny', Nova\Ranks\Models\RankGroup::class)
            <x-nav.sub-item :href="route('ranks.groups.index')" :active="request()->routeIs('ranks.groups.*')">Rank Groups</x-nav.sub-item>
        @endcan

        @can('viewAny', Nova\Ranks\Models\RankName::class)
            <x-nav.sub-item :href="route('ranks.names.index')" :active="request()->routeIs('ranks.names.*')">Rank Names</x-nav.sub-item>
        @endcan

        @can('viewAny', Nova\Ranks\Models\RankItem::class)
            <x-nav.sub-item :href="route('ranks.items.index')" :active="request()->routeIs('ranks.items.*')">Rank Items</x-nav.sub-item>
        @endcan
    </x-nav.sub-group>
</x-nav.sub>