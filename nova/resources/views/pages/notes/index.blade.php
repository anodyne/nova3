@use('Nova\Notes\Models\Note')

<x-admin-layout>
    <x-page-heading>
        @can('create', Note::class)
            <x-slot name="actions">
                <x-button :href="route('admin.notes.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:notes-list />

    <x-tips section="notes" />
</x-admin-layout>
