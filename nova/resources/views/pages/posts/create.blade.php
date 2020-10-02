@extends($__novaTemplate)

@section('content')
    @livewire('posts:compose', [
        'allPostTypes' => $postTypes,
        'allStories' => $stories,
        'direction' => request('direction', 'after'),
        'neighbor' => request('neighbor'),
    ])
@endsection

@push('scripts')
    @once
        <script src="https://unpkg.com/trix@1.2.3/dist/trix.js"></script>
    @endonce
@endpush

@push('styles')
    @once
        <link rel="stylesheet" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
    @endonce
@endpush
