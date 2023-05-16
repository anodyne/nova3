@extends($meta->template)

@section('content')
    @livewire('notes:list')

    <x-tips section="notes" />
@endsection
