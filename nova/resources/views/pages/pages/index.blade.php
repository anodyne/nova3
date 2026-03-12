@use('Nova\Pages\Models\Page')

<x-admin-layout>
    <x-page-heading>
        @can('create', Page::class)
            <x-slot name="actions">
                <x-button :href="route('admin.pages.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:pages-list />

    <x-tips section="pages" />
</x-admin-layout>
