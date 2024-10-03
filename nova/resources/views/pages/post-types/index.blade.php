@use('Nova\Stories\Models\PostType')

<x-admin-layout>
    <x-page-header>
        @can('create', PostType::class)
            <x-slot name="actions">
                <x-button :href="route('admin.post-types.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <livewire:post-types-list />

    <x-tips section="post-types" />
</x-admin-layout>
