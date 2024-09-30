@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header></x-page-header>

        <livewire:delete-my-account />
    </x-spacing>
@endsection
