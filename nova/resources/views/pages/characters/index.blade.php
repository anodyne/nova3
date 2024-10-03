@use('Nova\Characters\Models\Character')

<x-admin-layout>
    <x-page-header>
        @can('createAny', Character::class)
            <x-slot name="actions">
                <x-button :href="route('admin.characters.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:characters-list />

    <x-tips section="characters" />
</x-admin-layout>
