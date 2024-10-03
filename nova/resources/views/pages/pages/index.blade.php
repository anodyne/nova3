@use('Nova\Pages\Models\Page')

<x-admin-layout>
    <x-page-header>
        @can('create', Page::class)
            <x-slot name="actions">
                <x-button :href="route('admin.pages.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:pages-list />

    <x-tips section="pages" />
</x-admin-layout>
