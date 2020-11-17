@extends($__novaTemplate)

@section('content')
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
