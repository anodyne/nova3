@use('Nova\Stories\Models\Post')

<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            <x-button :href="route('admin.stories.posts-timeline')" outline>
                <x-icon name="timeline" size="sm"></x-icon>
                Posts timeline
            </x-button>

            @can('create', Post::class)
                <x-button :href="route('admin.posts.create')" color="primary">
                    <x-icon name="write" size="sm"></x-icon>
                    Start writing
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:posts-list />

    <x-tips section="posts"></x-tips>
</x-admin-layout>
