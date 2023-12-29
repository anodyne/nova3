@extends($meta->template)

@section('content')
    <x-page-header>
        <x-slot name="heading">Activity log</x-slot>
        <x-slot name="description">Track all user activity in Nova</x-slot>
    </x-page-header>

    <livewire:dashboard:activity-log-list />
@endsection
