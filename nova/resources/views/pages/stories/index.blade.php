@use('Nova\Stories\Models\Story')

<x-admin-layout>
    <x-page-heading>
        <x-slot name="actions">
            <x-button :href="route('admin.stories.stories-timeline')">
                <x-icon :name="Tabler::TimelineEvent" size="sm" />
                Story timeline
            </x-button>

            @can('create', Story::class)
                <x-button :href="route('admin.stories.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-heading>

    <livewire:stories-list />

    <x-tips section="stories" />
</x-admin-layout>
