@extends($meta->template)

@use('Nova\Roles\Models\Role')

@section('content')
    <x-page-header>
        <x-slot name="heading">Permissions</x-slot>
        <x-slot name="description">View all of the available permissions in Nova</x-slot>

        <x-slot name="actions">
            @can('viewAny', Role::class)
                <x-button :href="route('admin.roles.index')" color="neutral">
                    <x-icon name="shield" size="sm"></x-icon>
                    View roles
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:permissions-list />

    <x-tips section="roles" />
@endsection
