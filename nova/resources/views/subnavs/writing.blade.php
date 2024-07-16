<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item :href="route('writing-overview')" :active="request()->routeIs('writing-overview')">
            Overview
        </x-sidebar.subnav.item>

        @can('create', Nova\Stories\Models\Post::class)
            <x-sidebar.subnav.item
                :href="route('posts.create')"
                :active="request()->routeIs(['posts.create', 'posts.edit'])"
            >
                Write a story post
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Stories\Models\Story::class)
            <x-sidebar.subnav.item :href="route('stories.index')" :active="request()->is('stories*')">
                Stories
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Stories\Models\PostType::class)
            <x-sidebar.subnav.item :href="route('post-types.index')" :active="request()->routeIs('post-types.*')">
                Post types
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Stories\Models\Post::class)
            <x-sidebar.subnav.item :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                Posts
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
