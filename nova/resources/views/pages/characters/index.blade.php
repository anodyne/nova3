@extends($meta->template)

@use('Nova\Characters\Models\Character')

@section('content')
    <x-page-header>
        <x-slot name="actions">
            @can('createAny', Character::class)
                <x-button :href="route('admin.characters.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:characters-list />

    <x-tips section="characters" />
@endsection
