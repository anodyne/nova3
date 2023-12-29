@extends($meta->template)

@use('Nova\Departments\Models\Position')

@section('content')
    <x-page-header>
        <x-slot name="heading">Positions</x-slot>
        <x-slot name="description">
            The jobs or stations characters are assigned to for display on your manifests
        </x-slot>

        <x-slot name="actions">
            @can('create', Position::class)
                <x-button :href="route('positions.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:positions-list />

    <x-tips section="positions" />
@endsection
