@use('Nova\Stories\Models\Post')
@use('Nova\Stories\Models\PostType')
@use('Nova\Stories\Models\Story')

<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item
            :href="route('admin.writing-overview')"
            :current="request()->routeIs('admin.writing-overview')"
        >
            Overview
        </x-sidebar.subnav.item>

        @can('create', Post::class)
            <x-sidebar.subnav.item
                :href="route('admin.posts.create')"
                :current="request()->routeIs(['admin.posts.create', 'admin.posts.edit'])"
            >
                Write a story post
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Story::class)
            <x-sidebar.subnav.item :href="route('admin.stories.index')" :current="request()->is('admin/stories*')">
                Stories
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', PostType::class)
            <x-sidebar.subnav.item
                :href="route('admin.post-types.index')"
                :current="request()->routeIs('admin.post-types.*')"
            >
                Post types
            </x-sidebar.subnav.item>
        @endcan

        @can('viewAny', Post::class)
            <x-sidebar.subnav.item
                :href="route('admin.posts.index')"
                :current="request()->routeIs('admin.posts.index')"
            >
                Posts
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
