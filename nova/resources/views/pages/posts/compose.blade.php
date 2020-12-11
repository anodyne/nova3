@extends($__novaTemplate)

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

@push('scripts')
    @once
        <script src="{{ asset('dist/js/editor-tiptap.js') }}"></script>
    @endonce
@endpush

@push('styles')
    @once
        <link rel="stylesheet" href="{{ asset('dist/css/tiptap.css') }}">
    @endonce
@endpush
