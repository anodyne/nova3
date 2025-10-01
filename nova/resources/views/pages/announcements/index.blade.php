@use('Nova\Announcements\Models\Announcement')

<x-admin-layout>
    <x-page-heading>
        @can('create', Announcement::class)
            <x-slot name="actions">
                <x-button :href="route('admin.announcements.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:announcements-list />

    <x-tips section="announcements" />
</x-admin-layout>
