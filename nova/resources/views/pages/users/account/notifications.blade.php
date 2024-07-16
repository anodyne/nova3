@extends($meta->template)

@section('content')
    <x-page-header>
        <x-slot name="heading">My notification preferences</x-slot>
    </x-page-header>

    <livewire:profile-notification-preferences />
@endsection
