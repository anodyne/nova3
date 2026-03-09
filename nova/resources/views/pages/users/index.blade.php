@use('Nova\Users\Models\User')

<x-admin-layout>
    <x-page-heading>
        <x-slot name="actions">
            @can('updateAny', User::class)
                <x-button :href="route('admin.user-moderation')">
                    <x-icon :name="Tabler::Forbid2" size="sm" />
                    Moderate users
                </x-button>
            @endcan

            @can('create', User::class)
                <x-button :href="route('admin.users.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-heading>

    <livewire:users-list />

    <x-tips section="users" />
</x-admin-layout>
