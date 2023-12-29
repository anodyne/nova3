@extends($meta->template)

@use('Nova\Stories\Models\Story')

@section('content')
    <x-page-header>
        <x-slot name="heading">Stories</x-slot>
        <x-slot name="description">Manage the stories and timeline of your game</x-slot>

        <x-slot name="actions">
            <x-button :href="route('stories.timeline', 'stories')" outline>
                <x-icon name="timeline" size="sm"></x-icon>
                Story timeline
            </x-button>

            @can('create', Story::class)
                <x-button :href="route('stories.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:stories-list />

    <x-tips section="stories" />
@endsection
