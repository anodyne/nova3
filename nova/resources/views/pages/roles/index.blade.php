@extends($meta->template)

@section('content')
    @livewire('roles:list')

    <x-tips section="roles" />
@endsection
