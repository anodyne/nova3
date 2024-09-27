@extends($meta->template)

@use('Nova\Departments\Models\Position')

@section('content')
    <x-page-header :$meta>
        <x-slot name="actions">
            @can('create', Position::class)
                <x-button :href="route('admin.positions.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:positions-list />

    <x-tips section="positions" />
@endsection
