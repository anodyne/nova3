@extends($meta->template)

@section('content')
    <x-page-header></x-page-header>

    <livewire:applications-list />

    <x-tips section="applications"></x-tips>
@endsection
