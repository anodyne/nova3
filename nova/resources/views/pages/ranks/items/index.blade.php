@extends($meta->template)

@use('Nova\Ranks\Models\RankItem')

@section('content')
    <x-page-header>
        <x-slot name="actions">
            @can('create', RankItem::class)
                <x-button :href="route('admin.ranks.items.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:rank-items-list />

    <x-tips section="ranks" />
@endsection
