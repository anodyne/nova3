@use('Nova\Stories\Models\Post')

<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item
            :href="route('admin.writing-overview')"
            :active="request()->routeIs('admin.writing-overview')"
        >
            Overview
        </x-sidebar.subnav.item>

        @can('create', Post::class)
            <x-sidebar.subnav.item
                :href="route('admin.posts.create')"
                :active="request()->routeIs(['admin.posts.create', 'admin.posts.edit'])"
            >
                Write a story post
            </x-sidebar.subnav.item>
        @endcan
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
