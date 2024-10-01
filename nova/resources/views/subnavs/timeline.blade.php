<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item
            :href="route('admin.stories.posts-timeline')"
            :active="request()->routeIs('admin.stories.posts-timeline')"
        >
            By posts
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            :href="route('admin.stories.stories-timeline')"
            :active="request()->routeIs('admin.stories.stories-timeline')"
        >
            By stories
        </x-sidebar.subnav.item>
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
