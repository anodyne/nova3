@extends($meta->template)

@use('Nova\Ranks\Models\RankGroup')

@section('content')
    <x-page-header>
        <x-slot name="heading">Rank groups</x-slot>
        <x-slot name="description">Collections of related rank items for simpler searching and selecting</x-slot>

        <x-slot name="actions">
            @can('create', RankGroup::class)
                <x-button :href="route('ranks.groups.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:rank-groups-list />

    <x-tips section="ranks" />
@endsection
