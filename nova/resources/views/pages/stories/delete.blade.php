@extends($meta->template)

@section('content')
    <livewire:stories-delete :stories="$storiesToDelete" />
@endsection
