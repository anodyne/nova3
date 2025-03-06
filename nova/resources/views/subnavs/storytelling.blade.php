@use('Nova\Stories\Models\Post')
@use('Nova\Stories\Models\PostType')
@use('Nova\Stories\Models\Story')

<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        @can('viewAny', Story::class)
            <x-sidebar.subnav.item :href="route('admin.stories.index')" :active="request()->is('admin/stories*')">
                Stories
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', PostType::class)
            <x-sidebar.subnav.item
                :href="route('admin.post-types.index')"
                :active="request()->routeIs('admin.post-types.*')"
            >
                Post types
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Post::class)
            <x-sidebar.subnav.item
                :href="route('admin.posts.index')"
                :active="request()->routeIs('admin.posts.index')"
            >
                Posts
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
