@extends($meta->template)

@use('Nova\Users\Models\User')

@section('content')
    <x-page-header :$meta>
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
