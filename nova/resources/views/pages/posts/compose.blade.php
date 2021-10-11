@extends($meta->template)

@section('content')
    <x-page-header title="Compose Story Post">
        <x-slot name="pretitle">
            <a href="{{ route('posts.create') }}">Change Post Type</a>
        </x-slot>
    </x-page-header>

    @livewire('posts:compose', [
        'postType' => $postType,
        'allStories' => $stories,
        'direction' => request('direction', 'after'),
        'neighbor' => request('neighbor'),
    ])
@endsection
