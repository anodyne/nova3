@extends($meta->template)

@use('Nova\Menus\Models\MenuItem')

@section('content')
    <x-page-header>
        <x-slot name="heading">Menu items</x-slot>
        <x-slot name="description">Manage the individual menu items for the public site</x-slot>

        <x-slot name="actions">
            @can('create', MenuItem::class)
                <x-button :href="route('admin.menu-items.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:menu-items-list />

    <x-tips section="menus"></x-tips>
@endsection
