@extends($meta->template)

@section('content')
    <x-page-header>
        <x-slot name="heading">Applications</x-slot>
        <x-slot name="description">Review applications and accept or reject new players and characters</x-slot>
    </x-page-header>

    <livewire:applications-list />

    <x-tips section="applications"></x-tips>
@endsection
