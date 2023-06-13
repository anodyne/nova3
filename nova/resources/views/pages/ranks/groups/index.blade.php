@extends($meta->template)

@section('content')
    @livewire('rank-groups:list')

    <x-tips section="ranks" />
@endsection
