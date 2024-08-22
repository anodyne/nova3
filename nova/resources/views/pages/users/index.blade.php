@extends($meta->template)

@use('Nova\Users\Models\User')

@section('content')
    <x-page-header>
        <x-slot name="heading">Users</x-slot>
        <x-slot name="description">Manage all of the game’s users</x-slot>

        <x-slot name="actions">
            @can('create', User::class)
                <x-button :href="route('admin.users.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:users-list />

    <x-tips section="users" />
@endsection
