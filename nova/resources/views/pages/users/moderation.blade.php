@use('Nova\Users\Models\User')

<x-admin-layout>
    <x-page-heading>
        @can('viewAny', User::class)
            <x-slot name="actions">
                <x-button :href="route('admin.users.index')">
                    <x-icon :name="Tabler::Users" size="sm" />
                    Manage users
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:users-moderation-list />

    <x-tips section="users" />
</x-admin-layout>
