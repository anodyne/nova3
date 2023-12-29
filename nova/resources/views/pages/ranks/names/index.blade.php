@extends($meta->template)

@use('Nova\Ranks\Models\RankName')

@section('content')
    <x-page-header>
        <x-slot name="heading">Rank names</x-slot>
        <x-slot name="description">Re-use basic rank information across all of your rank items</x-slot>

        <x-slot name="actions">
            @can('create', RankName::class)
                <x-button :href="route('ranks.names.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:rank-names-list />

    <x-tips section="ranks" />
@endsection
