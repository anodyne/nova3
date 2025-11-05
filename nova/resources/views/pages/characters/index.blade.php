@use('Nova\Characters\Models\Character')

<x-admin-layout>
    <x-page-heading>
        @can('createAny', Character::class)
            <x-slot name="actions">
                <x-button :href="route('admin.characters.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:characters-list />

    <x-tips section="characters" />
</x-admin-layout>
