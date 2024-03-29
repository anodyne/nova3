@extends($meta->template)

@use('Nova\Notes\Models\Note')

@section('content')
    <x-page-header>
        <x-slot name="heading">My notes</x-slot>

        <x-slot name="actions">
            @can('create', Note::class)
                <x-button :href="route('notes.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:notes-list />

    <x-tips section="notes" />
@endsection
