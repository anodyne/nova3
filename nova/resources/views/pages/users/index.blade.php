@use('Nova\Users\Models\User')

<x-admin-layout>
    <x-page-header>
        @can('create', User::class)
            <x-slot name="actions">
                <x-button :href="route('admin.users.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:users-list />

    <x-tips section="users" />
</x-admin-layout>
