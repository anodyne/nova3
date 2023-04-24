@extends($meta->template)

@section('content')
    @livewire('stories:timeline')

    <x-tips section="stories" />
@endsection
