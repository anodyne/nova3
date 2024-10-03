@use('Nova\Stories\Models\Post')

<x-admin-layout>
    <x-page-header>
        @can('create', Post::class)
            <x-slot name="headerActions">
                <x-button :href="route('admin.posts.create')" color="primary">
                    <x-icon name="write" size="sm"></x-icon>
                    Start writing
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:posts-my-drafts-list />
</x-admin-layout>
