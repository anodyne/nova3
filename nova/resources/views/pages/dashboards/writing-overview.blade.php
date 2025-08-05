@use('Nova\Stories\Models\Post')

<x-admin-layout>
    <x-spacing constrained-lg>
        <x-page-header>
            @can('create', Post::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.posts.create')" color="primary">
                        <x-icon :name="Icon::Write" size="sm"></x-icon>
                        Start writing
                    </x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <livewire:posts-draft-posts-list />
    </x-spacing>
</x-admin-layout>
