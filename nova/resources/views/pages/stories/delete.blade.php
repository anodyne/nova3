<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', $storiesToDelete->first())
                <x-slot name="actions">
                    <x-button :href="route('admin.stories.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>
    </x-spacing>

    <livewire:stories-delete :stories="$storiesToDelete" />
</x-admin-layout>
