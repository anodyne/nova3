@extends($meta->template)

@section('content')
    <livewire:posts-write :initial-step="$post->exists ? 'posts-wizard-step-compose': null" />
@endsection
