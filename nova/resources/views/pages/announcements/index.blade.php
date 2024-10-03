@use('Nova\Announcements\Models\Announcement')

<x-admin-layout>
    <x-page-header>
        @can('create', Announcement::class)
            <x-slot name="actions">
                <x-button :href="route('admin.announcements.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add an announcement
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:announcements-list />

    <x-tips section="announcements"></x-tips>
</x-admin-layout>
