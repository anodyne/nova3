@use('Nova\Stories\Models\PostType')

<x-admin-layout>
    <x-page-heading>
        @can('create', PostType::class)
            <x-slot name="actions">
                <x-button :href="route('admin.post-types.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            </x-slot>
        @endcan
    </x-page-heading>

    <livewire:post-types-list />

    <x-tips section="post-types" />
</x-admin-layout>
