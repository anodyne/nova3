@extends($__novaTemplate)

@section('content')
    @livewire('posts:compose', [
        'allPostTypes' => $postTypes,
        'allStories' => $stories,
        'direction' => request('direction', 'after'),
        'neighbor' => request('neighbor'),
    ])
@endsection
