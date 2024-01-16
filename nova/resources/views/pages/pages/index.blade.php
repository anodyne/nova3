@extends($meta->template)

@use('Nova\Pages\Models\Page')

@section('content')
    <x-page-header>
        <x-slot name="heading">Pages</x-slot>
        <x-slot name="description">Control the content users can post into stories</x-slot>

        <x-slot name="actions">
            @can('create', Page::class)
                <x-button :href="route('pages.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:pages-list />

    <x-tips section="pages" />
@endsection
