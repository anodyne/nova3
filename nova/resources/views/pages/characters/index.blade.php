@extends($meta->template)

@section('content')
    @livewire('characters:list')

    <x-tips section="characters" />
@endsection
