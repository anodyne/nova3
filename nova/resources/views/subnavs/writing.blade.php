<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item
            :href="route('admin.writing-overview')"
            :active="request()->routeIs('admin.writing-overview')"
        >
            Overview
        </x-sidebar.subnav.item>

        @can('create', Nova\Stories\Models\Post::class)
            <x-sidebar.subnav.item
                :href="route('admin.posts.create')"
                :active="request()->routeIs(['admin.posts.create', 'admin.posts.edit'])"
            >
                Write a story post
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Stories\Models\Story::class)
            <x-sidebar.subnav.item :href="route('admin.stories.index')" :active="request()->is('admin/stories*')">
                Stories
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Stories\Models\PostType::class)
            <x-sidebar.subnav.item
                :href="route('admin.post-types.index')"
                :active="request()->routeIs('admin.post-types.*')"
            >
                Post types
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Nova\Stories\Models\Post::class)
            <x-sidebar.subnav.item
                :href="route('admin.posts.index')"
                :active="request()->routeIs('admin.posts.index')"
            >
                Posts
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
