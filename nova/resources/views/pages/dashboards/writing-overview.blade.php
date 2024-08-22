@extends($meta->template)

@use('Nova\Stories\Models\Post')

@section('content')
    <x-page-header>
        <x-slot name="heading">My draft posts</x-slot>
        <x-slot name="description">Drafts are posts in progress that have not been published</x-slot>

        <x-slot name="actions">
            @can('create', Post::class)
                <x-button :href="route('admin.posts.create')" color="primary">
                    <x-icon name="write" size="sm"></x-icon>
                    Start writing
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:posts-my-drafts-list />
@endsection
