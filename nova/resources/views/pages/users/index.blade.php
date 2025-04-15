@use('Nova\Users\Models\User')

<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            @can('updateAny', User::class)
                <x-button :href="route('admin.user-moderation')">
                    <x-icon name="forbid" size="sm"></x-icon>
                    Moderate users
                </x-button>
            @endcan

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
</x-admin-layout>
