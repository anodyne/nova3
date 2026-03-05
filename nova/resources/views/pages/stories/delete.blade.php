<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', $storiesToDelete->first())
                <x-slot name="actions">
                    <x-button :href="route('admin.stories.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>
    </x-spacing>

    <livewire:stories-delete :stories="$storiesToDelete" />
</x-admin-layout>
