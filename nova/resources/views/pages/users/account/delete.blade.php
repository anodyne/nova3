@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Delete my account</x-slot>
        </x-page-header>
    </x-spacing>

    <x-spacing constrained>
        <livewire:delete-my-account />
    </x-spacing>
@endsection
