@extends($meta->template)

@section('content')
    @livewire('departments:list')

    <x-tips section="departments"></x-tips>
@endsection
