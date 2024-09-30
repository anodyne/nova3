@extends($meta->template)

@use('Nova\Ranks\Models\RankName')

@section('content')
    <x-page-header>
        <x-slot name="actions">
            @can('create', RankName::class)
                <x-button :href="route('admin.ranks.names.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:rank-names-list />

    <x-tips section="ranks" />
@endsection
