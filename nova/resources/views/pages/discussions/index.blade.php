@extends($meta->template)

@section('content')
    <livewire:discussions-messages-list :selected="$discussion?->id" />
@endsection
