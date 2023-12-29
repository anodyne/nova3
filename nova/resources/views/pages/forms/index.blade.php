@extends($meta->template)

@section('content')
    @livewire('forms:list')

    <x-tips section="forms" />
@endsection
