@extends($meta->template)

@section('content')
    @livewire('stories:delete-story', ['stories' => $storiesToDelete])
@endsection
