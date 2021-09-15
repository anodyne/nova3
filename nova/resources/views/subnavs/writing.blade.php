<x-nav.sub>
    <x-nav.sub-header>Writing</x-nav.sub-header>

    <x-nav.sub-group>
        <x-nav.sub-item href="#">Overview</x-nav.sub-item>
    </x-nav.sub-group>

    @can('create', Nova\Posts\Models\Post::class)
        <x-nav.sub-group>
            <x-nav.sub-item href="{{ route('posts.create') }}" :active="request()->routeIs('posts.*')">Write New Post</x-nav.sub-item>
        </x-nav.sub-group>
    @endcan

    <x-nav.sub-group>
        @can('viewAny', Nova\Stories\Models\Story::class)
            <x-nav.sub-item href="{{ route('stories.index') }}" :active="request()->routeIs('stories.*')">Stories</x-nav.sub-item>
        @endcan

        @can('viewAny', Nova\PostTypes\Models\PostType::class)
            <x-nav.sub-item href="{{ route('post-types.index') }}" :active="request()->routeIs('post-types.*')">Post Types</x-nav.sub-item>
        @endcan
    </x-nav.sub-group>
</x-nav.sub>