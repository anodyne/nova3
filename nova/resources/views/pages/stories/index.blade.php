@use('Nova\Stories\Models\Story')

<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            <x-button :href="route('admin.stories.stories-timeline')" color="neutral">
                <x-icon :name="Icon::Timeline" size="sm"></x-icon>
                Story timeline
            </x-button>

            @can('create', Story::class)
                <x-button :href="route('admin.stories.create')" color="primary">
                    <x-icon :name="Icon::Plus" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:stories-list />

    <x-tips section="stories" />
</x-admin-layout>
