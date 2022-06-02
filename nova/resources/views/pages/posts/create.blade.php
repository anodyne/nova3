@extends($meta->template)

@section('content')
    <livewire:posts:write :show-step="$post->exists ? 'posts:step:write-post': null" />
@endsection
