@use('Nova\Users\Models\User')

<x-admin-layout>
    <x-page-header>
        @can('viewAny', User::class)
            <x-slot name="actions">
                <x-button :href="route('admin.users.index')">
                    <x-icon name="users" size="sm"></x-icon>
                    Manage users
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:users-moderation-list />

    <x-tips section="users" />
</x-admin-layout>
