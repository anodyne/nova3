@extends($meta->template)

@section('content')
    <x-page-header :$meta></x-page-header>

    <livewire:profile-notification-preferences />
@endsection
