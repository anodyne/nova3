@extends($meta->template)

@use('Nova\Pages\Models\Page')

@section('content')
    <x-page-header>
        <x-slot name="heading">Design page</x-slot>

        <x-slot name="actions">
            @can('viewAny', $page::class)
                <x-button :href="route('pages.index')" plain>&larr; Back</x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:pages-designer :page="$page" />
@endsection
