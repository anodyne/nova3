<x-nav.sub>
    <x-nav.sub-group>
        <x-nav.sub-item :href="route('writing-overview')" :active="request()->routeIs('writing-overview')">
            Overview
        </x-nav.sub-item>
    </x-nav.sub-group>

    @can('create', Nova\Posts\Models\Post::class)
        <x-nav.sub-group>
            <x-nav.sub-item
                :href="route('posts.create')"
                :active="request()->routeIs(['posts.create', 'posts.edit'])"
            >
                Write a story post
            </x-nav.sub-item>
        </x-nav.sub-group>
    @endcan

    <x-nav.sub-group>
        @can('viewAny', Nova\Stories\Models\Story::class)
            <x-nav.sub-item :href="route('stories.index')" :active="request()->is('stories*')">
                Stories
            </x-nav.sub-item>
        @endcan

        @can('viewAny', Nova\PostTypes\Models\PostType::class)
            <x-nav.sub-item :href="route('post-types.index')" :active="request()->routeIs('post-types.*')">
                Post types
            </x-nav.sub-item>
        @endcan

        @can('viewAny', Nova\Posts\Models\Post::class)
            <x-nav.sub-item :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                Posts
            </x-nav.sub-item>
        @endcan
    </x-nav.sub-group>
</x-nav.sub>
