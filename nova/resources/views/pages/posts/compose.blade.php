@extends($meta->template)

@section('content')
    {{-- <x-page-header>
        <x-slot:pretitle>
            <div class="flex items-center space-x-1">
                <x-icon.chevron-left class="h-4 w-4 text-gray-9" />
                <a href="{{ route('posts.create') }}">Change Post Type</a>
            </div>
        </x-slot:pretitle>

        Write a {{ $postType->name }}
    </x-page-header> --}}

    @livewire('posts:compose', [
        'postType' => $postType,
        'allStories' => $stories,
        'direction' => request('direction'),
        'neighbor' => request('neighbor'),
    ])
@endsection
