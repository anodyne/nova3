@use('Nova\Stories\Models\Post')

<x-admin-layout>
    <x-spacing constrained-lg>
        <x-page-heading>
            @can('create', Post::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.posts.create')" variant="primary">
                        <x-icon :name="Tabler::Edit" size="sm" />
                        Start writing
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <livewire:posts-draft-posts-list />
    </x-spacing>
</x-admin-layout>
