@use('Nova\Notes\Models\Note')

<x-admin-layout>
    <x-page-header>
        @can('create', Note::class)
            <x-slot name="actions">
                <x-button :href="route('admin.notes.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:notes-list />

    <x-tips section="notes" />
</x-admin-layout>
