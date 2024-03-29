@extends($meta->template)

@use('Nova\Characters\Models\Character')

@section('content')
    <x-page-header>
        <x-slot name="heading">Characters</x-slot>
        <x-slot name="description">Manage all of the game’s characters</x-slot>

        <x-slot name="actions">
            @can('createAny', Character::class)
                <x-button :href="route('characters.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:characters-list />

    <x-tips section="characters" />
@endsection
