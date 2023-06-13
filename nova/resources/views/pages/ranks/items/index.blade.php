@extends($meta->template)

@section('content')
    @livewire('rank-items:list')

    <x-tips section="ranks" />
@endsection
