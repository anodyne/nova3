@extends($meta->template)

@section('content')
    @if ($type === 'stories')
        <x-page-header>
            <x-slot name="heading">Stories timeline</x-slot>
            <x-slot name="description">Stories live on a timeline and provide important historical context</x-slot>
        </x-page-header>

        <livewire:stories-timeline />
    @else
        <x-page-header>
            <x-slot name="heading">Posts timeline</x-slot>
            <x-slot name="description">
                Posts follow a linear path that helps organize your story chronologically
            </x-slot>
        </x-page-header>

        <livewire:posts-timeline />
    @endif
@endsection
