@extends($meta->template)

@use('Nova\Roles\Models\Role')

@section('content')
    <x-page-header>
        <x-slot name="heading">Roles</x-slot>
        <x-slot name="description">Control what users can do throughout Nova</x-slot>

        <x-slot name="actions">
            @can('viewAny', Role::class)
                <x-button :href="route('permissions.index')" color="neutral">
                    <x-icon name="key" size="sm"></x-icon>
                    View permissions
                </x-button>
            @endcan

            @can('create', Role::class)
                <x-button :href="route('roles.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:roles-list />

    <x-tips section="roles" />
@endsection
