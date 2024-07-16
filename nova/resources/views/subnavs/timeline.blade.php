<x-sidebar.subnav>
    <x-sidebar.subnav.group>
        <x-sidebar.subnav.item
            href="{{ route('stories.timeline', 'posts') }}"
            :active="request()->is('timeline/posts')"
        >
            By posts
        </x-sidebar.subnav.item>
        <x-sidebar.subnav.item
            href="{{ route('stories.timeline', 'stories') }}"
            :active="request()->is('timeline/stories')"
        >
            By stories
        </x-sidebar.subnav.item>
    </x-sidebar.subnav.group>
</x-sidebar.subnav>
