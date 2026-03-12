@use('Nova\Stories\Models\Post')

<x-admin-layout>
    <x-page-heading>
        <x-slot name="actions">
            <x-button :href="route('admin.stories.posts-timeline')">
                <x-icon :name="Tabler::TimelineEvent" size="sm" />
                Posts timeline
            </x-button>

            @can('create', Post::class)
                <x-button :href="route('admin.posts.create')" variant="primary">
                    <x-icon :name="Tabler::Edit" size="sm" />
                    Start writing
                </x-button>
            @endcan
        </x-slot>
    </x-page-heading>

    <livewire:posts-list />

    <x-tips section="posts"></x-tips>
</x-admin-layout>
