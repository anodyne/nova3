@extends($meta->template)

@use('Nova\Ranks\Models\RankItem')

@section('content')
    <x-page-header>
        <x-slot name="heading">Rank items</x-slot>
        <x-slot name="description">
            Combine the rank group, rank name, and rank images to define your game's ranks
        </x-slot>

        <x-slot name="actions">
            @can('create', RankItem::class)
                <x-button :href="route('ranks.items.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:rank-items-list />

    <x-tips section="ranks" />
@endsection
